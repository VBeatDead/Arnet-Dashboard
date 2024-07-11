<?php

namespace App\Http\Controllers;

use App\Models\Map;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class MapController extends Controller
{
    public function index()
    {

        if (session()->has('user_id')) {
            $denah = Map::all();
            return view('denah/index', ['denah' => $denah]);
        } else {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
    }

    public function create()
    {

        if (session()->has('user_id')) {
            $user = User::find(session('user_id'));
            return view('denah/create', ['user' => $user]);
        } else {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
    }

    public function store(Request $request)
    {
        Log::info('Store method called');
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'file' => 'required|file|max:2048'
        ]);

        $validator->after(function ($validator) use ($request) {
            if ($request->file('file')->getClientOriginalExtension() !== 'vsd') {
                $validator->errors()->add('file', 'The file must be a file of type: vsd.');
            }
        });

        if ($validator->fails()) {
            Log::info('Validation failed');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->file('file')) {
            Log::info('File upload detected');
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads/denah', $fileName, 'public');
            $convertedImagePath = $this->convertVsdToImage($filePath);
            Log::info('Converted image path: ' . $convertedImagePath);
        }

        $denah = new Map();
        $denah->name = $request->input('name');
        $denah->file = asset('storage/' . $filePath);
        $denah->converted_image = asset($convertedImagePath);
        $denah->save();

        Log::info('Denah saved');

        return redirect()->to('denah')->with('success', 'Denah STO berhasil disimpan.');
    }


    public function show(Map $map)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Map $denah)
    {
        if (session()->has('user_id')) {
            return view('denah.edit', ['denah' => $denah]);
        } else {
            return redirect()->route('login')->with('error', 'Silakan login terlebih dahulu.');
        }
    }

    public function convertVsdToImage($filePath)
    {
        $outputPath = storage_path('app/public/converted_images/' . pathinfo($filePath, PATHINFO_FILENAME) . '.png');
        $command = "soffice --headless --convert-to png --outdir " . escapeshellarg(dirname($outputPath)) . " " . escapeshellarg(storage_path('app/public/' . $filePath));
        $output = shell_exec($command . " 2>&1");

        Log::info("Conversion command: " . $command);
        Log::info("Conversion output: " . $output);

        if (file_exists($outputPath)) {
            Log::info("File exists: " . $outputPath);
            return 'storage/converted_images/' . basename($outputPath);
        } else {
            Log::error("File not found after conversion: " . $outputPath);
            return null;
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Map $map)
    {
        // Validate the form data
        $request->validate([
            'name' => 'required|string|max:255',
            'file' => 'nullable|file|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Update the map with the new data
        $map->name = $request->input('name');

        // Handle the file upload if there is a new file
        if ($request->hasFile('file')) {
            $filePath = $request->file('file')->store('files', 'public');
            $map->file = $filePath;
        }

        // Save the updated map
        $map->save();

        // Redirect to the index page with a success message
        return redirect()->route('denah.index')->with('success', 'Denah updated successfully.');
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        // Find the item by ID
        dd($id);
        $denah = Map::find($id);
        // Delete the item
        $denah->delete();

        // Optionally, you can add a success message or redirect back
        return redirect()->back()->with('success', 'Item deleted successfully.');
    }
}
