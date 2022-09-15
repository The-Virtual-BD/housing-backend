<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Application extends Model implements HasMedia
{
    use HasFactory, InteractsWithMedia;

    public const STATUS_SUBMITTED = 'submitted';
    public const STATUS_REVIEWING = 'reviewing';
    public const STATUS_RESUBMIT = 'resubmit';
    public const STATUS_APPROVED = 'approved';
    public const STATUS_DECLINED = 'declined';


    protected $fillable = [
        'user_id',
        'subdivision_id',
        'housing_model_id',
        'forwardable_type',
        'forwardable_id',
        'approvable_type',
        'approvable_id',
        'fname',
        'lname',
        'nib_no',
        'email',
        'dob',
        'phone',
        'gender',
        'country_of_birth',
        'island_of_birth',
        'country_of_citizenship',
        'house_no',
        'street_address',
        'po_box',
        'island',
        'country',
        'home_phone',
        'passport_no',
        'passport_expiry',
        'driving_licence_no',
        'employer',
        'industry',
        'position',
        'work_phone',
        'status',
        'comments',
    ];

    protected $guarded = [];

    protected $with = ['media'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subdivision(){
        return $this->belongsTo(Subdivision::class);
    }

    public function housingModel(){
        return $this->belongsTo(HousingModel::class);
    }

    public function forwarder(){
        return $this->morphTo('forwardable');
    }

    public function approver(){
        return $this->morphTo('approvable');
    }
}
