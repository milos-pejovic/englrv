<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', 'HomeController@index');
Route::post('/search-exercise', 'ExerciseController@search');
Route::get('/ex/{public_id}', 'ExerciseController@single');

Route::get('/e', 'ExerciseController@search');

// Route::get('/ex', function() {
//     $ex = App\Exercise::paginate(5);

//     return view('test')->with('ex', $ex);
// });

// Route::get('/x', function() {
//     $e = App\Exercise::with('user')->first()->toArray();


//     dd($e);
// });


Route::get('/t', function() {
    // $location = '../database/seeds/exercises/';
    // $contents = scandir($location);

    // foreach($contents as $file) {
    //     if ($file == '.' || $file == '..'){
    //         continue;
    //     }

    //     $ex[] = file_get_contents($location . $file);
    // }

    // echo($ex[0]);
});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
