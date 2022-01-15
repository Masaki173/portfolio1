<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\SoftDeletes;
class Tip extends Model
{
    use SoftDeletes;
    protected $fillable = ['user_id', 'post_id', 'comment', 'price'];

    public function Post()
    {
      return $this->belongsTo('App\Models\Post');
    }

    public function User()
    {
      return $this->belongsTo('App\Models\User');
    }
}
