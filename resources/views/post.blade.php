@extends('app')
@section('title', $post['title'])



@section('content')

    <main class="post">

        <h1>{{ $post['title'] }}</h1>
        <p>{{ $post['author'] }}</p>

        @include('inc.audioplayer', ['fileName' => $post['title']])

    </main>

@endsection
