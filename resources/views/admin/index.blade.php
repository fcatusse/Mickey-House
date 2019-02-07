@extends('layouts.app')

@section('content')

<div class="card-deck">
  <div class="card">
    <img class="card-img-top mt-4" src="/img/icons/sitemap.png" style="max-width:60%;margin:0 auto;">
    <div class="card-body mx-auto text-center">
      <h3 class="card-title text-center">CATEGORIES</h3>
      <p class="card-text text-center">Gérer les categories.</p>
      <a class="btn btn-success" href="{{route('adminCat')}}">Gérer</a>
    </div>
  </div>
  <div class="card">
    <img class="card-img-top mt-4" src="/img/icons/content.png" style="max-width:60%;margin:0 auto;">
    <div class="card-body mx-auto text-center">
      <h3 class="card-title text-center">REVIEWS</h3>
      <p class="card-text text-center">Gérer les reviews.</p>
      <a class="btn btn-success" href="{{route('adminRev')}}">Gérer</a>
    </div>
  </div>
  <!-- <div class="card">
    <img class="card-img-top mt-4" src="/img/icons/analysis.png" style="max-width:60%;margin:0 auto;">
    <div class="card-body mx-auto text-center">
      <h3 class="card-title text-center">REVIEWS</h3>
      <p class="card-text text-center">Manage all your .....</p>
      <a class="btn btn-success" href="#">Go to</a>
    </div>
  </div> -->
</div>

@endsection
