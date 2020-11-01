@extends('app')
@section('title', $user->name . " info")



@section('content')

    <div class="post-container">

        <div class="post">

            <h1>{{ $user->name }}</h1>
            <a href="{{ route('users.edit', $user->id) }}" >Edit acount</a>

        </div>



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
                            <a href="{{ route('search', ['tags[]' => 1]) }}" class="tag">{{ $tag->tagname }}</a>
                        @endforeach
                    </div>

                    <p class="description">{{ $post->description }}</p>
                </div>

                @if (Auth::user()->id == $user->id || (Auth::user()->is_admin ?? false))
                <form method="POST" action="{{ route('posts.visibility', $post->id) }}">
                    @csrf
                    @if ($post->enabled == 1)
                        <label for="{{ "post-" . $post->id . "-switch" }}">Disable</label>
                    @else
                        <label for="{{ "post-" . $post->id . "-switch" }}">Enable</label>
                    @endif
                    <button id="{{ "post-" . $post->id . "-switch" }}" class="disable-button" type="submit"></button>
                </form>
                @endif

            </article>

        @endforeach
    </div>

@endsection

