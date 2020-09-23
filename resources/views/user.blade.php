@extends('app')
@section('title', $user->name . " info")



@section('content')

    <div class="post">

        <h1>{{ $user->name }}</h1>

    </div>

@endsection

