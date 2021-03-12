<?php

namespace App\Http\Controllers;

use App\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    /**
     * Display a listing of posts.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('last_edited')->all();

        return view('post.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new post.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->role != 'admin') {
            return redirect()->back();
        }

        $data = $request->all();
        $data['last_edited'] = today();
        $data['user_id'] = $user->user_id;

        Post::create($data);

        return redirect()->back();
    }

    /**
     * Display the specified post.
     *
     * @param  int $post
     * @return \Illuminate\Http\Response
     */
    public function show($postId)
    {
        $post = Post::findOrFail($postId);
        return view('post.show', ['post' => $post, 'comments' => $post->comments]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $postId
     * @return \Illuminate\Http\Response
     */
    public function edit($postId)
    {
        $post = Post::findOrFail($postId);
        return view('post.show', ['post' => $post]);
    }

    /**
     * Update the specified post in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $user = Auth::user();
        if ($user->role != 'admin') {
            return redirect()->back();
        }
        $data = $request->except('_method');
        $post = Post::find($postId);
        $data['last_edited'] = today();

        $post->update();

        return redirect()->back();
    }

    /**
     * Remove the specified post from database.
     *
     * @param  int  $postId
     * @return \Illuminate\Http\Response
     */
    public function destroy($postId)
    {
        $user = Auth::user();
        if ($user->role != 'admin') {
            return redirect()->back();
        }
        $post = Post::findOrFail($postId);
        $post->delete();

        return redirect()->back();
    }
}
