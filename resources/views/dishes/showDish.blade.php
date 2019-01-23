@extends('layouts.app')

@section('content')

    <div class="container">

    <h3 class=my-4>{{$dish[0]->name}}</h3>
    <h5>{{$dish[0]->username}}</h5>
    <p>{{$dish[0]->description}}</p>



@endsection
