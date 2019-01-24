@extends('layouts.app')

@section('content')
    <div class="container">

            <div class="profile">
                <h4>{{ $user->username }}</h4>
                <p>{{ $user->firstname }} {{ $user->lastname }}</p>
                <p>{{ $user->address ? $user->complete_address : ''}}</p>
            </div>

          </br>

            <h4>Dishes</h4>

            <div class="dishes" style="display: flex">

              @foreach($dishes as $dish)
                  <div style="margin:10px; width:50%; padding:10px; border:1px solid #eee; background-color: #f9f9f9">
                      <h2>{{ $dish->name }}</h2>
                      <div id="carousel">
                          <img style="width:100%" src="/img/{{ $dish->photos[0] }}">
                      </div>
                    </br>
                      <h4>{{ $dish->description }}</h4>
                      <p>nombre de part disponibles : {{ $dish->nb_servings }}</p>
                      <p>prix par part: {{ $dish->price }}</p>
                      <p>catégories:
                          <ul>
                          @foreach($dish->categories as $categorie)
                              <li>{{ $categorie->title }}</li>
                          @endforeach
                          </ul>
                      </p>
                      <p>
                          <a class="btn btn-primary" href="{{ "/dish/". $dish->id }}">Show detail</a>
                      </p>
                  </div>
              @endforeach
            </div>

    </div>
@endsection
