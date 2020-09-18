@extends('app')
@section('title', 'Home')



@section('content')

<div class="post-container">
    <article class="post">


        <div class="user-container">
            <img class="profile-picture" src="img/StandardProfile.png">
            <username>MinecraftGanster22</username>
        </div>
        @include('inc.audioplayer', ['songTitle' => 'Big Tingz'])
    </article>

    <article class="post">


        <div class="user-container">
            <img class="profile-picture" src="img/StandardProfile.png">
            <username>SuperSickGuy</username>
        </div>
        @include('inc.audioplayer', ['songTitle' => 'Sick Beat'])
    </article>
</div>

@endsection
