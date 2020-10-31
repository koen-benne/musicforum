<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use App\Models\Tag;
use App\Models\User;
use Auth;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
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
        $posts = Post::all();


        return view('posts.index', ['posts' => $posts]);
    }

    /**
     * Display search results
     *
     * @return Application|Factory|Response|View
     */
    public function search(Request $request)
    {
        $tags = Tag::all()->whereIn('id', $request->query('tags'));

        $relations = DB::table('post_tag')->whereIn('tag_id', $tags->pluck('id'))->pluck('post_id');
        $posts = Post::all()->whereIn('id', $relations);

        return view('posts.search', ['posts' => $posts, 'tags' => $tags]);
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
        $this->middleware('auth');

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
        $post->tags()->attach(1);

        return redirect()->route('posts.show', [$post->id]);

    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Application|Factory|Response|View
     */
    public function show($id)
    {
        $post = Post::all()->find($id);

        return view('posts.show', ['post' => $post]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|\Illuminate\Http\RedirectResponse|View
     */
    public function edit($id)
    {
        $this->middleware('auth');

        $post = Post::all()->find($id);
        if ($post->user_id == Auth::id()) {
            return view('posts.edit', ['post' => $post]);
        } else {
            return redirect()->route('posts.show', [$id]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $this->middleware('auth');

        $post = Post::all()->find($id);
        if ($post->user_id == Auth::id()) {
            $post->save();
        }
        return redirect()->route('posts.show', [$id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(int $id)
    {

        $post = Post::all()->find($id);
        if ($post->user_id == Auth::id()) {
            $post->delete();

            return redirect()->route('posts.index');
        } else {

            return back();
        }
    }

}
