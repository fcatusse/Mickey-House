@extends('layouts.app')

@section('content')

  <h2 class="titleProfile text-center my-4">Mes plats</h2>
  @if (count($dishes) > 0)
    <div class="row">
      @foreach($dishes as $dish)
        <div class="col-sm-4">
          <div class="card mt-4">
            @isset ($dish->photos[0])
              <img class="card-img-top" style="" src="{{ url('/storage/'.$dish->photos[0]) }}">
            @endisset
            <div class="card-body">
              {{-- <span class="badge badge-secondary badgeHome">{{ $dish->nb_servings }} Parts disponibles</span>
              --}}
              <h5 class="card-title titleHome">{{$dish->name}}</h5>
              <p class="card-text descriptionHome">{{$dish->description}}</p>
              <p class="text-muted">Nombre de parts disponibles : {{ $dish->nb_servings }}</p>
              <p>Prix d'une part : {{$dish->price}} €</p>
              </div>
              <div class="card-footer catFooter">
                <a class="btn btn-success btnHome" href="{{route('dish.edit', $dish->id)}}">
                  Editer</a>
                  @if ($dish->is_visible == 1)
                <a class="btn btn-secondary text-white btnHome" href="{{route('dish.hide', $dish->id)}}">
                  Retirer de la vente</a>
                @endif

              </div>
            </div>
          </div>
        @endforeach
      </div>
    @else

      <h4> Vous n'avez pas encore créé de plats</h4>

    @endif


@endsection
