@extends('app')
@section('title', $post->title)



@section('content')

    <div class="post-container">

        <div class="post">

            <h1>{{ $post->title }}</h1>
            <p class="username-2">{{ $post->user->name }}</p>

            <div class="ap-container">
                @include('inc.audioplayer', ['fileName' => $post->audio_file_name])

                <div class="tags">
                    @foreach($post->tags as $tag)
                        <a class="tag">{{ $tag->tagname }}</a>
                    @endforeach
                </div>

                <p class="description">{{ $post->description }}</p>
            </div>

        </div>


        @if ($post->user_id == Auth::id() || Auth::user()->is_admin)
            <a href="{{ route('posts.edit', $post->id) }}">Edit</a>

            <form method="POST" action="{{ route('posts.destroy', $post->id) }}">
                @method('DELETE')
                @csrf
                <button type="submit" class="form-submit" onclick="return confirm('Are you sure you want to delete this post?')">Delete</button>
            </form>
        @endif

        <div class="comment-section">
            <p>Comments</p>

            @if (Auth::check())
                @if (Auth::user()->points < 1 || Auth::user()->is_admin)
                <form id="comment-form" action="{{ route('comments.store') }}" method="POST">
                    @csrf
                    <input id="content" name="content" class="nav-item" type="text" placeholder="Comment..">
                    <input type="hidden" name="post_id" value="{{ $post->id }}" />
                    <button type="submit" id="comment-button"></button>
                </form>
                @else
                    <p>You need more points to comment</p>
                @endif
            @endif

            @foreach($post->comments()->orderBy('created_at', 'desc')->get() as $comment)
                <div class="user-container link-container">
                    <img class="profile-picture" src="{{ asset('img/StandardProfile.png') }}">
                    <p class="username-1">{{ $comment->user->name }}</p>
                </div>
                <div class="song-container link-block">
                    <p>{{ $comment->content }}</p>
                </div>
            @endforeach

        </div>
    </div>

@endsection

