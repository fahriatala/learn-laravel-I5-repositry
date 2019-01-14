<?php

use App\Entities\Post;
use Illuminate\Database\Seeder;

class PostTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
    	$posts = DB::table('signatures')->get();
        foreach($posts as $post) {
            Post::create([
                'signature_id' => $post->id,
                'name' => 'test post'
            ]);
        }
    }
}
