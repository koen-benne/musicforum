<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\NewsItem;
use Illuminate\Database\Eloquent\Model;

class FeedController extends Controller
{

    public function show()
    {

        $postList = Post::all();


        return view('home', ['postList' => $postList]);

    }

    public function login()
    {

        return view('home');

    }

    public function signin()
    {

        return view('home');

    }

    public function post($id) {


        $post = Post::all()->find($id);

        return view('post', ['post' => $post]);

    }


}
