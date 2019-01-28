@extends('layouts.app')

@section('content')

  <h2>Mes commandes</h2>

  {{-- Display orders as cards and show a custom message if no order has been passed by this customer yet --}}

  @if (count($orders) > 0)

    <div class="card-deck">

      @foreach($orders as $order)
      <div class="card">
            @isset ($order->photos[0])
            <img class="card-img-top" style="" src="{{ url('/storage/'.$order->photos[0]) }}">
            @endisset
            <div class="card-body">
                {{-- <span class="badge badge-secondary badgeHome">{{ $order->nb_servings }} Parts disponibles</span> --}}
                <h5 class="card-title titleHome">{{$order->name}}</h5>
                <h6 class="text-muted madeBy">Passée le {{$order->created_at}}</h6>
                <p class="card-text descriptionHome">{{$order->description}}</p>
                <a class="btn btn-success btnHome" href="{{route('dish.show', $order->dish_id)}}"><i class="fas fa-shopping-cart"></i> Commander de nouveau</a>
            </div>
            <div class="card-footer catFooter">
                <small class="text-muted">Nombre de parts commandées : {{ $order->nb_servings }}</small>
                <div class="priceHome badge badge-primary">Prix total : {{$order->price}} €</div>
            </div>
        </div>
{{-- 
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
        </div> --}}

    @endforeach
  </div>

@else

  <h4> Vous n'avez pas encore passé de commandes</h4>

@endif

@endsection
