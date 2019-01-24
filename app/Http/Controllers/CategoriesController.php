<?php

namespace App\Http\Controllers;

use App\Categories;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Categories::all();
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

        return response($category, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Categories  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Categories $category)
    {
        return $category;
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

        return response($category, 200);
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
        return response('Category item deleted', 200);
    }
}
