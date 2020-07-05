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

        $exercisesJson = $this->getExJson();

        $k = 0;
        for ($i = 0; $i < 1200; $i++) {

            if ($k == count($exercisesJson)){
                $k = 0;
            }

            $exercise = Exercise::create([
                // 'title' => $faker->sentence,
                'title' => 'Exercise ' . $k,
                'level' => $levels[array_rand($levels)],
                'public_id' => ($i + 100),
                'user_id' => $users[array_rand($users)],
                'active' => rand(0, 1),
                'language' => $languages[array_rand($languages)],
                'json' => $exercisesJson[$k++]
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

    /**
     * 
     */
    private function getExJson() {
        $location = getcwd() . '/database/seeds/exercises';
        $contents = scandir($location);
        $exJson = [];

        foreach($contents as $file) {
            if ($file == '.' || $file == '..'){
                continue;
            }
            $exJson[] = file_get_contents($location . '/' . $file);
        }

        return $exJson;
    }
}
