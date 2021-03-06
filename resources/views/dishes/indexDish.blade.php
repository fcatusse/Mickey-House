@extends('layouts.app')

@section('content')

<h3 class="titleProfile">Découvrir les plats</h3>
@for ($i = 1; $i <= count($dishes); $i++)
    @if($i % 2 == 0)
        <div class="card">
            @isset ($dishes[$i-1]->photos[0])
            <img class="card-img-top" style="" src="{{ url('/storage/'.$dishes[$i-1]->photos[0]) }}">
            @endisset
            <div class="card-body">
                <span class="badge badge-secondary badgeHome">{{ $dishes[$i-1]->nb_servings }} Parts disponibles</span>
                <h5 class="card-title titleHome">{{$dishes[$i-1]->name}}</h5>
                <p class="card-text descriptionHome">{{$dishes[$i-1]->description}}</p>
                <a class="btn btn-primary text-white btnHome" href="{{ "/dish/" . $dishes[$i-1]->id }}">Voir le plat</a>
            </div>
            <div class="card-footer catFooter">
                {{-- <b class="categorieHome">Catégories :</b> --}}
                @foreach($dishes[$i-1]->cat_names as $categorie)
                <small class="text-muted">{{ $categorie }} - </small>
                @endforeach
                <div class="priceHome badge badge-success">{{$dishes[$i-1]->price}} € / Part</div>
            </div>
        </div>
    </div>
    @else
    <div class="card-deck  mt-4 {{ count($dishes) == $i ? '' : '' }}">
        <div class="card">
            @isset ($dishes[$i-1]->photos[0])
            <img class="card-img-top" style="" src="{{ url('/storage/'.$dishes[$i-1]->photos[0]) }}">
            @endisset
            <div class="card-body">
                <span class="badge badge-secondary badgeHome">{{ $dishes[$i-1]->nb_servings }} Parts disponibles</span>
                <h5 class="card-title titleHome">{{$dishes[$i-1]->name}}</h5>
                <p class="card-text descriptionHome">{{$dishes[$i-1]->description}}</p>
                <a class="btn btn-primary text-white btnHome" href="{{ "/dish/" . $dishes[$i-1]->id }}">Voir le plat</a>
            </div>
            <div class="card-footer catFooter">
                {{-- <b class="categorieHome">Catégories :</b> --}}
                @foreach($dishes[$i-1]->cat_names as $categorie)
                <small class="text-muted">{{ $categorie }} - </small>
                @endforeach
                <div class="priceHome badge badge-success">{{$dishes[$i-1]->price}} € / Part</div>
            </div>
        </div>
    @endif
@endfor
<div class="my-4">
  {{ $dishes->links() }}
</div>



@endsection
