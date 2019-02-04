@extends('layouts.app') @section('content')
<h1 class="titleDeamndBoard">Ils cherchent des cuisiniers</h1>
@if(count($demands) > 0)
@foreach($demands as $demand)
<div class="card mt-4">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-3 text-center">
                <img src="{{ asset('img/icons/cooking.png') }}" />
            </div>
            <div class="col-sm-9">
                <h3 class="text-capitalize">
                    {{$demand->title}}
                </h3>
                <p>
                    {{$demand->description}}
                </p>
                <div class="priceHome badge badge-secondary contactInfo">
                    Contact {{$demand->phone}} / {{$demand->email}}
                </div>
                <div class="priceHome badge badge-success demandBudget">
                    Budget {{$demand->budget}} €
                </div>
            </div>
        </div>
    </div>
</div>
@endforeach
@else
<h1>Pas encore de demandes.</h1>
@endif
@endsection