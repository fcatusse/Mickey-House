<?php

namespace App\Http\Controllers;

use App\Demand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DemandController extends Controller
{
  /*
  |--------------------------------------------------------------------------
  | Demands Controller
  |--------------------------------------------------------------------------
  |
  | This controller handles demands: when a user posts a specific demand to the
  | community (for instance: a barbecue for 20 people).
  |
  | The function index returns the view of the form to post a demand.
  |
  | The function board returns the demands that have been made to display them.
  |
  | The function store saves the demand into the database.
  |
  |
  */

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('demand.create');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function board()
    {
        $demands = Demand::all();

        return view('demand.index', [
            'demands' => $demands
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string',
            'description' => 'required|string',
            'budget' => 'required|numeric',
            'phone' => 'required|string',
            'email' => 'required|email',
        ]);

        $data['user_id'] = Auth::id();

        //Add your demand to database
        $category = Demand::create($data);
        Session::flash('alert-success', 'Votre demande a été ajoutée avec succès !');
        return redirect()->route('home');
    }
}
