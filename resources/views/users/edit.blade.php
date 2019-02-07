@extends('layouts.app')

@section('content')


  <h1>{{ __('Editer mon profil')}}</h1>
    {!! Form::open(['action' => ['UsersController@update', $data['user']->id], 'method' => 'PUT']) !!}

    <div class="form-group">
        {{form::label('username', __('Nom d\'utilisateur'))}}
        {{form::text('username', $data['user']->username, ['class' => 'form-control'])}}
    </div>

    <div class="form-group">
        {{form::label('firstname', __('Prénom'))}}
        {{form::text('firstname', $data['user']->firstname, ['class' => 'form-control'])}}
    </div>

    <div class="form-group">
        {{form::label('lastname', __('Nom'))}}
        {{form::text('lastname', $data['user']->lastname, ['class' => 'form-control'])}}
    </div>

    <div class="form-group">
        {{form::label('email', __('Email'))}}
        {{form::text('email', $data['user']->email, ['class' => 'form-control'])}}
    </div>

    <div class="form-group">
        {{form::label('address', __('Adresse'))}}
        {{form::text('address', $data['user']->address, ['class' => 'form-control'])}}
    </div>

    <div class="form-group">
        {{form::label('postal_code', __('Code postal'))}}
        {{form::number('postal_code', $data['user']->postal_code, ['class' => 'form-control'])}}
    </div>

    <div class="form-group">
        {{form::label('city', __('Ville'))}}
        {{form::text('city', $data['user']->city, ['class' => 'form-control'])}}
    </div>

      {{Form::hidden('_method', 'PUT')}}
      {{Form::submit( __('Valider'), ['class' => 'btn btn-primary'])}}

    {!! Form::close() !!}

  </br>

    <a id="change-psw" href="{{route('password.edit', $data['user']->id)}}" class="btn btn-secondary">Changer mon mot de passe</a>

@endsection
