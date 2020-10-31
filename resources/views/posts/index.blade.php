@extends('app')
@section('title', 'Home')



@section('content')

<div class="post-container">

    @foreach($posts as $post)

    <article class="post">
        <div class="user-container link-container">
            <img class="profile-picture" src="{{ asset('img/StandardProfile.png') }}">
            <p class="username-1">{{ $post->user->name }}</p>
        </div>
        <div class="song-container link-block">
            <a class="covering-link" href=" {{ route('posts.show', $post->id) }} "></a>
            <h2>{{ $post->title }}</h2>
            @include('inc.audioplayer', ['fileName' => $post->audio_file_name])

            <div class="tags">
                @foreach($post->tags as $tag)
                    <a href="{{ route('search', ['tags[]' => 1]) }}" class="tag">{{ $tag->tagname }}</a>
                @endforeach
            </div>

            <p class="description">{{ $post->description }}</p>
        </div>

    </article>

    @endforeach

</div>

@endsection
