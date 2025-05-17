<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Poster;
use Illuminate\Http\Request;

class PosterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return response()->json(Poster::all(), 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $poster = Poster::find($id);

        if ($poster) {
            return response()->json($poster, 200);
        } else {
            return response()->json(['message' => 'Poster not found'], 404);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
