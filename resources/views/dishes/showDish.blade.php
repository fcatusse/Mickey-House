@extends('layouts.app')

@section('content')

  @php ($cat = $dish[0]->categories)
  @php ($photos = $dish[0]->photos)

{{-- Display the dish information --}}

  <div style="display: flex">
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

{{-- Display the dish order part : if there are servings available show the form otherwise display an info message "unavailable "--}}

    <div style="margin:10px; width:50%; height:50%; padding:10px; border:1px solid #eee; background-color:#f9f9f9">
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
        {{Form::submit( __('Commander'),['class' => 'btn btn-primary'])}}
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






@endsection
