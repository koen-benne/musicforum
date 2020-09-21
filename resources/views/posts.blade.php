@extends('app')
@section('title', 'Home')



@section('content')

<div class="post-container">

    @foreach($postList as $post)

    <article class="post">
        <div class="user-container link-container">
            <img class="profile-picture" src="img/StandardProfile.png">
            <p class="username">{{ $post->user->name }}</p>
        </div>
        <div class="song-container link-block">
            <a class="covering-link" href=" {{ route('posts.show', ['post' => $post->id]) }} "></a>
            <h2>{{ $post->title }}</h2>
            @include('inc.audioplayer', ['fileName' => $post->audio_file_name])

            <p class="description">{{ $post->description }}</p>
        </div>

    </article>

    @endforeach

</div>

@endsection
