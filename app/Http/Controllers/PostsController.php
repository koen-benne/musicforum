<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Auth;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PostsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|Response|View
     */
    public function index()
    {
        $postList = Post::all();


        return view('posts.index', ['postList' => $postList]);
    }

    /**
     * Show the form for creating a new post.
     *
     * @return Application|Factory|Response|View
     */
    public function create()
    {

        $this->middleware('auth');

        return view('posts.create');
    }

    /**
     * Store a newly created post in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {

        $request->validate([
            'title' => 'required|unique:posts|max:100',
            'file' => 'required|mimes:mpeg,wav|max:61440',
            'description' => 'max:500',
        ]);

        $post = new Post();

        $fileName = null;

        while ($fileName === null || file_exists(storage_path() . '/app/audio/' . $fileName)) {
            $fileName = time() . '_' . Str::random() . '.wav';
        }

        $request->file('file')->storeAs('audio', $fileName, 'public');

        $post->title = $request->input('title');
        $post->audio_file_name = $fileName;
        $post->description = $request->input('description');
        $post->user_id = Auth::id();
        $post->save();

        return redirect()->route('posts.show', [$post->id]);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Application|Factory|Response|View
     */
    public function show(int $id)
    {
        $post = Post::all()->find($id);

        return view('posts.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
