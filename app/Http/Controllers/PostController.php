<?php

namespace App\Http\Controllers;

use App\Domain\PostDomain;
use Illuminate\Http\Request;

class PostController extends Controller {
    protected $postDomain;

    public function __construct(PostDomain $postDomain) {
        $this->postDomain = $postDomain;
    }

    public function index() {
        $posts = $this->postDomain->get();
        return response()->json($posts);
    }

    public function find(int $id) {
        $post = $this->postDomain->find($id);
        return response()->json($post);
    }

    public function store(Request $request) {
        $title = $request->input('title');
        $description = $request->input('description');
        $content = $request->input('content');

        $post = $this->postDomain->create($title, $description, $content);

        return response()->json($post);
    }

    public function update(Request $request, int $id) {
        $title = $request->input('title');
        $description = $request->input('description');
        $content = $request->input('content');

        $post = $this->postDomain->update($id, $title, $description, $content);

        return response()->json($post);
    }

    public function delete(int $id) {
        $this->postDomain->delete($id);

        return response()->json([
            'message' => "SUCCESS",
            'error' => false
        ], 204);
    }
}
