<?php

namespace App\Domain;

use App\Exceptions\ResourceNotFoundException;
use App\Repository\PostRepository;
use App\Models\Post;
use Illuminate\Support\Carbon;

class PostDomain {
    protected $postRepository;

    public function __construct(PostRepository $postRepository) {
        $this->postRepository = $postRepository;
    }

    public function get() {
        return $this->postRepository->get();
    }

    public function find(int $id) {
        $post = $this->postRepository->find($id);

        if (!$post) {
            throw new ResourceNotFoundException(Post::class);
        }

        return $post;
    }

    public function create(string $title, string $description, string $content) {
        $post = new Post();
        $post->title = $title;
        $post->description = $description;
        $post->content = $content;
        $post->created_at = Carbon::now()->utc();
        $post->updated_at = Carbon::now()->utc();

        return $this->postRepository->create($post);
    }

    public function update(int $id, string $title, string $description, string $content) {
        $post = $this->find($id);

        if(!$post) {
            throw new ResourceNotFoundException(Post::class);
        }

        $post->title = $title;
        $post->description = $description;
        $post->content = $content;
        $post->updated_at = Carbon::now()->utc();

        $this->postRepository->update($post);

        return $post;
    }

    public function delete(int $id) {
        $post = $this->find($id);

        if(!$post) {
            throw new ResourceNotFoundException(Post::class);
        }

        $this->postRepository->delete($post);
    }
}
