<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovieCast extends Model
{
    use HasFactory;

    protected $guarded =['id'];

    public function casts(){
        return $this->hasone(Cast::class, 'id', 'cast_id');
    }
}
