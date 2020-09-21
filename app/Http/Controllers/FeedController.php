<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\NewsItem;

class FeedController extends Controller
{

    public function show()
    {

        $postList = [
            ['id' => 1, 'author' => 'CoolPerson22', 'title' => 'Big Tingz'],
            ['id' => 2, 'author' => 'SuperSickGuy', 'title' => 'Sick Beat'],
        ];

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

        $postList = [
            ['id' => 1, 'author' => 'CoolPerson22', 'title' => 'Big Tingz'],
            ['id' => 2, 'author' => 'SuperSickGuy', 'title' => 'Sick Beat'],
        ];

        $post = null;

        foreach ($postList as $currentPost) {
            if ($currentPost['id'] == $id) {
                $post = $currentPost;
                break;
            }
        }

        return view('post', ['post' => $post]);

    }


}
