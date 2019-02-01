@extends('layouts.app')

@section('content')

<h3>Classement des cuisiniers</h3>

<div class="row">
  @foreach($users as $user)
    <div class="col-sm-4">
      <div class="card mt-4">
        <div class="card-body">
          {{-- <span class="badge badge-secondary badgeHome">{{ $order->nb_servings }} Parts disponibles</span>
          --}}
          <div class="noteProfile text-center"><img src="{{asset('img/icons/chef.png')}}"> <br><h3><span class="badge badge-success">{{ round($user->avg_note, 1) }} / 5</span></h3></div>
          <h5 class="card-title titleHome"><a href="{{ "/users/show/". $user->id }}">{{$user->username}}</a></h5>
          <h6 class=" madeBy">{{$user->firstname}} {{$user->lastname}}</h6>
          <h6 class=" madeBy text-muted">{{$user->postal_code}} {{$user->city}}</h6>
          </div>
        </div>
      </div>
    @endforeach
  </div>



@endsection
