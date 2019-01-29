@extends('layouts.app')

@section('content')

<h2 class="titleProfile text-center">Mes commandes</h2>

{{-- Display orders as cards and show a custom message if no order has been passed by this customer yet --}}

@if (count($orders) > 0)
<div class="row">
    @foreach($orders as $order)
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

@else

<h4> Vous n'avez pas encore passé de commandes</h4>

@endif

@endsection
