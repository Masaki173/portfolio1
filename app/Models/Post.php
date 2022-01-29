<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
  use SoftDeletes;
  use \Askedio\SoftCascade\Traits\SoftCascadeTrait;
  protected $softCascade =['post_subscriptions', 'tips'];
    protected $guarded = array('id');

    public function user()
    {
      return $this->belongsTo('App\Models\User');
    }
    public function likes()
    {
      return $this->hasMany('App\Models\Like');
    }
    public function is_liked_by_auth_user()
    {
      $id = Auth::id();
  
      $likers = array();
      foreach($this->likes as $like) {
        array_push($likers, $like->user_id);
      }
  
      if (in_array($id, $likers)) {
        return true;
      } else {
        return false;
      }
    }
    public function comments(){
        return $this->hasMany('App\Models\Comment');
    }
    public function tips(){
        return $this->hasMany('App\Models\Tip');
    }
    public function scopeCategory_filter($query, ?integer $category_id){
      if (!is_null($category_id)) {
            return $query->where('category_code', $category_id);
             }
    }
    public function post_subscriptions(){
      return $this->hasMany('App\Models\PostSubscription');
    }
    public function is_subscribed_by_auth_user(){
      $id = Auth::id();

      $subscribers = array();
      foreach($this->subscriptions as $subscription) {
        array_push($subscribers, $subscription->user_id);
      }
      if (in_array($id, $subscribers)) {
        return true;
      } else {
        return false;
      }
    }
    public function is_tipped_by_auth_user(){
      $id = Auth::id();

      $tippers = array();
      foreach($this->tips as $tip) {
        array_push($tippers, $tip->user_id);
      }
      if (in_array($id, $tippers)) {
        return true;
      } else {
        return false;
      }
    }
}
