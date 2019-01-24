@extends('layouts.app')

@section('content')
    <h1>Give us your feedback !</h1>

    {!! Form::open(['action' => 'ReviewsController@store', 'method' => 'POST']) !!}

    <div class="form-group">
        {{ Form::label('note', 'How many stars do we deserve ?', [], false) }}
        {{ Form::select('note', ['1' => 1, '2' => 2, '3' => 3, '4' => 4, '5' => 5], null, ['class' => 'form-control', 'placeholder' => 'Your note...']) }}
    </div>

    <div class="form-group">
        {{ Form::label('comment', 'Your feedback', [], false) }}
        {{ form::textarea('comment', '', ['class' => 'form-control']) }}
    </div>
    {{Form::hidden('order_id', 10)}}
    {{Form::submit('Send my review', ['class' => 'btn btn-primary'])}}
    {!! Form::close() !!}

@endsection