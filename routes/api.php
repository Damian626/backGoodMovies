<?php
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\Subcription\Subcription;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\webhook\WebHookController;
use App\Http\Controllers\Admin\User\UsersController;
use App\Http\Controllers\Streaming\HomeMovieController;
use App\Http\Controllers\Streaming\HomeVideoController;
use App\Http\Controllers\Streaming\HomeReviewController;
use App\Http\Controllers\Streaming\HomeTvShowController;
use App\Http\Controllers\Streaming\AuthStreamingController;
use App\Http\Controllers\Streaming\HomeStreamingController;
use App\Http\Controllers\Streaming\ProfileClienteController;
use App\Http\Controllers\Admin\Streaming\StreamingController;
use App\Http\Controllers\Admin\Streaming\StreamingTagController;
use App\Http\Controllers\Admin\Subcription\SubcriptionController;
use App\Http\Controllers\Admin\Streaming\StreamingActorController;
use App\Http\Controllers\Admin\Streaming\StreamingGenresController;
use App\Http\Controllers\Admin\Streaming\StreamingSeasonController;
use App\Http\Controllers\Admin\ProductAndPlanes\PlanPaypalController;
use App\Http\Controllers\Admin\Streaming\StreamingEpisodesController;
use App\Http\Controllers\Admin\ProductAndPlanes\ProductPaypalController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
 
Route::group([
 
    'middleware' => 'api',
    'prefix' => 'auth'
 
], function ($router) {
    Route::post('/register', [AuthController::class, 'register'])->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login_ecommerce', [AuthController::class, 'login_ecommerce'])->name('login_ecommerce');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::post('/refresh', [AuthController::class, 'refresh'])->name('refresh');
    Route::post('/me', [AuthController::class, 'me'])->name('me');
});

// MIS RUTAS PARA EL ADMIN
Route::group([
    'middleware' => 'auth:api',
], function ($router) {
    Route::resource("users",UsersController::class);
    Route::post("users/{id}",[UsersController::class,"update"]);
    Route::resource("products",ProductPaypalController::class);
    Route::resource("planes",PlanPaypalController::class);
    Route::resource("genres",StreamingGenresController::class);
    Route::post("genres/{id}",[StreamingGenresController::class,"update"]);
    Route::resource("actors",StreamingActorController::class);
    Route::post("actors/{id}",[StreamingActorController::class,"update"]);
    Route::resource("tags",StreamingTagController::class);

    Route::get("streaming/config_all",[StreamingController::class,"config_all"]);
    Route::resource("streaming",StreamingController::class);
    Route::get("subcription/config_all",[SubcriptionController::class,"config_all"]);
    Route::resource("subcription",SubcriptionController::class);
    // streaming/{id}
    Route::post("streaming/{id}",[StreamingController::class,"update"]);
    Route::post("streaming/upload_video/{id}",[StreamingController::class,"upload_video"]);
    Route::post("streaming/upload_video_contenido/{id}",[StreamingController::class,"upload_video_contenido"]);
    Route::resource("streaming_season",StreamingSeasonController::class);
    Route::resource("streaming_episode",StreamingEpisodesController::class);
    Route::post("streaming_episode/{id}",[StreamingEpisodesController::class,"update"]);
    Route::post("streaming_episode/upload_video/{id}",[StreamingEpisodesController::class,"upload_video"]);
});
// Route::group(["prefix" => "admin"], function($router){
// });

Route::group(["prefix" => "streaming_public"], function($router){
    Route::get("config_all",[HomeStreamingController::class,"config_all"]);
    Route::post("valid_register",[AuthStreamingController::class,"valid_register"]);
    Route::post("register",[AuthStreamingController::class,"register"]);
    Route::post("login_streaming",[AuthStreamingController::class,"login_streaming"]);
    Route::post("login_streaming_addtional",[AuthStreamingController::class,"login_streaming_addtional"]);

    Route::get("home",[HomeStreamingController::class,"home"]);

    Route::group([
        'middleware' => 'confirmation',//'auth:api',
    ], function ($router) {
        Route::get("show-streaming/{slug}",[HomeStreamingController::class,"show_streaming"]);
        Route::get("movie/home",[HomeMovieController::class,"home"]);
        Route::get("tv-show/home",[HomeTvShowController::class,"home"]);
        Route::get("videos/home",[HomeVideoController::class,"home"]);

        Route::resource("review",HomeReviewController::class);
        // 

        Route::get("genres",[HomeStreamingController::class,"genres"]);
        Route::post("filter_genres",[HomeStreamingController::class,"filter_genres"]);
        Route::get("tags",[HomeStreamingController::class,"tags"]);
        Route::post("filter_tags",[HomeStreamingController::class,"filter_tags"]);
        // 
        Route::get("profile_client",[ProfileClienteController::class,"get_profile_client"]);
        Route::put("profile_client",[ProfileClienteController::class,"profile_client"]);
        Route::post("cancel_subcription",[ProfileClienteController::class,"cancel_subcription"]);
    });
});

Route::group(["prefix" => "webhook"], function($router){
    Route::post("cancelled",[WebHookController::class,"cancelled"]);
    Route::post("payment",[WebHookController::class,"payment"]);
});