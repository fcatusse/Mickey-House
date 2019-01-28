@extends('layouts.app')

@section('content')


  <h1>{{ __('Changer mon mot de passe')}}</h1>
    {!! Form::open(['action' => ['UsersController@psw_update', $data['user']->id], 'method' => 'PUT']) !!}

    <div class="form-group">
        {{form::label('new_psw', __('Nouveau mot de passe'))}}
        {{form::password('new_psw', ['class' => 'form-control'])}}
    </div>

    <div class="form-group">
        {{form::label('new_psw_repeat', __('Confirmer le nouveau mot de passe'))}}
        {{form::password('new_psw_repeat', ['class' => 'form-control'])}}
    </div>

    <div class="form-group">
        {{form::label('old_psw', __('Mot de passe actuel'))}}
        {{form::password('old_psw', ['class' => 'form-control'])}}
    </div>

      {{Form::hidden('_method', 'PUT')}}
      {{Form::submit( __('Valider'), ['class' => 'btn btn-primary'])}}

    {!! Form::close() !!}


@endsection
