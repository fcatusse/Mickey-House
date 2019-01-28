@extends('layouts.app')

@section('content')

  @php ($cat = $dish[0]->categories)
  @php ($photos = $dish[0]->photos)

{{-- Display the dish information --}}

<div class="row">
    <div class="col">
      <div class="card">
            @isset ($dish[0]->photos[0])
            <img class="card-img-top" style="" src="{{ url('/storage/'.$dish[0]->photos[0]) }}">
            @endisset
            <div class="card-body">
                <span class="badge badge-secondary badgeHome">{{ $dish[0]->nb_servings }} Parts disponibles</span>
                <h5 class="card-title titleHome">{{$dish[0]->name}}</h5>
                <h6 class="text-muted madeBy"><span>Cuisiné par </span><a href="/users/show/{{$dish[0]->cook_id}}">{{$dish[0]->username}}</a></h6>
                <p class="card-text descriptionHome">{{$dish[0]->description}}</p>
            </div>
            <div class="card-footer catFooter">
                {{-- <b class="categorieHome">Catégories :</b> --}}
                @foreach($cat as $categorie)
                <small class="text-muted">{{ $categorie->title }} - </small>
                @endforeach
                <div class="priceHome badge badge-success">{{$dish[0]->price}} € / Part</div>
            </div>
        </div>
    </div>
    <div class="col">
      {{-- Display the dish order part : if there are servings available show the form otherwise display an info message "unavailable "--}}

    <div class="orderCol">
      @if ($dish[0]->nb_servings > 0 && isset(Auth::user()->id))

      {!! Form::open(['action' => 'OrderController@storeAndUpdate', 'method'=>'POST']) !!}

      <div class="form-group">
        {{form::label('nb_servings', __('Nombre de parts'))}}
        {{form::select('nb_servings', $servings, null, ['class' => 'form-control'])}}
      </div>

      {{ Form::hidden('user_id', Auth::user()->id) }}
      {{ Form::hidden('dish_id', $dish[0]->id) }}
      {{ Form::hidden('price', $dish[0]->price) }}

      <div class="form-group">
      {{ Form::button('<i class="fas fa-shopping-cart"></i> Commander', ['class' => 'btn btn-success btnHome', 'type' => 'submit']) }}
      </div>

      {!! Form::close() !!}
    @elseif (isset(Auth::user()->id))
      <div class="alert alert-warning" role="alert" style="heigth:30px">
          <strong>Désolé...</strong> Ce plat n'est pas disponible pour le moment.
      </div>
    @else
      <div class="alert alert-warning" role="alert" style="heigth:30px">
          <strong>Désolé...</strong> Vous devez être connecté pour commander
      </div>
    @endif
    </div>
    
    </div>
  </div>
  
  {{-- <div style="display: flex">
    <div style="margin:10px; width:50%; padding:10px; border:1px solid #eee; background-color: #f9f9f9">
      <h2>{{ $dish[0]->name }}</h2>
      <h5>Cuisiné par <a href="/users/show/{{$dish[0]->cook_id}}">{{$dish[0]->username}}</a></h5>
      <div id="carousel">
        <img style="width:100%" src="/img/{{ $photos[0] }}">
      </div>
    </br>
    <h4>{{ $dish[0]->description }}</h4>

    @if ($dish[0]->nb_servings > 0)
    <p>Nombre de parts disponibles : {{ $dish[0]->nb_servings }}</p>
    @endif

    <p>Prix par part: {{ $dish[0]->price }} €</p>
    <p>
      @foreach( $cat as $categorie)
        • {{ $categorie->title }}
      @endforeach
    </p>
  </div>



</div> --}}






@endsection
