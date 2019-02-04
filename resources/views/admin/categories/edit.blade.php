@extends('layouts.app')

@section('content')
    <h1>Editer une categorie</h1>

    {!! Form::open(['action' => ['CategoriesController@update', $category->id], 'method' => 'PUT']) !!}

    <div class="form-group">
        {{ Form::label('title', 'Category Name', [], false) }}
        {{ form::text('title', $category->title, ['class' => 'form-control']) }}
    </div>

    {{Form::submit('Submit', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}

@endsection
