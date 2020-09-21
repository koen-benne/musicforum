@extends('app')
@section('title', $post->title)



@section('content')

    <div class="post">

        <h1>{{ $post->title }}</h1>
        <p>{{ $post->user->name }}</p>

        @include('inc.audioplayer', ['fileName' => $post->audio_file_name])

    </div>

@endsection

