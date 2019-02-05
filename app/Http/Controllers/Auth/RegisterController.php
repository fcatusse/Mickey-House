<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Config;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    | The registration requires the following data: username, first name, last
    | name, address (street and number, postcode, city), email and password.
    | The address is used to directly add the geographical coordinates (latitude
    | and longitude) of the user in the database to provide an enhanced user
    | experience.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'username' => ['required', 'string', 'max:255', 'unique:users'],
            'firstname' => ['required', 'string', 'max:255'],
            'lastname' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'postal_code' => ['required', 'numeric', 'digits:5'],
            'city' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
      // reverse geocoding of the user's address
      $arr = [' ', '-'];
      $json = file_get_contents("https://nominatim.openstreetmap.org/search/reverse?email=".config('app.email')."&format=json&street=".str_replace ($arr , '+' , $data['address']) ."&city=".str_replace ($arr , '+' , $data['city'])."&country=france&postalcode=".$data['postal_code']."&limit=1");
      $decoded = json_decode($json);

      // success alert
      Session::flash('alert-success', 'Welcome!');
      
      return User::create([
          'username' => $data['username'],
          'firstname' => $data['firstname'],
          'lastname' => $data['lastname'],
          'email' => $data['email'],
          'address' => $data['address'],
          'lat' => $decoded[0]->lat,
          'long' => $decoded[0]->lon,
          'postal_code' => $data['postal_code'],
          'city' => $data['city'],
          'password' => Hash::make($data['password']),
      ]);
    }
}
