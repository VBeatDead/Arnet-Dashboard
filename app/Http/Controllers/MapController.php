<?php

namespace App\Http\Controllers;

use App\Models\Dropdown;
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
        $user = User::find(session('user_id'));
        // dd($user->toArray());
        $denah = Map::with(['sto', 'room'])->get();
        return view('denah/index', ['denah' => $denah, 'user' => $user]);
    }

    public function create()
    {
        $user = User::find(session('user_id'));
        $sto = Dropdown::where('type', 'sto')->get();
        $room = Dropdown::where('type', 'room')->get();
        return view('denah/create', ['room' => $room, 'sto' => $sto]);
    }

    public function store(Request $request)
    {
        // dd($request->all());
        Log::info('Store method called');
        $validator = Validator::make($request->all(), [
            'sto_id' => 'required|integer|exists:dropdowns,id',
            'room_id' => 'required|integer|exists:dropdowns,id',
            'file' => 'required|file|max:2048'
        ]);

        $validator->after(function ($validator) use ($request) {
            if ($request->file('file')) {
                $extension = $request->file('file')->getClientOriginalExtension();
                $allowedExtensions = ['vsd', 'png', 'jpg', 'jpeg'];
                if (!in_array($extension, $allowedExtensions)) {
                    $validator->errors()->add('file', 'File must be of type .vsd, .png, .jpg, or .jpeg');
                }
            }
        });



        if ($validator->fails()) {
            Log::info('Validation failed');
            return redirect()->back()->withErrors($validator)->withInput();
        }


        Log::info('File upload detected');
        $file = $request->file('file');
        $fileName = $file->getClientOriginalName();
        if ($request->file('file')->getClientOriginalExtension() == 'vsd') {
            $filePath = $file->storeAs('uploads/denah', $fileName, 'public');
            $convertedImagePath = $this->convertVsdToImage($filePath);
            Log::info('Converted image path: ' . $convertedImagePath);
        } else {
            $convertedImagePath = $file->storeAs('converted_images', $fileName, 'public');
        }

        $denah = new Map();
        $denah->sto_id = $request->input('sto_id');
        $denah->room_id = $request->input('room_id');
        if ($request->file('file')->getClientOriginalExtension() == 'vsd') {
            $denah->file = asset('storage/' . $filePath);
            $denah->converted_image = asset($convertedImagePath);
        } else {
            $denah->converted_image = asset('storage/' . $convertedImagePath);
        }
        $denah->save();

        Log::info('Denah saved');

        return redirect()->to('/denah')->with('success', 'STO Layout has been saved.');
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
        $sto = Dropdown::where('type', 'sto')->get();
        $room = Dropdown::where('type', 'room')->get();
        $denah = Map::find($denah->id);
        return view('denah.edit', ['denah' => $denah, 'sto' => $sto, 'room' => $room]);
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
    public function update(Request $request, $id)
    {
        $denah = Map::find($id);

        if (!$denah) {
            return redirect()->back()->with('unusual', 'An Error Occured, Please Try Again');
        }

        $validator = Validator::make($request->all(), [
            'sto_id' => 'required|integer|exists:dropdowns,id',
            'room_id' => 'required|integer|exists:dropdowns,id',
            'file' => 'nullable|file'
        ]);

        $validator->after(function ($validator) use ($request) {
            if ($request->file('file')) {
                $extension = $request->file('file')->getClientOriginalExtension();
                $allowedExtensions = ['vsd', 'png', 'jpg', 'jpeg'];
                if (!in_array($extension, $allowedExtensions)) {
                    $validator->errors()->add('file', 'File must be of type .vsd, .png, .jpg, or .jpeg');
                }
            }
        });

        if ($validator->fails()) {
            Log::info('Validation failed');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->file('file')) {
            if ($denah->file) {
                $oldFilePath = str_replace(asset('storage/'), '', $denah->file);
                Storage::disk('public')->delete($oldFilePath);
                Storage::disk('public')->delete(str_replace(asset('storage/'), '', $denah->converted_image));
            } else if ($denah->converted_image) {
                Storage::disk('public')->delete(str_replace(asset('storage/'), '', $denah->converted_image));
            }

            Log::info('File upload detected');
            $file = $request->file('file');
            $fileName = $file->getClientOriginalName();
            if ($request->file('file')->getClientOriginalExtension() == 'vsd') {
                $filePath = $file->storeAs('uploads/denah', $fileName, 'public');
                $convertedImagePath = $this->convertVsdToImage($filePath);
                Log::info('Converted image path: ' . $convertedImagePath);
                $denah->file = asset('storage/' . $filePath);
                $denah->converted_image = asset($convertedImagePath);
            } else {
                $convertedImagePath = $file->storeAs('converted_images', $fileName, 'public');
                $denah->converted_image = asset('storage/' . $convertedImagePath);
            }

        }

        $denah->sto_id = $request->input('sto_id');
        $denah->room_id = $request->input('room_id');
        $denah->save();

        Log::info('Denah updated');
        return redirect()->route('denah.index')->with('success', 'Layout data saved successfully.');
    }

    public function destroy($id)
    {
        // Find the item by ID
        $denah = Map::find($id);


        if (!$denah) {
            return redirect()->route('viewdenah')->with('errord', 'Item not found.');
        }

        if ($denah->file) {
            $oldFilePath = str_replace(asset('storage/'), '', $denah->file);
            Storage::disk('public')->delete($oldFilePath);
            Storage::disk('public')->delete(str_replace(asset('storage/'), '', $denah->converted_image));
        } else if ($denah->converted_image) {
            Storage::disk('public')->delete(str_replace(asset('storage/'), '', $denah->converted_image));
        }

        // Delete the item
        $denah->delete();

        // Optionally, you can add a success message or redirect back
        return redirect()->route('viewdenah')->with('success', 'Item deleted successfully.');
    }
}
