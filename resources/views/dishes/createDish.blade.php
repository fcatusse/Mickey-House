@extends('layouts.app')

@section('content')

  <h3 class="titleProfile">Ajouter un plat</h3>

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
<table class="table my-4">
    <tr>
        <td>{!! Form::label('name', "Nom du plat") !!}</td>
        <td>{!! Form::text('name', '', ['class' => 'form-control','placeholder' => 'Nom du plat']) !!}</td>
    </tr>
    <tr>
        <td>{!! Form::label('description', 'Description') !!}</td>
        <td>{!! Form::textarea('description', '', ['class' => 'form-control','placeholder' => 'Description du plat'])
            !!}</td>
    </tr>
    <tr>
        <td>{!! Form::label('photo1', 'Image principale*') !!}</td>
        <td>{!! Form::file('photo1', ['class' => 'form-control-file']) !!}</td>
    </tr>
    <tr>
        <td>{!! Form::label('photo2', 'Image') !!}</td>
        <td>{!! Form::file('photo2', ['class' => 'form-control-file']); !!}</td>
    </tr>
    <tr>
        <td>{!! Form::label('photo3', 'Image') !!}</td>
        <td>{!! Form::file('photo3', ['class' => 'form-control-file']); !!}</td>
    </tr>
    <tr>
        <td>{!! Form::label('nb_servings', 'Quantité disponible') !!}</td>
        <td>{!! Form::number('nb_servings', '', ['class' => 'form-control','placeholder' => 'Quantité disponible']) !!}</td>
    </tr>
    <tr>
        <td>{!! Form::label('price', 'Prix par part') !!}</td>
        <td>{!! Form::number('price', 0, ['class' => 'form-control','placeholder' => 'Prix par part']) !!}</td>
    </tr>
    <tr>
        <td>{!! Form::label('categorie1', 'Categorie principale*') !!}</td>
        <td>{!! Form::select('categorie1', $my_categories, null, ['class' => 'form-control', 'placeholder' => 'Choisir
            catégorie...']) !!}
        </td>
    </tr>
    <tr>
        <td>{!! Form::label('categorie2', 'Categorie secondaire') !!}</td>
        <td>{!! Form::select('categorie2', $my_categories, null, ['class' => 'form-control', 'placeholder' => 'Choisir
            catégorie...']) !!}
        </td>
    </tr>
    <tr>
        <td>{!! Form::label('categorie3', 'Categorie secondaire') !!}</td>
        <td>{!! Form::select('categorie3', $my_categories, null, ['class' => 'form-control', 'placeholder' => 'Choisir
            catégorie...']) !!}
        </td>
    </tr>
    </tr>
    <tr>
        <td>{!! Form::label('is_visible', 'Visible sur le site') !!}</td>
        <td>{!! Form::checkbox('is_visible', 1, true) !!}</td>
    </tr>
    <tr>
        <td></td>
        <td>{{ Form::button('<i class="fas fa-plus-circle"></i> Créer un plat', ['class' => 'btn btn-success btnHome',
            'type' => 'submit']) }}</td>
    </tr>
</table>
{!! Form::close() !!}

@endsection
