@extends('layouts.app')

@section('content')

  @php ($arr = json_encode((array)$arr))

    <h4><img src="/img/route.png" alt="route" height="42" width="42"> Trouver des plats près de chez moi </h4> 

  </div class="container">
      <div class="my-4" id="map" style='width: 80%; height: 400px; margin:auto'></div>
    </div>

  <script type="text/javascript">
      var lat = {{$user->lat}};
      var lon = {{$user->long}};
      var fromPHP = <? echo $arr ?>;
      console.log(fromPHP);

      var lat0 = {{$user->lat}};
      var lon0 = {{$user->long}};

      function init() {
         var map = new L.Map('map');

      	 L.tileLayer('https://{s}.tile.openstreetmap.fr/hot/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="http://openstreetmap.org">OpenStreetMap</a> contributors',
            maxZoom: 18
         }).addTo(map);

         map.setView([lat0, lon0], 14);

         var markers = [];
         for (var i = 0; i < fromPHP.length; i++) {
           markers.push([fromPHP[i]['lat'], fromPHP[i]['long'], fromPHP[i]['name'], fromPHP[i]['id'] ]);
         }

         for (var i=0; i <markers.length; i++) {
            var offset = (Math.floor(Math.random()*50)+10)* 0.00001;
            var sign = 1 - Math.random();
            var lat = markers[i][0]+offset*sign;
            sign = 1 - Math.random();
            var lon = markers[i][1]+offset;
            var popupText =  "<a href='/dish/"+markers[i][3]+"'>"+markers[i][2]+"</a>";

             var markerLocation = new L.LatLng(lat, lon);
             var marker = new L.Marker(markerLocation);
             map.addLayer(marker);
             marker.bindPopup(popupText);
         }
      }

      window.onload = function(){
          //initMap();
          init();
      };
</script>



@endsection
