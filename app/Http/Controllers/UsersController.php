<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Auth;
use http\Client\Curl\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\View\View;

class UsersController extends Controller
{

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return Application|Factory|Response|View
     */
    public function show(int $id)
    {
        $user = \App\Models\User::all()->find($id);
        $posts = Post::all()->whereIn('user_id', $user->id);

        return view('users.show', ['user' => $user, 'posts' => $posts]);
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

        $user = \App\Models\User::all()->find($id);

        if ($id == Auth::id()) {
            return view('users.edit', ['user' => $user]);
        } else {
            return redirect()->route('user', [$id]);
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
            'name' => ['required', 'string', 'max:255'],
        ]);

        $user = Auth::user();
        if ($id == $user->id) {
            $user->name = $request->input('name');
            $user->save();
        }


        return redirect()->route('user', [$id]);
    }

}
