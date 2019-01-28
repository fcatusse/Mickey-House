@extends('layouts.app')

@section('content')

    <code>Dishes > Index</code>

    <div style="display:flex; flex-wrap:wrap;" class="container">
        @foreach($dishes as $dish)
            <div style="margin:10px; width:30%; padding:10px; border:1px solid #eee; background-color: #f9f9f9">
                <h2>{{ $dish->name }}</h2>
                <div>
                    @isset ($dish->photos[0])
                    <img style="width:100%" src="{{ url('storage/'.$dish->photos[0]) }}">
                    @endisset

                </div>
                <h4>{{ $dish->description }}</h4>
                <p>nombre de part disponibles : {{ $dish->nb_servings }}</p>
                <p>prix par part: {{ $dish->price }}</p>
                <p>catégories:
                    <ul>

                    @foreach($dish->cat_names as $categorie)

                        <li>{{ $categorie }}</li>
                    @endforeach
                    </ul>
                </p>
                <p>visible: {{ $dish->is_visible }}</p>
                <p>
                    <a class="btn btn-primary" href="{{ "/dish/" . $dish->id }}">Show detail</a>
                </p>
                <p>
                    <code>id: {{ $dish->id }}</code>
                    <code>user_id: {{ $dish->user_id }}</code>
                </p>
            </div>
        @endforeach
    </div>

@endsection

