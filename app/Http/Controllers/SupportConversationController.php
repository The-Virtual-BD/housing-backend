<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSupportConversation;
use App\Http\Requests\StoreSupportMessage;
use App\Models\SupportConversation;
use App\Models\SupportMessage;
use Illuminate\Http\Request;

class SupportConversationController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        if ($request->has('id') && $request->id) {
            return SupportConversation::where('id', $request->id)->get();
        } else {
            return response()->json(SupportConversation::all());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSupportConversation $request)
    {
        $validated = $request->validated();

        $conversation = auth()->user()->support_conversations()->create([
            'language' => $validated['language'],
            'fname' => $validated['fname'],
            'lname' => $validated['lname'],
            'email' => $validated['email'],
            'subject' => $validated['subject'],
        ]);

        $message = SupportMessage::create([
            'support_conversation_id' => $conversation->id,
            'message' => $validated['description'],
            'senderable_type' => get_class(auth()->user()),
            'senderable_id' => auth()->id()
        ]);

        if ($request->has('attachment')) {
            $message->addMedia($request->file('attachment'))->toMediaCollection('attachments');
        }

        return response()->json($conversation);
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show(SupportConversation $supportConversation)
    {
        //todo add auth check for specific convo

        $conversation = $supportConversation->load('support_messages');

        return response()->json($conversation);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(SupportConversation $supportConversation)
    {
        $supportConversation->delete();

        return response()->json(['message' => 'Deleted']);
    }

    public function sendMessage(StoreSupportMessage $request, $conversation_id)
    {
        $conversation = SupportConversation::find($conversation_id);
        //todo: add proper authentication

        $message = SupportMessage::create([
            'support_conversation_id' => $conversation_id,
            'message' => $request->message,
            'senderable_type' => get_class(auth()->user()),
            'senderable_id' => auth()->id()
        ]);

        if ($request->has('attachment')) {
            $message->addMedia($request->file('attachment'))->toMediaCollection('attachments');
        }

        //if multiple
//        if($request->has('attachment')){
//            foreach ($request->file('attachments') as $photo){
//                $message->addMedia($photo)->toMediaCollection('attachments');
//            }
//        }

        $conversation->updated_at = now();
        $conversation->status = isUser() ? 'active' : 'waiting';
        $conversation->save();

        return response()->json($message->load('senderable'));
    }

    public function myHistory(Request $request)
    {
        if($request->has('id') && $request->id){
            return response()->json(auth()->user()->support_conversations()->where('id', $request->id)->paginate(20));
        }else{
            return response()->json(auth()->user()->support_conversations()->paginate(20));
        }
    }

    public function resolveConversation($conversation)
    {
        $conversation = SupportConversation::find($conversation);
        if (!$conversation) abort(404);

        //todo: add proper authentication

        $conversation->status = 'solved';
        $conversation->save();

        return response()->json(['Solved']);
    }
}
