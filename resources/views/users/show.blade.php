@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="profile">
                <h4>Profile</h4>
                <p>Username : {{ $user->username }}</p>
                <p>First name : {{ $user->firstname }}</p>
                <p>Last name: {{ $user->lastname }}</p>
                <p>Email : {{ $user->email }}</p>
                <p>Address : {{ $user->address ? $user->complete_address : ''}}</p>
            </div>
            <div class="dishes">
                <h4>Dishes</h4>
                @foreach($dishes as $dish)
                    <div class="row">
                        <h5>{{ $dish->name }}</h5>
                        <em>{{ $dish->updated_at }}</em>
                        <p>{{ $dish->description }}</p>
                        <p>Servings : {{ $dish->nb_servings }}</p>
                        <p>Price : {{ $dish->price }} €</p>
                        <img src="{{ $dish->photos[0]? $dish->photos[0] : ''}}" alt="{{ $dish->name }}">
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection