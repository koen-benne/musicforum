@extends('app')
@section('title', 'Search')



@section('content')

    <a class="post-container">
        <div id="search-info">
            <div id="search-tags-container">
                @foreach($tags as $tag)
                <p class="search-tag">{{ $tag->tagname }}</p>
                @endforeach
                <button class="add"></button>
            </div>
        </div>

        @foreach($posts as $post)

            <article class="post">
                <a href="{{ route('users.show', $post->user->id) }}" class="user-container link-container">
                    <img class="profile-picture" src="{{ asset('img/StandardProfile.png') }}">
                    <p class="username-1">{{ $post->user->name }}</p>
                </a>
                <div class="song-container link-block">
                    <a class="covering-link" href=" {{ route('posts.show', $post->id) }} "></a>
                    <h2>{{ $post->title }}</h2>
                    @include('inc.audioplayer', ['fileName' => $post->audio_file_name])

                    <div class="tags">
                    @foreach($post->tags as $tag)
                        <a href="{{ route('search', ['tags[]' => $tag->id]) }}" class="tag">{{ $tag->tagname }}</a>
                    @endforeach
                    </div>

                    <p class="description">{{ $post->description }}</p>
                </div>

            </article>

        @endforeach

    </div>

@endsection
