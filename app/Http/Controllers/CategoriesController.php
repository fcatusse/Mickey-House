<?php

namespace App\Http\Controllers;

use App\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CategoriesController extends Controller
{
  /*
  |--------------------------------------------------------------------------
  | Categories Controller
  |--------------------------------------------------------------------------
  |
  | This controller handles dishes categories that allow "tagging" the dishes.
  | Only the admin can access these functions.
  |
  | The function index returns the view of all categories.
  |
  | The function store saves a newly created category.
  |
  | The function show returns the view of the form to edit a category.
  |
  | The function update saves the updated category.
  |
  | The function destroy deletes the chosen category.
  |
  | The function create returns the view of the form to create a category.
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

        //Add the new category in the database
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

        //Add the newly updated category in the database
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
