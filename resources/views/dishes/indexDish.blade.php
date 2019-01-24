@extends('layouts.app')

@section('content')

    <code>Dishes > Index</code>

    <div style="display: flex">
        @foreach($dishes as $dish)
            <div style="margin:10px; width:50%; padding:10px; border:1px solid #eee; background-color: #f9f9f9">
                <h2>{{ $dish->name }}</h2>
                <div id="carousel">
                    <img style="width:100%" src="img/{{ $dish->photos[0] }}">
                </div>
                <h4>{{ $dish->description }}</h4>
                <p>nombre de part disponibles : {{ $dish->nb_servings }}</p>
                <p>prix par part: {{ $dish->price }}</p>
                <p>catégorie: {{ $dish->categories }}</p>
                <p>visible: {{ $dish->is_visible }}</p>
                <p>
                    <a href="{{ "/dishes/" . $dish->id }}">Show detail</a>
                </p>
                <p>
                    <code>id: {{ $dish->id }}</code>
                    <code>user_id: {{ $dish->user_id }}</code>
                </p>
            </div>
        @endforeach
    </div>

@endsection