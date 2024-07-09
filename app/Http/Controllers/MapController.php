<?php

namespace App\Http\Controllers;

use App\Models\Map;
use App\Http\Requests\UploadFileRequest;
use App\Http\Requests\UpdateFileRequest;

class MapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Pass any required data to the view
        return view('denah/index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
        return view('denah/create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(UploadFileRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Map $map)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Map $map)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFileRequest $request, Map $map)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Map $map)
    {
        //
    }
}
