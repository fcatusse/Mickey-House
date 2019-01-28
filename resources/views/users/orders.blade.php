@extends('layouts.app')

@section('content')

  <h2>Mes commandes</h2>

  {{-- Display orders as cards and show a custom message if no order has been passed by this customer yet --}}

  @if (count($orders) > 0)

    <div class="card-deck">

      @foreach($orders as $order)

        <div class="card" style="padding:10px;">
          <h4 class="card-title">{{ $order->name }}</h4>
          <p class="card-text">Passée le {{$order->created_at}}</p>
          <img class="card-img-top" src="/img/{{ $order->photos[0] }}" alt="Card image">
          <div class="card-block">
          </br>
            <p class="card-text">{{ $order->description }}</p>
            <p>Nombre de parts commandées : {{ $order->nb_servings }}</p>
            <p>Prix total : {{ $order->price }}</p>
            <p>
              <a class="btn btn-primary" href="{{route('dish.show', $order->dish_id)}}">Commander de nouveau</a>
            </p>
          </div>
        </div>

    @endforeach
  </div>

@else

  <h4> Vous n'avez pas encore passé de commandes</h4>

@endif

@endsection
