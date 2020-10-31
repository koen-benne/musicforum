<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Auth;
use DebugBar\DebugBar;
use Illuminate\Http\Request;

class CommentsController extends Controller
{

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $this->middleware('auth');

        $request->validate([
            'content' => 'required|max:100'
        ]);

        $comment = new Comment();
        $comment->content = $request->input('content');
        $comment->user_id = Auth::id();
        $comment->post_id = $request->input('post_id');
        $comment->save();

        return back();
    }

}
