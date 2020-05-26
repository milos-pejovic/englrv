<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exercise;

class ExerciseController extends Controller
{
    /**
     * 
     */
    public function search(Request $request) {

        // TODO: Validate input
        
        $author = $request->exercise_author;
        $tags = $request->tags;
        $levels = $request->levels;

        $tags= str_replace(' ', '', $tags);
        $tags = explode(',', $tags);

        $query = Exercise::select(['id', 'title', 'public_id', 'language', 'level', 'user_id'])
            ->with(['tags', 'user']);
            // ->where('exercises.id', '<', 100);
            
        if ($tags) {
            foreach($tags as $tag) {
                $query->whereHas('tags', function($query) use ($tag) {
                    $query->where('name', 'LIKE' , '%' . $tag . '%');
                });
            }
        }    

        if ($author) {
            $query->whereHas('user', function($query) use ($author) {
                $query->where('username', 'LIKE', '%' . $author . '%');
            });
        }

        if ($levels) {
            $query->whereIn('level', $levels);
        }

        $exercises = $query->get()->toArray();
        $exercises = json_encode($exercises);
        echo $exercises;
    }
}
