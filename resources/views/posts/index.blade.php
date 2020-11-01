@extends('app')
@section('title', 'Home')



@section('content')

<div class="post-container">

    @foreach($posts as $post)

    <article class="post">
        <a href="{{ route('user', $post->user->id) }}" class="user-container link-container">
            <img class="profile-picture" src="{{ asset('img/StandardProfile.png') }}">
            <p class="username-1">{{ $post->user->name }}</p>
        </a>
        <div class="song-container link-block">
            <a class="covering-link" href=" {{ route('posts.show', $post->id) }} "></a>
            <h2>{{ $post->title }}</h2>
            @include('inc.audioplayer', ['fileName' => $post->audio_file_name])

            <div class="tags">
                @foreach($post->tags as $tag)
                    <form class="tag-form" action="{{ route('search') }}" method="POST">
                        @csrf
                        <input type="hidden" value="{{ $tag->id }}" name="tags" id="tags" >
                        <button type="submit" class="tag">{{ $tag->tagname }}</button>
                    </form>
                @endforeach
            </div>

            <p class="description">{{ $post->description }}</p>
        </div>

    </article>

    @endforeach

</div>

@endsection
