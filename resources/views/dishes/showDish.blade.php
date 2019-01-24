@extends('layouts.app')

@section('content')

  <div class="container">

    <h3 class=my-4>{{$dish[0]->name}}</h3>
    <h5>Cook: {{$dish[0]->username}}</h5>
    <p>{{$dish[0]->description}}</p>
    <p>Price per serving: {{$dish[0]->price}} €</p>

    {!! Form::open(['action' => 'OrderController@storeAndUpdate', 'method'=>'POST']) !!}

    <div class="form-group">
        {{form::label('nb_servings', __('Number of servings'))}}
        {{form::select('nb_servings', $servings, null, ['class' => 'form-control'])}}
    </div>

      {{ Form::hidden('user_id', Auth::user()->id) }}
      {{ Form::hidden('dish_id', $dish[0]->id) }}
      {{ Form::hidden('price', $dish[0]->price) }}

    <div class="form-group">
      {{Form::submit( __('Order'),['class' => 'btn btn-primary'])}}
    </div>

    {!! Form::close() !!}



  @endsection
