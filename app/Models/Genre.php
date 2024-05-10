<?php

namespace App\Models;

use App\Observers\GenreObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Attributes\ObservedBy;

use Illuminate\Database\Eloquent\Model;


#[ObservedBy(GenreObserver::class)]

class Genre extends Model
{
    use HasFactory;

    protected $guarded =['id'];
}
