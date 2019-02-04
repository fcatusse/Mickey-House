<?php

namespace App\Http\Controllers;

use App\Demand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class DemandController extends Controller
{
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
        // dd($data);
        //Add your demande to database
        $category = Demand::create($data);
        Session::flash('alert-success', 'Votre demande a été ajoutée avec succès !');
        return redirect()->route('home');
    }
}
