<?php

namespace App\Models;

use App\Traits\LoginTrait;
use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class User extends Authenticatable implements CanResetPassword, HasMedia
{
    use HasFactory, Notifiable, LoginTrait, InteractsWithMedia;

    protected $guarded = [];
    protected $hidden = ['password'];
    protected static $guardName = 'user';
    protected $with = ['media'];

    public function applications(){
        return $this->hasMany(Application::class);
    }

    public function support_conversations(){
        return $this->hasMany(SupportConversation::class);
    }
}
