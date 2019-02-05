@extends('layouts.app')

@section('content')
<div><a href="http://127.0.0.1:8000/admin/categories/create" class="btn btn-success my-1">Nouvelle catégorie</a></div>
<table class="table">
  <thead class="thead-dark">
    <tr>
      <th scope="col">#</th>
      <th scope="col">{{ __('Nom') }}</th>
      <th scope="col">{{ __('Actions') }}</th>
    </tr>
  </thead>
  <tbody>
        @if(count($categories) > 0)
            @foreach ($categories as $categorie)
            <tr>
                <th scope="row">{{$categorie->id}}</th>
                <td>{{$categorie->title}}</td>
                <td>
                {!! Form::open(['method' => 'DELETE', 'action' => ['CategoriesController@destroy', $categorie->id]]) !!}
                <a href="http://127.0.0.1:8000/admin/categories/{{$categorie->id}}" class="btn btn-primary my-1">Editer</a>
                {!! Form::submit('Supprimer', ['class' => 'btn btn-danger']) !!}
                {!! Form::close() !!}
                </td>
            </tr>
            @endforeach
        @else
            Pas encore de catégories.
        @endif
  </tbody>
</table>
@endsection
