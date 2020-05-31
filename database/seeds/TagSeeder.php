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
        $tags = [
            'grammar', 
            'vocabulary', 
            'articles', 
            'indefinite', 
            'a/an', 
            'definite', 
            'the', 
            'pronouns', 
            'personal pronouns',
            'holiday',
            'weather',
            'time',
            'house',
            'flat',
            'furniture',
            'food',
            'irregular verbs',
            'irregular plural',
            'past tense',
            'present tense',
            'present perfect',
            'present perfect continuous',
            'past continuous',
            'past perfect',
            'conditional',
            'first conditional',
            'second conditional',
            'third conditional',
        ];

        foreach ($tags as $tag) {
            Tag::create([
                'name' => $tag
            ]);
        }
    }
}
