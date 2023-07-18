<?php

namespace App\Http\Controllers;

use App\Models\Movies;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class MoviesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $movies = Movies::all();

        if ($movies->isEmpty()) {
            return response()->json($movies, 204);
        }

        return response()->json($movies, 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $path = public_path('upload/');

        if (!File::isDirectory($path)) {
            File::makeDirectory($path, 0777, true, true);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $movies = Movies::find($id);

        if (empty($movies)) {
            return response()->json($movies, 204);
        }

        return response()->json($movies, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Movies $movies)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movies $movies)
    {
        //
    }
}
