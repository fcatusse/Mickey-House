<?php

namespace App\Http\Controllers;

use App\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Categories::all();
        return view('admin.categories.index', [
            'categories' => $categories
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
        // Check & Collect the request data
        $data = $request->validate([
            'title' => 'required|string',
        ]);

        //Add the new task in the database
        $category = Categories::create($data);

        Session::flash('alert-success', 'The category has been created with success.');
        return redirect()->action('CategoriesController@index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Categories  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Categories $category)
    {
        return view('admin.categories.edit', [
            'category' => $category
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Categories  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Categories $category)
    {
        // Check & Collect the request data
        $data = $request->validate([
            'title' => 'required|string',
        ]);

        //Add the new task in the database
        $category->update($data);

        Session::flash('alert-success', 'The category has been updated with success.');
        return redirect()->action('CategoriesController@index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Categories  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Categories $category)
    {
        $category->delete();
        Session::flash('alert-danger', 'The category has been deleted with success.');
        return redirect()->action('CategoriesController@index');
    }

    public function create()
    {
        return view('admin.categories.create');
    }
}
