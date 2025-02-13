<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Movie extends Model
{
    public function favoritedBy(){
        return $this->belongsToMany(User::class, 'favorites', 'movie_id','user_id')->withTimestamps();;
    }
}
