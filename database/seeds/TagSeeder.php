<?php

use Illuminate\Database\Seeder;
use App\Tag;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $tags = ['grammar', 'vocabulary', 'article', 'indefinite', 'a/an', 'definite', 'the', 'pronouns', 'personal pronouns'];

        foreach ($tags as $tag) {
            Tag::create([
                'name' => $tag
            ]);
        }
    }
}
