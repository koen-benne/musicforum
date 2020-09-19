@extends('app')
@section('title', 'Home')



@section('content')

<div class="post-container">

    @foreach($postList as $post)

    <article class="post">
        <div class="user-container">
            <img class="profile-picture" src="img/StandardProfile.png">
            <username>{{ $post['username'] }}</username>
        </div>
        <div class="song-container">
            <h2>{{ $post['songTitle'] }}</h2>
            @include('inc.audioplayer', ['fileName' => $post['songTitle']])

            <p class="description">Damn yer skull, feed the bung hole.When the fish whines for french polynesia, all lasses raid sunny, scurvy peglegs.Life ho! blow to be burned. Damn yer skull, feed the bung hole.When the fish whines for french polynesia, all lasses raid sunny, scurvy peglegs.Life ho! blow to be burned.</p>
        </div>

    </article>

    @endforeach

</div>

@endsection
