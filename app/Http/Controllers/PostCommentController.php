<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\PostComment;
use Illuminate\Http\Request;

class PostCommentController extends Controller
{
    public function create(Request $request, Post $post)
    {
        $request->validate(['content' => 'required|string']);
        $comment = new PostComment();
        $comment->content = $request->input('content');
        $comment->user_id = auth()->id();

        $post->comments()->save($comment);

        $comment->load('user');

        return response()->json($comment);
    }
}
