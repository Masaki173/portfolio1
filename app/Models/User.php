<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable 
{
    use HasApiTokens, HasFactory, Notifiable;

    use SoftDeletes;
    use \Askedio\SoftCascade\Traits\SoftCascadeTrait;

    protected $softCascade =['posts', 'post_subscriptions', 'tips'];

    protected $fillable = [
        'id',
        'name',
        'email',
        'password',
        'icon',
        'profile',
        'stripe_code',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    public function accounts(){
    return $this->hasMany('App\Models\LinkedSocialAccount');
    }
    
    public function follows()
    {
        return $this->belongsToMany('App\Models\User', 'follower_user', 'follower_id', 'user_id');
    }

    public function followers()
    {
        return $this->belongsToMany('App\Models\User', 'follower_user', 'user_id', 'follower_id');
    }
    public function posts()
    {
      return $this->hasMany('App\Models\Post');
    }
    public function likes()
    {
      return $this->hasMany('App\Models\Like');
    }
    public function comments()
    {
        return $this->hasMany('App\Models\Comment');
    }
    public function post_subscriptions(){
         return $this->hasMany('App\Models\PostSubscription');
    }
    public function tips()
    {
        return $this->hasMany('App\Models\Tip');
    }
}
