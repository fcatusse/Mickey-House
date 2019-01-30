@extends('layouts.app')

@section('content')
<h1 class="mb-4 titleProfile text-center">La page de {{ $user->firstname }}</h1>
<div class="card">
    <div class="card-body">
        <p class="profil-info"><b>Pseudo</b> : {{ $user->username }}</p>
        <p class="profil-info"><b>Nom</b> : {{ $user->firstname }} {{ $user->lastname }}</p>
        <p class="profil-info"><b>Adresse</b> : {{ $user->address ? $user->complete_address : ''}}</p>
    </div>
</div>

</br>

@if (count($dishes) > 0)

<h1 class="titleProfile">Plats</h1>
<hr>

<div class="row">
    @foreach($dishes as $dish)
    <div class="col-sm-4">
        <div class="card mt-4">
            @isset ($dish->photos[0])
            <img class="card-img-top" src="{{ url('/storage/'.$dish->photos[0]) }}">
            @endisset
            <div class="card-body">
                <span class="badge badge-secondary badgeHome">{{ $dish->nb_servings }} Parts disponibles</span>
                <h5 class="card-title titleHome">{{$dish->name}}</h5>
                <p class="card-text descriptionHome">{{$dish->description}}</p>
                <p><a class="btn btn-primary text-white btnHome" href="{{ "/dish/". $dish->id }}">Voir le plat</a></p>
                <p><a class="btn btn-secondary btnHome" href="{{ "/dish/edit/". $dish->id }}">Editer le plat</a></p>
            </div>
            <div class="card-footer catFooter">
                @foreach($dish->categories as $categorie)
                <small class="text-muted">{{ $categorie->title }} - </small>
                @endforeach
                <div class="priceHome badge badge-success">{{$dish->price}} € / Part</div>
            </div>
        </div>
    </div>
    @endforeach
</div>

@else
<h4>{{ $user->username }} n'a pas encore de plats</h4>
@endif

@if(count($dishes) > 0)
    <h1 class="titleProfile mt-5">Les reviews du cuisinier : <span class="badge badge-success">{{$averageNote}} / 5</span></h1>
    <hr>
    @foreach($reviews as $review)
        <div class="card mt-4">
        <div class="card-header">
            <span class="reviewName font-weight-bold">Client @ {{$review->firstname}} </span><span class="badge badge-warning badgeBuyer">Acheteur vérifié</span><div class="priceHome badge badge-primary">Note : {{$review->note}} / 5</div>
        </div>
        <div class="card-body">
            <h5 class="card-title reviewDishTitle">Le plat noté : {{$review->name}}</h5>
            <p class="card-text txtReview">{{$review->comment}}</p>
        </div>
        </div>
    @endforeach
@endif
@endsection
