<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PostService;

class PostController extends Controller
{
    protected $postService;

    public function __construct(PostService $postService)
    {
        $this->middleware('auth:api', ['except' => ['index']]);
        $this->postService = $postService;
    }
    public function index()
    {
        $posts = $this->postService->getAllPosts();
        return response()->json($posts);
    }
    public function store(Request $request)
    {
        $post = $this->postService->createPost($request->all());
        return response()->json($post, 201);
    }
    public function update(Request $request, $id)
    {
        $post = $this->postService->updatePost($id, $request->all());
        return response()->json($post, 200);
    }
    public function destroy($id)
    {
        $response = $this->postService->deletePost($id);
        return response()->json($response, 200);
    }
}
