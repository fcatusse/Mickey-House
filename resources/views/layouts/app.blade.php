<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">


  <title>{{ config('app.name', 'Mickey House') }}</title>

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}"></script>
  <!--script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js" integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js" integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k" crossorigin="anonymous"></script-->
  <script>
  window.Laravel = <?php echo json_encode([
    'csrfToken' => csrf_token(),
  ]); ?>
  </script>
  <!-- This makes the current user's id available in javascript -->
  @if(!auth()->guest())
    <script>
    window.Laravel.userId = <?php echo auth()->user()->id; ?>
    </script>
  @endif

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito|Open+Sans:400,600,700,800" rel="stylesheet" type="text/css">

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css" integrity="sha384-UHRtZLI+pbxtHCWp1t77Bi1L4ZtiqrqD80Kn4Z8NTSRyMA2Fd33n5dQ8lWUE00s/" crossorigin="anonymous">

  <!-- Nous chargeons les fichiers CDN de Leaflet. Le CSS AVANT le JS -->
  <link rel="stylesheet" href="https://unpkg.com/leaflet@1.3.1/dist/leaflet.css" integrity="sha512-Rksm5RenBEKSKFjgI3a41vrjkw4EVPlJ3+OiI65vTjIdo9brlAacEuKOiQ5OFh7cOI1bkDwLqdLw3Zg0cRJAAQ=="
  crossorigin="" />
  <script src="https://unpkg.com/leaflet@1.3.1/dist/leaflet.js" integrity="sha512-/Nsx9X4HebavoBvEBuyp3I7od5tA0UzAxs+j83KgC8PU0kgB4XiK4Lfe4y4cgBtaRJQEIFCW+oC506aPT2L1zw=="
  crossorigin=""></script>

</head>

<body>
  <div id="app">
    <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
      <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
          Mickey House
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
        aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Left Side Of Navbar -->
        <ul class="navbar-nav mr-auto">
          <li class="nav-item active">
            <a id="home" class="nav-link" href="{{route('home')}}">Home <span class="sr-only">(current)</span></a>
          </li>
          <li class="nav-item">
            <a id="map-link" class="nav-link" href="/dishes/map">Autour de moi</a>
          </li>
          <li class="nav-item">
            <a id="top-10" class="nav-link" href="/users/best">Top 10</a>
          </li>
          <li class="nav-item">
            <a id="demandes" class="nav-link" href="/demands">Demandes</a>
          </li>
          <li class="nav-item">
            <a id="community" class="nav-link" href="/users/index">Communauté</a>
          </li>
          <form action="/dishes/search" method="POST" class="form-inline my-2 my-lg-0 ml-5">
            @csrf
            <input id="searchform" class="form-control mr-sm-2" type="text" name="keyword" placeholder="Rechercher un plat...">
            <button class="btn btn-secondary my-2 my-sm-0" type="submit">Rechercher</button>
          </form>
        </ul>

        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
          <!-- Authentication Links -->
          @guest
            <li class="nav-item">
              <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
            @if (Route::has('register'))
              <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
              </li>
            @endif
          @else
            <li class="nav-item dropdown">
              <a id="news" class="nav-link dropdown-toggle" id="notifications" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                News
              </a>
              <ul class="dropdown-menu" aria-labelledby="notificationsMenu" id="notificationsMenu">
                <li class="dropdown-header">Pas de notifications</li>
              </ul>
            </li>
            <li class="nav-item dropdown">
              <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
              aria-haspopup="true" aria-expanded="false" v-pre>
              {{ Auth::user()->username }} <span class="caret"></span>
            </a>

            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
              @if (Auth::user()->is_admin)
                <a href="{{route('adminPanel')}}" class="dropdown-item">Admin Panel</a>
              @endif
              <a id="add-dish" href="{{route('create.dish')}}" class="dropdown-item">Ajouter un plat</a>
              <a id="add-demand" href="{{route('create.demand')}}" class="dropdown-item">Ajouter une demande</a>
              <a id="my-page" href="{{route('user.show', Auth::user()->id)}}" class="dropdown-item">Ma page</a>
              <a id="my-orders" href="{{route('orders.show', Auth::user()->id)}}" class="dropdown-item">Mes
                commandes</a>
                <a id="my-dishes" href="{{route('dish.show.mine', Auth::user()->id)}}" class="dropdown-item">Mes
                  plats</a>
                  <a id="edit" href="{{route('user.edit')}}" class="dropdown-item">Editer mon
                    profil</a>
                    <a id="logout" class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                    document.getElementById('logout-form').submit();">
                    {{ __('Logout') }}
                  </a>

                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    @csrf
                  </form>
                </div>
              </li>
            @endguest
          </ul>
        </div>
      </div>
    </nav>
    <div class="jumbotron jumbotron-fluid">
      <div class="container">
        <h1 class="display-4 font-weight-bold">Mickey House</h1>
        <p class="lead font-weight-bold">La vente de plats entre particuliers.</p>
      </div>
    </div>
    <div class="flash-message container mt-4">
      @foreach (['danger', 'warning', 'success', 'info'] as $msg)
        @if(Session::has('alert-' . $msg))
          <p class="alert alert-{{ $msg }}">{{ Session::get('alert-' . $msg) }}</p>
        @endif
      @endforeach
    </div>

    <main class="container py-4">
      @yield('content')

      <hr class="featurette-divider mt-5">

      <!-- FOOTER -->
      <footer class="container mt-5">
        <p class="float-right"><a href="#">Back to top</a></p>
        <p class="text-center">&copy; 2018-2019 Company, Inc. &middot; <a href="#">Privacy</a> &middot; <a href="#">Terms</a></p>
      </footer>

    </main>
  </div>
</body>

</html>
