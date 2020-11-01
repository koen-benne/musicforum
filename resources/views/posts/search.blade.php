@extends('app')
@section('title', 'Search')



@section('content')

    <div class="post-container">
        <div id="search-info">
            @if(count($tags) > 0)
                <div id="search-tags-container">
                    @foreach($tags as $tag)
                    <p class="search-tag">{{ $tag->tagname }}</p>
                    @endforeach
                    <button class="add"></button>
                </div>
            @endif
        </div>

        @if(count($posts ?? []) <= 0)
            <span>There are no search results</span>
        @else
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
        @endif


    </div>

@endsection
