@extends('layouts.app')

@section('content')

    <code>Dishes > Create</code>

    {!! Form::open(['method' => 'put', 'files' => true]) !!}
        <table class="table">
            <tr>
                <td>{!! Form::label('name', "Nom du plat") !!}</td>
                <td>{!! Form::text('name', 'Nom du plat') !!}</td>
            </tr>
            <tr>
                <td>{!! Form::label('description', 'Description') !!}</td>
                <td>{!! Form::textarea('description', 'Description du plat') !!}</td>
            </tr>
            <tr>
                <td>{!! Form::label('photo1', 'Image principale*') !!}</td>
                <td>{!! Form::file('photo1') !!}</td>
            </tr>
            <tr>
                <td>{!! Form::label('photo2', 'Image') !!}</td>
                <td>{!! Form::file('photo2'); !!}</td>
            </tr>
            <tr>
                <td>{!! Form::label('photo3', 'Image') !!}</td>
                <td>{!! Form::file('photo3'); !!}</td>
            </tr>
            <tr>
                <td>{!! Form::label('nb_servings', 'Quantité disponible') !!}</td>
                <td>{!! Form::number('nb_servings', 0) !!}</td>
            </tr>
            <tr>
                <td>{!! Form::label('price', 'Prix part part') !!}</td>
                <td>{!! Form::number('price', 0) !!}</td>
            </tr>
            <tr>
                <td>{!! Form::label('categorie1', 'Categorie principale*') !!}</td>
                <td>{!! Form::select('categorie1', $my_categories, null, ['placeholder' => 'Choisir catégorie...']) !!}
                </td>
            </tr>
            <tr>
                <td>{!! Form::label('categorie2', 'Categorie secondaire') !!}</td>
                <td>{!! Form::select('categorie2', $my_categories, null, ['placeholder' => 'Choisir catégorie...']) !!}
                </td>
            </tr>
            <tr>
                <td>{!! Form::label('categorie3', 'Categorie secondaire') !!}</td>
                <td>{!! Form::select('categorie3', $my_categories, null, ['placeholder' => 'Choisir catégorie...']) !!}
                </td>
            </tr>
            </tr>
            <tr>
                <td>{!! Form::label('is_visible', 'Visible sur le site') !!}</td>
                <td>{!! Form::checkbox('is_visible', 1, true) !!}</td>
            </tr>
            <tr>
                <td></td>
                <td>{!! Form::submit('Créer un plat') !!}</td>
            </tr>
        </table>
    {!! Form::close() !!}

@endsection