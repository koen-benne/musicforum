@extends('app')
@section('title', 'Home')



@section('content')

<div class="post-container">

    @foreach($postList as $post)

    <article class="post">
        <div class="user-container link-container">
            <img class="profile-picture" src="img/StandardProfile.png">
            <p class="username">{{ $post['author'] }}</p>
        </div>
        <div class="song-container link-block">
            <a class="covering-link" href=" {{ route('post', ['id' => $post['id']]) }} "></a>
            <h2>{{ $post['title'] }}</h2>
            @include('inc.audioplayer', ['fileName' => $post['title']])

            <p class="description">Damn yer skull, feed the bung hole.When the fish whines for french polynesia, all lasses raid sunny, scurvy peglegs.Life ho! blow to be burned. Damn yer skull, feed the bung hole.When the fish whines for french polynesia, all lasses raid sunny, scurvy peglegs.Life ho! blow to be burned.</p>
        </div>

    </article>

    @endforeach

</div>

@endsection
