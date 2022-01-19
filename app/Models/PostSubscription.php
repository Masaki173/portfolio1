<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PostSubscription extends Model
{
  protected $fillable = ['user_id', 'post_id'];

  public function Post()
  {
    return $this->belongsTo('App\Models\Post');
  }

  public function User()
  {
    return $this->belongsTo('App\Models\User');
  }
}
