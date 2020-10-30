@extends('app')
@section('title', $post->title)



@section('content')

    <div class="post-container">

        <div class="post">

            <h1>{{ $post->title }}</h1>
            <p class="username-2">{{ $post->user->name }}</p>

            <div class="ap-container">
                @include('inc.audioplayer', ['fileName' => $post->audio_file_name])
            </div>

        </div>


        @if ($post->user_id == Auth::id())
            <a href="{{ route('posts.edit', $post->id) }}">Edit</a>

            <form method="POST" action="{{ route('posts.destroy', $post->id) }}">
                @method('DELETE')
                @csrf
                <button type="submit" class="form-submit" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
            </form>
        @endif

        <div class="comment-section">
            <p>Comments</p>

            <div class="user-container link-container">
                <img class="profile-picture" src="{{ asset('img/StandardProfile.png') }}">
                <p class="username-1">User</p>
            </div>
            <div class="song-container link-block">
                <p>Content</p>
            </div>

        </div>
    </div>

@endsection

