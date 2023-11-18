<?php

namespace App\Http\Controllers\Streaming;

use Illuminate\Http\Request;
use App\Models\Streaming\Streaming;
use App\Http\Controllers\Controller;
use App\Http\Resources\StreamingFronted\StreamingHomeCollection;

class HomeTvShowController extends Controller
{
    function home() {
        $slider_home = Streaming::where("state",2)->where("type",2)->inRandomOrder()->limit(3)->get();

        $last_movies_a = Streaming::where("state",2)->where("type",2)->inRandomOrder()->limit(5)->get();
        $last_movies_b = Streaming::where("state",2)->where("type",2)->inRandomOrder()->limit(5)->get();
        $last_movies_c = Streaming::where("state",2)->where("type",2)->inRandomOrder()->limit(5)->get();

        return response()->json([
            "slider_home" => StreamingHomeCollection::make($slider_home),

            "last_movies_a" => StreamingHomeCollection::make($last_movies_a),
            "last_movies_b" => StreamingHomeCollection::make($last_movies_b),
            "last_movies_c" => StreamingHomeCollection::make($last_movies_c),
        ]);
    }
}
