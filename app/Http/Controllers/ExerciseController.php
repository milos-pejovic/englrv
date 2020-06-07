<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Exercise;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use App\Rules\ValidLevels;

class ExerciseController extends Controller
{
    /**
     * 
     */
    public function search(Request $request) {

        $validator = Validator::make($request->all(), [
            'title' => [],
            'author' => [],
            'tags' => [],
            'levels' => [new ValidLevels()], // Make custom validator
            'results_per_page' => ['numeric'],
            'order_by' => [Rule::in(['id', 'title', 'author', 'level'])],
        //     // 'order_by' => ['numeric'],
            'sorting_direction' => [Rule::in(['ASC', 'DESC'])]
        ]);

        if ($validator->fails()) {
            echo 'Invalid form data';
            return false;
        }
        
        $title = $request->exercise_title;
        $author = $request->exercise_author;
        $tags = explode(',', $request->tags);
        $levels = $request->levels;

        $resultsPerPage = $request->results_per_page;
        $orderBy = $request->order_by;
        $sortingDirection = $request->sorting_direction;

        // $query = Exercise::select(['id', 'title', 'public_id', 'language', 'level', 'user_id'])
        //     ->with(['tags', 'user']);

        $query = Exercise::select([
                'exercises.id', 
                'exercises.title', 
                'exercises.public_id', 
                // 'exercises.language', 
                'exercises.level', 
                'exercises.user_id',
                'users.username as author'
            ])
            ->join('users', 'exercises.user_id', '=', 'users.id')
            ->where('active', '1')
            ->with(['tags']);
  
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
            // $query->whereHas('user', function($query) use ($author) {
            //     $query->where('username', 'LIKE', '%' . $author . '%');
            // });
            $query->where('users.username', 'LIKE', '%' . $author . '%');
        }

        if ($levels) {
            $query->whereIn('level', $levels);
        }

        $exercises = $query
            ->orderBy($orderBy, $sortingDirection)
            ->paginate($resultsPerPage)
            ->onEachSide(1);

        $data['exercises'] = $exercises;
        $links = (array)$exercises->links();
        $links = array_values($links)[3]['elements'];
        $data['links'] = $links;
        $data = json_encode($data);
        echo $data;
        return false;
    }

    /**
     * 
     */
    public function single($public_id) {
        $exercise = Exercise::where('public_id', $public_id)
            ->with('user')
            ->get()[0];
        return view('exercises/single')->with('exercise', $exercise);
    }
}
