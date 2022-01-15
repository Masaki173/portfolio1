<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
  protected $fillable = ['user_id', 'post_id', 'content'];

    public function Post()
    {
      return $this->belongsTo('App\Models\Post');
    }

    public function User()
    {
      return $this->belongsTo('App\Models\User');
    }
}
