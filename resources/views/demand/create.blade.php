@extends('layouts.app')

@section('content')

  <h3 class="titleProfile">Ajouter une demande</h3>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

{!! Form::open(['action' => 'DemandController@store', 'method' => 'POST']) !!}
<table class="table">
    <tr>
        <td>{!! Form::label('title', "Nom du plat") !!}</td>
        <td>{!! Form::text('title', '', ['class' => 'form-control','placeholder' => 'Nom du plat']) !!}</td>
    </tr>
    <tr>
        <td>{!! Form::label('description', 'Description') !!}</td>
        <td>{!! Form::textarea('description', '', ['class' => 'form-control','placeholder' => 'Description de votre demande / plat'])
            !!}</td>
    </tr>
    <tr>
        <td>{!! Form::label('budget', 'Votre budget') !!}</td>
        <td>{!! Form::number('budget', 0, ['class' => 'form-control','placeholder' => 'Votre budget']) !!}</td>
    </tr>
    <tr>
        <td>{!! Form::label('phone', "Numero de téléphone :") !!}</td>
        <td>{!! Form::text('phone', '', ['class' => 'form-control','placeholder' => '06.........']) !!}</td>
    </tr>
    <tr>
        <td>{!! Form::label('email', "Email") !!}</td>
        <td>{!! Form::text('email', '', ['class' => 'form-control','placeholder' => 'Votre email']) !!}</td>
    </tr>
    <tr>
        <td></td>
        <td>{{ Form::button('<i class="fas fa-plus-circle"></i> Créer un plat', ['class' => 'btn btn-success btnHome',
            'type' => 'submit']) }}</td>
    </tr>
</table>
{!! Form::close() !!}

@endsection
