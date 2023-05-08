<?php

namespace App\Repository;

use App\Models\Post;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class PostRepository {
    public function get() {
        $posts = DB::table('posts')
            ->whereNull('deleted_at')
            ->get();

        return $posts;
    }

    public function find(int $id) {
        $post = DB::table('posts')
            ->where('id', $id)
            ->whereNull('deleted_at')
            ->first();


        return $post ? Post::make((array) $post) : null;
    }

    public function create(Post $post) {
        DB::table('posts')->insert($post->toArray());
        $post->id = DB::getPdo()->lastInsertId();
        return $post;
    }

    public function update(Post $post) {
        DB::table('posts')
            ->where('id', $post->id)
            ->whereNull('deleted_at')
            ->update([
                'title' => $post->title,
                'description' => $post->description,
                'content' => $post->content,
                'updated_at' => $post->updated_at,
            ]);
    }

    public function delete(Post $post) {
        DB::table('posts')
            ->where('id', $post->id)
            ->whereNull('deleted_at')
            ->update([
                'deleted_at' => Carbon::now()->utc(),
            ]);
    }
}
