<?php

namespace App\Http\Controllers;

use App\Constants;
use App\Models\Application;
use App\Models\HousingModel;
use App\Models\Message;
use App\Models\Subdivision;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function getOverview(Request $request)
    {
        $data = [];

        $data['total_users'] = User::all()->count();
        $data['total_applications'] = Application::all()->count();
        $data['total_subdivisions'] = Subdivision::all()->count();
        $data['total_housing_models'] = HousingModel::all()->count();

        return response()->json($data);
    }

    public function getApplicationStats()
    {

        $data = [];

        $data['counted'] = DB::table('applications')
            ->select(
                DB::raw('(COUNT(*)) as count, status'),
            )
            ->groupBy('status')
            ->get();

        $data['yearly'] = DB::table('applications')
            ->select(
                DB::raw('(COUNT(*)) as count'),
                DB::raw("DATE_FORMAT(created_at, '%Y') as label"),
            )
            ->groupBy('label')
            ->get();

        $data['monthly'] = DB::table('applications')
            ->select(
                DB::raw('(COUNT(*)) as count'),
                DB::raw("DATE_FORMAT(created_at, '%M') as label"),
                DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month")
            )->whereDate('created_at', '>=', now()->startOfYear())
            ->groupBy('month', 'label')
            ->get();

        $data["weekly"] = DB::table('applications')->select(
            DB::raw("COUNT(*) as count"),
            DB::raw("DAYNAME(created_at) as label"),
            DB::raw("DATE_FORMAT(created_at, '%m-%d') as day"),
        )->whereDate('created_at', '>=', now()->subDays(7)->startOfDay())
            ->groupBy('day', "label")
            ->get();

        $data["daily"] = DB::table('applications')->select(
            DB::raw("COUNT(*) as count"),
            DB::raw("DATE_FORMAT(created_at, '%H:00') as label"),
        )->whereDate('created_at', '>=', now()->startOfDay())
            ->groupBy('label')
            ->get();

        return response()->json($data);
    }

    public function getUserJoiningStats()
    {
        $data = [];

        $data["yearly"] = DB::table('users')->select(
            DB::raw("COUNT(*) as count"),
            DB::raw("DATE_FORMAT(created_at, '%Y') as label"),
        )->groupBy('label')
            ->get();

        $data["monthly"] = DB::table('users')->select(
            DB::raw("COUNT(*) as count"),
            DB::raw("MONTHNAME(created_at) as label"),
            DB::raw("DATE_FORMAT(created_at, '%Y-%m') as month"),
        )->whereDate('created_at', '>=', now()->startOfYear())
            ->groupBy('month', "label")
            ->get();

        $data["weekly"] = DB::table('users')->select(
            DB::raw("COUNT(*) as count"),
            DB::raw("DAYNAME(created_at) as label"),
            DB::raw("DATE_FORMAT(created_at, '%m-%d') as day"),
        )->whereDate('created_at', '>=', now()->subDays(7)->startOfDay())
            ->groupBy('day', "label")
            ->get();

        $data["daily"] = DB::table('users')->select(
            DB::raw("COUNT(*) as count"),
            DB::raw("DATE_FORMAT(created_at, '%H:00') as label"),
        )->whereDate('created_at', '>=', now()->startOfDay())
            ->groupBy('label')
            ->get();

        return response()->json($data);
    }

    public function getMessageStats()
    {
        $data = [];

        $data['all'] = DB::table('messages')
            ->select(
                DB::raw("COUNT(*) as count"),
                DB::raw('status as st')
            )
            ->groupBy('st')
            ->get();

        $data['last30'] = DB::table('messages')
            ->select(
                DB::raw("COUNT(*) as count"),
                DB::raw('status as st')
            )->whereDate('created_at',
                '>=',
                now()->subDays(30)->startOfDay())
            ->groupBy('st')
            ->get();

        $data['last7'] = DB::table('messages')
            ->select(
                DB::raw("COUNT(*) as count"),
                DB::raw('status as st')
            )
            ->whereDate(
                'created_at',
                '>=',
                now()->subDays(7)->startOfDay(),
            )->groupBy('st')
            ->get();

        $data['today'] = DB::table('messages')
            ->select(
                DB::raw("COUNT(*) as count"),
                DB::raw('status as st')
            )
            ->whereDate(
                'created_at',
                '>=',
                now()->startOfDay(),
            )->groupBy('st')
            ->get();

        return response()->json($data);
    }

    public function getSupportTicketStats()
    {
        $data = [];

        $data['all'] = DB::table('support_conversations')
            ->select(
                DB::raw("COUNT(*) as count"),
                DB::raw('status as st')
            )
            ->groupBy('st')
            ->get();

        $data['last30'] = DB::table('support_conversations')
            ->select(
                DB::raw("COUNT(*) as count"),
                DB::raw('status as st')
            )->whereDate('created_at',
                '>=',
                now()->subDays(30)->startOfDay())
            ->groupBy('st')
            ->get();

        $data['last7'] = DB::table('support_conversations')
            ->select(
                DB::raw("COUNT(*) as count"),
                DB::raw('status as st')
            )
            ->whereDate(
                'created_at',
                '>=',
                now()->subDays(7)->startOfDay(),
            )->groupBy('st')
            ->get();

        $data['today'] = DB::table('support_conversations')
            ->select(
                DB::raw("COUNT(*) as count"),
                DB::raw('status as st')
            )
            ->whereDate(
                'created_at',
                '>=',
                now()->startOfDay(),
            )->groupBy('st')
            ->get();

        return response()->json($data);
    }

    public function getSubdivisionStats()
    {
        $data = DB::table('subdivisions')
            ->select(
                DB::raw('(COUNT(*)) as count'),
                DB::raw('location as location')
            )->groupBy('location')
            ->get();

        return response()->json($data);
    }
}
