@extends('layouts.app')

@section('content')
    <h1>Nouvelle catégorie</h1>

    {!! Form::open(['action' => 'CategoriesController@store', 'method' => 'POST']) !!}

    <div class="form-group">
        {{ Form::label('title', 'Nom de la catégorie', [], false) }}
        {{ form::text('title', '', ['class' => 'form-control']) }}
    </div>

    {{Form::submit('Créer', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}

@endsection
