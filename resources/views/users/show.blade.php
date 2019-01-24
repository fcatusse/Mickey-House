@extends('layouts.app')

@section('content')
    <div class="container">

            <div class="profile">
                <h4>{{ $user->username }}</h4>
                <p>{{ $user->firstname }} {{ $user->lastname }}</p>
                <p>{{ $user->address ? $user->complete_address : ''}}</p>
            </div>

          </br>

          @if (count($dishes) > 0)

            <h4>Plats</h4>


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

                      <p>
                          @foreach($dish->categories as $categorie)
                              • {{ $categorie->title }}
                          @endforeach
                      </p>
                      <p>
                          <a class="btn btn-primary" href="{{ "/dish/". $dish->id }}">Voir le détail</a>

                      </p>
                  </div>
              @endforeach
            </div>

          @else
            <h4>{{ $user->username }} n'a pas encore de plats</h4>
          @endif


    </div>
@endsection
