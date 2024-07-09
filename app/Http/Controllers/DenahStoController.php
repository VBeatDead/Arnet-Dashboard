<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DenahSto;

class DenahStoController extends Controller
{
    public function index()
    {
        $denahs = DenahSto::all();
        return view('denah/index', compact('denahs'));
    }

    public function create()
    {
        return view('denah/create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'image' => 'required|file|mimes:jpeg,png,jpg,gif,svg'
        ]);

        $imageFile = $request->file('image');
        $imageContent = file_get_contents($imageFile);

        DenahSto::create([
            'lokasi_sto' => $request->name,
            'denah' => $imageContent
        ]);

        return redirect()->route('index');
    }
}
