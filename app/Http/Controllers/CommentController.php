<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    /**
     * Show the form for creating a comment.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($postId)
    {
        $post = Post::findOrFail($postId);

        return view('comment.create');
    }

    /**
     * Store a newly created comment in database
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request, $postId)
    {
        $post = Post::findOrFail($postId);
        $data = $request->all();
        $data['user_id'] = Auth::user()->user_id;
        $data['last_edited'] = today();

        Comment::create($data);

        return redirect()->route('post.show', ['post' => $postId]);
    }

    /**
     * Remove the specified comment from database.
     *
     * @param int $postId Post id of the post the comment belongs to
     * @param  int $commentId Comment id of the comment being removed
     * @return \Illuminate\Http\Response
     */
    public function destroy($commentId)
    {
        $comment = Comment::findOrFail($commentId);
        $comment->delete();

        return redirect()->route('post.show', ['post' => $postId]);
    }
}
