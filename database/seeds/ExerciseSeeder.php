<?php

use Illuminate\Database\Seeder;
use App\Tag;
use App\User;
use App\Exercise;
use Faker\Factory as Faker;

class ExerciseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $tags = Tag::pluck('id');
        $usersObj = User::pluck('id');
        $levels = ['a1', 'a2', 'b1', 'b2', 'c1', 'c2'];
        $languages = ['english', 'german'];
        $tagsObj = Tag::all();
        $tags = [];

        foreach($tagsObj as $tagObj) {
            $tags[] = $tagObj;
        }

        foreach($usersObj as $userObj) {
            $users[] = $userObj;
        }

        for ($i = 0; $i < 1200; $i++) {
            $exercise = Exercise::create([
                // 'title' => $faker->sentence,
                'title' => 'Indefinite articles',
                'level' => $levels[array_rand($levels)],
                'public_id' => ($i + 100),
                'user_id' => $users[array_rand($users)],
                'active' => rand(0, 1),
                'language' => $languages[array_rand($languages)],
                'json' => '{
                    "segments" : [
                        {
                            "type" : "hero-image",
                            "image-name" : "Image-name.jpg" 
                        },
                        {
                            "type" : "text",
                            "text" : "Write <b>a</b> or <b>an</b> on the lines as needed."
                        },
                        {
                            "type" : "text-questions",
                            "questions" : [
                            
                                {
                                    "text" : "I once met ###1### man. ###2### man had a car.",
                                    "image" : {},
                                    "example" : true,
                                    "answers" : {
                                        "1" : ["a", "one"],
                                        "2" : ["the", "this"]
                                    }
                                },
                                
                                {
                                    "text" : "I once met ###1### man. ###2### man had a car.",
                                    "image" : {},
                                    "example" : false,
                                    "answers" : {
                                        "1" : ["a", "one"],
                                        "2" : ["the", "this"]
                                    }
                                }
                                
                            ]
                        }
                    ]
                }'
            ]);

            $numberOfTags = rand(1, 7);
            $allTags = $tags;
            $exerciseTags = [];

            for ($j = 0; $j < $numberOfTags; $j++) {
                $tagIndex = rand(0, (count($allTags) - 1));
                $exerciseTags[] = $allTags[$tagIndex];
                unset($allTags[$tagIndex]);
                $allTags = array_values($allTags);
            }

            $exercise->tags()->saveMany($exerciseTags);
        }
    }
}
