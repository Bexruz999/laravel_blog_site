<?php

namespace App\Http\Controllers;

use App\Http\Resources\BlogCollection;
use App\Models\Blog;
use Illuminate\Http\Request;

class BlogController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return new BlogCollection(Blog::take(20)->get());
    }

    /**
     * Display the create form
     */
    public function create() {
        return response()->json('the form');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        return response()->json($request);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return Blog::find($id);
    }

    /**
     * Display the edit form
     */
    public function edit(string $id) {
        return Blog::find($id);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $blog = Blog::find($id);
        return response()->json([$request->all(), $id, $blog]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        return Blog::find($id);
    }
}
