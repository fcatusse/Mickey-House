@extends('layouts.app')

@section('content')
    <h1>Create a category</h1>

    {!! Form::open(['action' => 'CategoriesController@store', 'method' => 'POST']) !!}

    <div class="form-group">
        {{ Form::label('title', 'Category Name', [], false) }}
        {{ form::text('title', '', ['class' => 'form-control']) }}
    </div>

    {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}

@endsection