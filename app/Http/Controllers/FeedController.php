<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\NewsItem;

class FeedController extends Controller
{

    public function show()
    {

        $postList = [
            ['username' => 'MinecraftGanster22', 'songTitle' => 'Big Tingz'],
            ['username' => 'SuperSickGuy', 'songTitle' => 'Sick Beat'],
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


}
