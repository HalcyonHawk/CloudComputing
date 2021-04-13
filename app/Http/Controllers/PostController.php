<?php

namespace App\Http\Controllers;

use App\Post;
use App\Comment;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Contracts\Filesystem\Filesystem;

class PostController extends Controller
{
    /**
     * Display a listing of posts.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderBy('last_edited')->orderBy('last_edited', 'DESC')->get();

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
     * Store a newly created post in database.
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

        //Create without image, then add the image
        $data = $request->except('photo');
        $data['last_edited'] = today();

        $post = Post::create($data);

        //Store image locally
        //$path = $request->file('photo')->store('images');

        //AWS
        //$path = $request->file('photo')->store('images', 's3');

        //$image = $request->file('photo');
        //$filePath = 'image_' . $post->post_id;
        //$s3 = \Storage::disk('s3')
        //    ->put($filePath, file_get_contents($image), 'public');
        //$post->update(['photo_link' => $filePath]);

        return redirect()->route('post.index');
    }

    /**
     * Display the specified post and its comments.
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
     * Show the form for editing the specified post.
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

        $data = $request->except('_method', 'photo', 'is_photo');
        $data['last_edited'] = today();
/* 
        if ($post->file_link != null) {
            $image = $request->file('photo');
            $filePath = 'image_' . $post->post_id;
            $s3 = \Storage::disk('s3');
            //Photos not stored in any folders
            $s3->put($filePath, file_get_contents($image), 'public');
            $data['photo_link'] = $filePath;
        } else {
            //If the remove checkbox is checked
            if ($request->has('is_photo')) {
                $data['photo_link'] = null;
                //TODO: Remove photo from AWS
            }
        }
 */
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
