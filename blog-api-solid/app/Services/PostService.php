<?php


namespace App\Services;

use App\Models\Post;
use Tymon\JWTAuth\Facades\JWTAuth;

class PostService
{
    public function getAllPosts()
    {
        return Post::all();
    }

    public function createPost(array $data)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $post = new Post;
        $post->title = $data['title'];
        $post->content = $data['content'];
        $post->user_id = $user->id;
        $post->save();

        return $post;
    }


    public function updatePost($id, array $data)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $post = Post::find($id);
        if ($post->user_id != $user->id) {
            return response()->json(['error' => 'This post was made by another user'], 403);
        }
        if (isset($data['title'])) {
            $post->title = $data['title'];
        }
        if (isset($data['conntent'])) {
            $post->content = $data['content'];
        }

        $post->save();

        return $post;
    }

    public function deletePost($id)
    {
        $user = JWTAuth::parseToken()->authenticate();

        $post = Post::find($id);
        if ($post->user_id != $user->id) {
            return response()->json(['error' => 'Not authorized to delete post'], 403);
        }
        $post->delete();
        return ['message' => 'Post deleted successfully.'];
    }
}