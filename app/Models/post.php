<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class post extends Model
{
     protected $table = 'posts'; 
     protected $fillable = ['name', 'price', 'image','user_id'];
public function User()
    {
        return $this->belongsTo(User::class);
    }
}