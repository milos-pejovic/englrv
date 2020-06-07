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

Route::get('/ex', function() {
    $ex = App\Exercise::paginate(5);

    return view('test')->with('ex', $ex);
});

Route::get('/x', function() {
    $e = App\Exercise::with('user')->first()->toArray();


    dd($e);
});


Route::get('/t', function() {
    $es = App\Exercise::all();

    foreach($es as $e) {
        echo '<h1>'.$e->title.'</h1>';
        echo '<p>Language: ' . $e->language . '</p>';

        foreach($e->tags as $tag) {
            echo '<span style="background-color: lightgray; display: inline-block; margin: 5px; padding: 3px 6px"> ' . $tag->name . ' </span>';
        }
        echo '<hr />';
    }

    // $tagsObj = App\Tag::all();
    // $tags = [];

    // foreach($tagsObj as $tagObj) {
    //     $tags[] = $tagObj;
    // }

    // dd($tags);

});
Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
