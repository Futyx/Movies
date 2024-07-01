<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovieCast extends Model
{
    use HasFactory;

    protected $guarded =['id'];

    public function casts(){
        return $this->hasMany(Cast::class, 'id', 'cast_id');
    }
    public function movie(){
        return $this->hasOne(Movie::class, 'id', 'cast_id');
    }
}
