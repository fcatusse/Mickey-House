@extends('layouts.app')

@section('content')

  @php ($cat = $dish[0]->categories)
  @php ($photos = $dish[0]->photos)

{{-- Display the dish information --}}

<div class="row">
    <div class="col">
      <div class="card">
            @isset ($dish[0]->photos[0])
            <img class="card-img-top" style="" src="{{ url('/storage/'.$dish[0]->photos[0]) }}">
            @endisset
            <div class="card-body">
                <span class="badge badge-secondary badgeHome">{{ $dish[0]->nb_servings }} Parts disponibles</span>
                <h5 class="card-title titleHome">{{$dish[0]->name}}</h5>
                <h6 class="text-muted madeBy"><span>Cuisiné par </span><a href="/users/show/{{$dish[0]->cook_id}}">{{$dish[0]->username}}</a></h6>
                <p class="card-text descriptionHome">{{$dish[0]->description}}</p>
            </div>
            <div class="card-footer catFooter">
                {{-- <b class="categorieHome">Catégories :</b> --}}
                @foreach($cat as $categorie)
                <small class="text-muted">{{ $categorie->title }} - </small>
                @endforeach
                <div class="priceHome badge badge-primary">{{$dish[0]->price}} € / Part</div>
            </div>
        </div>
    </div>
    <div class="col">
      {{-- Display the dish order part : if there are servings available show the form otherwise display an info message "unavailable "--}}
    <div class="orderCol">
      @if ($dish[0]->nb_servings > 0 && isset(Auth::user()->id))

      {!! Form::open(['action' => 'OrderController@storeAndUpdate', 'method'=>'POST']) !!}

      <div class="form-group">
        {{form::label('nb_servings', __('Nombre de parts'))}}
        {{form::select('nb_servings', $servings, null, ['class' => 'form-control'])}}
      </div>

      {{ Form::hidden('user_id', Auth::user()->id) }}
      {{ Form::hidden('dish_id', $dish[0]->id) }}
      {{ Form::hidden('price', $dish[0]->price) }}

      <div class="form-group">
      {{ Form::button('<i class="fas fa-shopping-cart"></i> Commander', ['class' => 'btn btn-success btnHome', 'type' => 'submit']) }}
      </div>

      {!! Form::close() !!}
    @elseif (isset(Auth::user()->id))
      <div class="alert alert-warning" role="alert" style="heigth:30px">
          <strong>Désolé...</strong> Ce plat n'est pas disponible pour le moment.
      </div>
    @else
      <div class="alert alert-warning" role="alert" style="heigth:30px">
          <strong>Désolé...</strong> Vous devez être connecté pour commander
      </div>
    @endif
    </div>
      <div class="my-4" id="map3" style='width: 400px; height: 300px; margin:auto'></div>
    </div>

  </div>

  <div class="my-4">
    @if (count($recommendations) > 0)
      <h3>Autres plats de ce cuisinier</h3>
      <div class="card-deck my-4">
        @for ($i = 1; $i <= count($recommendations); $i++)
              <div class="card" style="max-width: 24rem;">
                  @isset ($recommendations[$i-1]->photos[0])
                  <img class="card-img-top" style="" src="{{ url('/storage/'.$recommendations[$i-1]->photos[0]) }}">
                  @endisset
                  <div class="card-body">
                      <span class="badge badge-secondary badgeHome">{{ $recommendations[$i-1]->nb_servings }} Parts disponibles</span>
                      <h5 class="card-title titleHome">{{$recommendations[$i-1]->name}}</h5>
                      <p class="card-text descriptionHome">{{$recommendations[$i-1]->description}}</p>
                      <a class="btn btn-primary text-white btnHome" href="{{ "/dish/" . $recommendations[$i-1]->id }}">Voir le plat</a>
                      <span class="priceHome badge badge-success">{{$recommendations[$i-1]->price}} € / Part</span>
                  </div>
              </div>
        @endfor
      </div>
    @endif
  </div>
  <div id="full_address" style="visibility: hidden"> {{$full_address}}
  </div>



    <script>
    // Initialize and add the map
    function initMap() {
    // initialize
    var paris = {lat: 48.866667, lng: 2.333333};
    // The map, centered on paris
    var map = new google.maps.Map(
        document.getElementById('map3'), {zoom: 12, center: paris});
    // The marker, positioned at the center
    var marker = new google.maps.Marker({position: paris, map: map});
    codeAddress();
    }

    function codeAddress() {
    var geocoder;
    var address = document.getElementById('full_address').value;
    geocoder = new google.maps.Geocoder();
    geocoder.geocode( { 'address': address}, function(results, status) {
      if (status == 'OK') {
        map.setCenter(results[0].geometry.location);
        var marker = new google.maps.Marker({
            map: map,
            position: results[0].geometry.location
        });
      } else {
        alert('Geocode was not successful for the following reason: ' + status);
      }
    });
    }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=MYKEY&callback=initMap"
    async defer></script>

@endsection
