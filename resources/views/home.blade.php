@extends('app')
@section('title', 'Home')



@section('content')

<div class="post-container">
    <article class="post">


        <div class="user-container">
            <img class="profile-picture" src="img/StandardProfile.png">
            <username>MinecraftGanster22</username>
        </div>
        <div class="song-container">
            <h2>Big Tingz</h2>
            <audio controls>
                <source src="audio/BigTingz.wav">
            </audio>
        </div>

    </article>
</div>

@endsection
