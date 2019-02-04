@extends('layouts.app')

@section('content')

  {{-- Display orders as cards and show a custom message if no order has been passed to this cook yet --}}
  <h2 class="titleProfile text-center">Commandes de mes clients</h2>
  @if (count($orders_to_me) > 0)
    <div class="row">
      @foreach($orders_to_me as $order)
        <div class="col-sm-4">
          <div class="card mt-4">
            <div class="card-body">
              {{-- <span class="badge badge-secondary badgeHome">{{ $order->nb_servings }} Parts disponibles</span>
              --}}
              <h5 class="card-title titleHome">{{$order->name}}</h5>
              <h6 class=" madeBy">Passée le {{$order->created_at}} par {{$order->username}}</h6>
              </div>
              <div class="card-footer catFooter">
                <small class="text-muted">Nombre de parts commandées : {{ $order->nb_servings }}</small>
                <p>Prix total : {{$order->price}} €</p>
              </div>
            </div>
          </div>
        @endforeach
      </div>
      <div class="my-4">
        {{ $orders_to_me->links() }}
      </div>

    @else

      <h4> Vos plats n'ont pas encore été commandés</h4>

    @endif

    {{-- Display orders as cards and show a custom message if no order has been passed by this customer yet --}}
    <h2 class="titleProfile text-center my-4">Mes commandes</h2>
    @if (count($orders_passed) > 0)
      <div class="row">
        @foreach($orders_passed as $order)
          <div class="col-sm-4">
            <div class="card mt-4">
              @isset ($order->photos[0])
                <img class="card-img-top" style="" src="{{ url('/storage/'.$order->photos[0]) }}">
              @endisset
              <div class="card-body">
                {{-- <span class="badge badge-secondary badgeHome">{{ $order->nb_servings }} Parts disponibles</span>
                --}}
                <h5 class="card-title titleHome">{{$order->name}}</h5>
                <h6 class="text-muted madeBy">Passée le {{$order->created_at}}</h6>
                <p class="card-text descriptionHome">{{$order->description}}</p>
                <a class="btn btn-success btnHome" href="{{route('dish.show', $order->dish_id)}}"><i class="fas fa-shopping-cart"></i>
                  Commander de nouveau</a>
                </div>
                <div class="card-footer catFooter">
                  <small class="text-muted">Nombre de parts commandées : {{ $order->nb_servings }}</small>
                  <div class="priceHome badge badge-primary">Prix total : {{$order->price}} €</div>
                </div>
              </div>
            </div>
          @endforeach
        </div>
        <div class="my-4">
          {{ $orders_passed->links() }}
        </div>


      @else

        <h4> Vous n'avez pas encore passé de commandes</h4>

      @endif

    @endsection
