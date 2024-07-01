<?php

namespace App\Models;

use App\Observers\MovieObserver;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


#[ObservedBy(MovieObserver::class)]
class Movie extends Model
{
    use HasFactory;

    protected $guarded =['id'];

    public function images(){

        return $this->hasMany(MovieImage::class);

    }

    public function genres(){

        return $this->belongsToMany(Genre::class, MovieGenre::class);
        
    }
    public function movieGenre(){

        return $this->hasmany(MovieGenre::class);
    }

    public function countries(){

        return $this->hasMany(MovieCountry::class);
    }
    public function casts(){

        return $this->hasmany(Cast::class);
    }
   

    public function actores(){

        return $this->hasManyThrough(Actor::class,Cast::class);

    }

    

    


}
