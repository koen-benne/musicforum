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
        $posts = Post::all()->whereIn('enabled', 1)->sortByDesc('created_at');


        return view('posts.index', ['posts' => $posts]);
    }

    /**
     * Display search results
     *
     * @param Request $request
     * @return Application|Factory|Response|View
     */
    public function search(Request $request)
    {
        $request->validate([
            'tags' => 'max:100',
            'searchTerm' => 'max:100',
        ]);

        $tags = Tag::all()->whereIn('id', json_decode($request->input('tags')));

        $searchTerm = $request->input('searchTerm');

        $posts = null;

        if (count($tags) <= 0) {
            $posts = Post::all()->sortByDesc('created_at');
        } else {
            $relations = DB::table('post_tag')->whereIn('tag_id', $tags->pluck('id'))->pluck('post_id');
            $posts = Post::all()->whereIn('id', $relations)->whereIn('enabled', 1)->sortByDesc('created_at');
        }

        $filteredPosts = null;

        if ($searchTerm) {
            foreach ($posts as $post) {
                if (stripos($post->title, $searchTerm) !== false || stripos($post->description, $searchTerm) !== false) {
                    $filteredPosts[] = $post;
                }
            }
        } else {
            $filteredPosts = $posts;
        }

        return view('posts.search', ['posts' => $filteredPosts, 'tags' => $tags, 'searchTerm' => $searchTerm]);
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
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->middleware('auth');

        $request->validate([
            'title' => 'required|max:100',
            'file' => 'required|mimes:mpeg,wav|max:60000',
            'description' => 'max:500',
            'tags' => 'max:500',
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
        $post->tags()->attach($this->getTagIds($request->input('tags') ?? ''));

        $user = Auth::user();
        $user->points += 5;
        $user->save();

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
        if ($post->user_id == Auth::id() || (Auth::user()->is_admin ?? false)) {
            return view('posts.edit', ['post' => $post]);
        } else {
            return redirect()->route('posts.show', [$id]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, $id)
    {
        $this->middleware('auth');

        $request->validate([
            'title' => 'required|max:100',
            'file' => 'sometimes|mimes:mpeg,wav|max:60000',
            'description' => 'max:500',
            'tags' => 'max:500',
        ]);

        $post = Post::all()->find($id);

        if ($post->user_id == Auth::id() || (Auth::user()->is_admin ?? false)) {

            if ($request->input('file')) {

                $fileName = null;

                while ($fileName === null || file_exists(storage_path() . '/app/audio/' . $fileName)) {
                    $fileName = time() . '_' . Str::random() . '.wav';
                }

                $request->file('file')->storeAs('audio', $fileName, 'public');

                $post->audio_file_name = $fileName;
            }
            $post->title = $request->input('title');
            $post->description = $request->input('description');
            $post->user_id = Auth::id();
            $post->enabled = 1;
            $post->save();
            $post->tags()->sync($this->getTagIds($request->input('tags') ?? ''));
        }
        return redirect()->route('posts.show', [$id]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy( $id)
    {
        $this->middleware('auth');

        $post = Post::all()->find($id);
        if ($post->user_id == Auth::id() || (Auth::user()->is_admin ?? false)) {
            $post->tags()->detach();
            $post->delete();

            return redirect()->route('posts.index');
        } else {

            return back();
        }
    }

    /**
     * Change visibility
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function visibility($post)
    {
        $this->middleware('auth');

        $post = Post::all()->find($post);
        $user = Auth::user();

        if (Auth::check()) {
            if ($post->user_id == $user->id || $user->is_admin) {
                if ($post->enabled) {
                    $post->enabled = 0;
                } else {
                    $post->enabled = 1;
                }
                $post->save();
            }
        }

        return back();

    }

    /**
     * Function that gets the id's of the tags given and creates new tags if necessary
     *
     * @param string $tags
     * @return array
     */
    private function getTagIds(string $tags) {
        $tags = explode(',', str_replace(' ', '', strtolower($tags)));
        $tagIds = [];

        foreach ($tags as $tag) {
            $tagFromDB = Tag::all()->whereIn('tagname', ucfirst($tag))->first();

            if (!$tagFromDB) {
                $tagFromDB = new Tag();
                $tagFromDB->tagname = ucfirst($tag);
                $tagFromDB->save();
            }
            $tagIds[] = $tagFromDB->id;
        }
        return $tagIds;
    }

}
