<?php

namespace App\Http\Controllers;

use App\Post;
use App\Comment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    /**
     * Display a listing of posts.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('last_edited')->get();

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
            return redirect()->back()->withInput();
        }

        $data = $request->all();
        $data['last_edited'] = today();

        Post::create($data);

        return redirect()->route('post.index');
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
        return view('post.show', ['post' => $post]);
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
        return view('post.edit', ['post' => $post]);
    }

    /**
     * Update the specified post in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int $postId post id being updated
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $postId)
    {
        $user = Auth::user();
        if ($user->role != 'admin') {
            return redirect()->back();
        }
        $post = Post::find($postId);

        $data = $request->except('_method');
        $data['last_edited'] = today();

        $post->update($data);

        return redirect()->route('post.show', ['post' => $postId]);
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

        return redirect()->route('post.index');
    }
}
