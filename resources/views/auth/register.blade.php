@extends('layouts.app')


@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">


          <div class="card-body">
            <form method="POST" action="{{ route('register') }}">
              @csrf

              <div class="form-group row">
                <label for="username" class="col-md-4 col-form-label text-md-right">{{ __('Nom d\'utilisateur') }}</label>

                <div class="col-md-6">
                  <input id="username" type="text" class="form-control{{ $errors->has('username') ? ' is-invalid' : '' }}" name="username" value="{{ old('username') }}" required autofocus>

                  @if ($errors->has('username'))
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('username') }}</strong>
                    </span>
                  @endif
                </div>
              </div>

              <div class="form-group row">
                <label for="firstname" class="col-md-4 col-form-label text-md-right">Prénom</label>

                <div class="col-md-6">
                  <input id="firstname" type="text" class="form-control{{ $errors->has('firstname') ? ' is-invalid' : '' }}" name="firstname" value="{{ old('firstname') }}" required>

                  @if ($errors->has('firstname'))
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('firstname') }}</strong>
                    </span>
                  @endif
                </div>
              </div>

              <div class="form-group row">
                <label for="lastname" class="col-md-4 col-form-label text-md-right">Nom</label>

                <div class="col-md-6">
                  <input id="lastname" type="text" class="form-control{{ $errors->has('lastname') ? ' is-invalid' : '' }}" name="lastname" value="{{ old('lastname') }}" required>

                  @if ($errors->has('lastname'))
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('lastname') }}</strong>
                    </span>
                  @endif
                </div>
              </div>

              <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">{{ __('E-Mail') }}</label>

                <div class="col-md-6">
                  <input id="email" type="email" class="form-control{{ $errors->has('email') ? ' is-invalid' : '' }}" name="email" value="{{ old('email') }}" required>

                  @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('email') }}</strong>
                    </span>
                  @endif
                </div>
              </div>

              <div class="form-group row">
                <label for="address" class="col-md-4 col-form-label text-md-right">{{ __('Adresse') }}</label>

                <div class="col-md-6">
                  <input id="address" type="text" class="form-control{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address" value="{{ old('address') }}" required>
                  <small class="form-text text-muted">Numéro et rue</small>

                  @if ($errors->has('address'))
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('address') }}</strong>
                    </span>
                  @endif
                </div>
              </div>

              <div class="form-group row">
                <label for="postal_code" class="col-md-4 col-form-label text-md-right"></label>

                <div class="col-md-6">
                  <input id="postal_code" type="number" class="form-control{{ $errors->has('postal_code') ? ' is-invalid' : '' }}" name="postal_code" value="{{ old('postal_code') }}" required>
                  <small class="form-text text-muted">Code postal</small>

                  @if ($errors->has('postal_code'))
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('postal_code') }}</strong>
                    </span>
                  @endif
                </div>
              </div>

              <div class="form-group row">
                <label for="city" class="col-md-4 col-form-label text-md-right"></label>

                <div class="col-md-6">
                  <input id="city" type="text" class="form-control{{ $errors->has('city') ? ' is-invalid' : '' }}" name="city" value="{{ old('city') }}" required>
                  <small class="form-text text-muted">Ville</small>

                  @if ($errors->has('city'))
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('city') }}</strong>
                    </span>
                  @endif
                </div>
              </div>

              <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">{{ __('Mot de passe') }}</label>

                <div class="col-md-6">
                  <input id="password" type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                  @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                      <strong>{{ $errors->first('password') }}</strong>
                    </span>
                  @endif
                </div>
              </div>

              <div class="form-group row">
                <label for="password-confirm" class="col-md-4 col-form-label text-md-right">{{ __('Confirmez votre mot de passe') }}</label>

                <div class="col-md-6">
                  <input id="password-confirm" type="password" class="form-control" name="password_confirmation" required>
                </div>
              </div>

              <div class="form-group row mb-0">
                <div class="col-md-6 offset-md-4">
                  <button type="submit" class="btn btn-primary">
                    {{ __('Inscription') }}
                  </button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
@endsection
