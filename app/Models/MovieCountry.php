<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovieCountry extends Model
{
    use HasFactory;

    public function country(){
        return $this->hasMany(Movie::class, '', 'movie_id');
    }
}
