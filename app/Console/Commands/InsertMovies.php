<?php

namespace App\Console\Commands;

use App\Models\Actor;
use App\Models\Cast;
use App\Models\Genre;
use App\Models\Movie;
use App\Models\MovieGenre;
use App\Models\MovieImage;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Ramsey\Uuid\Uuid;

class InsertMovies extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:insert-movies';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     */
    public function handle()
    {

        $currentPage = 1;

        $maxPage = 250;

        $response = Http::get('https://moviesapi.ir/api/v1/movies?page=' . $currentPage);

        $movies = $response->json()['data'];


        foreach ($movies as $movie) {

            $poster = isset($movie['poster']) ? $this->storeImage($movie['poster'], $movie['title'], 'poster') : null;
            $Sequence = MovieImage::all()->where('movie-id', $movie['id']);
            $createdMovies = Movie::create([

                'title' => $movie['title'],
                'poster' => $poster,
                'year' => $movie['year'],
                'country' => $movie['country'],
                'imdb_rating' => $movie['imdb_rating'],
                'images' => $Sequence,

            ]);
            

            foreach ($movie['genres'] as $genre) {

                $createdGenres = Genre::firstOrCreate([

                    'name' => $genre,
                    'slug' => Str::slug($genre)
                ]);

                MovieGenre::create([

                    'movie_id' => $createdMovies->id,
                    'genre_id' => $createdGenres->id,
                ]);
            }

            foreach ($movie['images'] as $image) {
                $imagePath = $this->storeImage($image, $movie['title'], Uuid::uuid4()->toString());

                MovieImage::create([
                    'movie_id' => $createdMovies->id,
                    'image' => $imagePath
                ]);
            }


            foreach($movie['casts'] as $cast){
                $actores = Cast::get($cast['actores']);

                $createdCasts= Cast::create([
                    'name' => $cast->name,
                    'role' => $cast->role
                ]);
                 foreach ($cast['actores'] as $actor){

                    Actor::create([

                        'movie-id'=>$createdMovies->id,
                        'cast-id' => $createdCasts->id
                    ]);
                 }

            }
        }


        // $this->info('Done');
         $this->info('Movies Added Successfully');

    }

    public function storeImage($image, $title, $name)
    {

        $image = file_get_contents($image);

        $path = Str::slug($title) . '/' . $name . '.jpg';

        Storage::put('public/' . $path, $image);


        return $path;
    }
}
