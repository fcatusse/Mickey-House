@extends('layouts.app')

@section('content')

    <code>Dishes > Edit</code>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {!! Form::open(['method' => 'put', 'files' => true]) !!}
        <table class="table">
            <tr>
                <td>{!! Form::label('name', "Nom du plat") !!}</td>
                <td>{!! Form::text('name', $name ) !!}</td>
            </tr>
            <tr>
                <td>{!! Form::label('description', 'Description') !!}</td>
                <td>{!! Form::textarea('description', $description ) !!}</td>
            </tr>
            <tr>
                <td>{!! Form::label('photo1', 'Image principale*') !!}</td>
                <td>
                    @isset ($photos[0])
                        <img src="{{ url('/storage/'.$photos[0]) }}" class="edit-preview">
                        <br><br>
                    @endisset
                    {!! Form::file('photo1') !!}
                    (1 mo max)
                </td>
            </tr>
            <tr>
                <td>{!! Form::label('photo2', 'Image') !!}</td>
                <td>
                    @isset ($photos[1])
                        <img src="{{ url('/storage/'.$photos[1]) }}" class="edit-preview">
                        {!! Form::label('del_photo2', 'Delete photo 2') !!}
                        {!! Form::checkbox('del_photo2', 1) !!}
                        <br><br>
                    @endisset
                    {!! Form::file('photo2') !!}
                        (1 mo max)
                </td>
            </tr>
            <tr>
                <td>{!! Form::label('photo3', 'Image') !!}</td>
                <td>
                    @isset ($photos[2])
                        <img src="{{ url('/storage/'.$photos[2]) }}" class="edit-preview">
                        {!! Form::label('del_photo3', 'Delete photo 3') !!}
                        {!! Form::checkbox('del_photo3', 1) !!}
                        <br><br>
                    @endisset
                    {!! Form::file('photo3') !!}
                        (1 mo max)
                </td>
            </tr>
            <tr>
                <td>{!! Form::label('nb_servings', 'Quantité disponible') !!}</td>
                <td>{!! Form::number('nb_servings', $nb_servings) !!}</td>
            </tr>
            <tr>
                <td>{!! Form::label('price', 'Prix part part') !!}</td>
                <td>{!! Form::number('price', $price) !!}</td>
            </tr>
            <tr>
                <td>{!! Form::label('categorie1', 'Categorie principale*') !!}</td>
                <td>{!! Form::select('categorie1', $all_categories, $categories[0], ['placeholder' => 'Choisir catégorie...']) !!}
                </td>
            </tr>
            <tr>
                <td>{!! Form::label('categorie2', 'Categorie secondaire') !!}</td>
                <td>{!! Form::select('categorie2', $all_categories, $categories[1], ['placeholder' => 'Choisir catégorie...']) !!}
                </td>
            </tr>
            <tr>
                <td>{!! Form::label('categorie3', 'Categorie secondaire') !!}</td>
                <td>{!! Form::select('categorie3', $all_categories, $categories[2], ['placeholder' => 'Choisir catégorie...']) !!}
                </td>
            </tr>
            </tr>
            <tr>
                <td>{!! Form::label('is_visible', 'Visible sur le site') !!}</td>
                <td>{!! Form::checkbox('is_visible', 1, $is_visible) !!}</td>
            </tr>
            <tr>
                <td></td>
                <td>{!! Form::submit('Modifier le plat') !!}</td>
            </tr>
        </table>
    {!! Form::close() !!}

@endsection