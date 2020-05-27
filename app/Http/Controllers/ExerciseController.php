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
        
        $title = $request->exercise_title;
        $author = $request->exercise_author;
        $tags = explode(',', $request->tags);
        $levels = $request->levels;

        $query = Exercise::select(['id', 'title', 'public_id', 'language', 'level', 'user_id'])
            ->with(['tags', 'user']);
            // ->where('exercises.id', '<', 100);
            
        if ($levels) {
            $query->whereIn('level', $levels);
        }

        if ($title) {
            $query->where('title', 'LIKE', '%' . $title . '%');
        }

        if ($tags) {
            foreach($tags as $tag) {
                $query->whereHas('tags', function($query) use ($tag) {
                    $query->where('name', 'LIKE' , '%' . trim($tag) . '%');
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

        $exercises = $query->get()->take(20)->toArray();
        $exercises = json_encode($exercises);
        echo $exercises;
    }
}
