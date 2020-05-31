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

        // $exercises = $query->get()->take(20);

        $exercises = $query->paginate(20);
        $data['exercises'] = $exercises;
        $links = (array)$exercises->links();
        $links = array_values($links)[3]['elements'];
        $data['links'] = $links;
        
        $data = json_encode($data);
        echo $data;
    }

    /**
     * 
     */
    public function single($public_id) {
        $exercise = Exercise::where('public_id', $public_id)->get()[0];
        return $exercise->title;
    }
}
