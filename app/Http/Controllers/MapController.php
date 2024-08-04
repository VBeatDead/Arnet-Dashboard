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
        Log::info('Store method called');

        $validator = Validator::make($request->all(), [
            'sto_id' => 'required|integer|exists:dropdowns,id',
            'room_id' => 'required|integer|exists:dropdowns,id',
            'file' => 'required|array',
            'file.*' => 'required|file|max:2048'
        ]);

        $validator->after(function ($validator) use ($request) {
            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $file) {
                    $extension = $file->getClientOriginalExtension();
                    $allowedExtensions = ['vsd', 'png', 'jpg', 'jpeg'];
                    if (!in_array($extension, $allowedExtensions)) {
                        $validator->errors()->add('file', 'All files must be of type .vsd, .png, .jpg, or .jpeg');
                    }
                }
            }
        });

        if ($validator->fails()) {
            Log::info('Validation failed');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $denah = new Map();
        $denah->sto_id = $request->input('sto_id');
        $denah->room_id = $request->input('room_id');

        $filePaths = [];
        if ($request->hasFile('file')) {
            foreach ($request->file('file') as $file) {
                $fileExtension = $file->getClientOriginalExtension();
                $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $timestamp = time();
                $fileName = $fileName . '-' . $timestamp . '.' . $fileExtension;

                if ($fileExtension == 'vsd') {
                    $filePath = $file->storeAs('uploads/denah', $fileName, 'public');
                    $convertedImagePath = $this->convertVsdToImage($filePath);
                    Log::info('Converted image path: ' . $convertedImagePath);
                    $filePaths[] = [
                        'file' => asset('storage/' . $filePath),
                        'converted_image' => asset($convertedImagePath)
                    ];
                } else {
                    $convertedImagePath = $file->storeAs('converted_images', $fileName, 'public');
                    $filePaths[] = [
                        'file' => null,
                        'converted_image' => asset('storage/' . $convertedImagePath)
                    ];
                }
            }
        }

        // Assuming only one file is handled per record; adjust if multiple files need to be handled differently
        $denah->file = $filePaths[0]['file'] ?? null;
        $denah->converted_image = $filePaths[0]['converted_image'] ?? null;
        $denah->save();

        Log::info('Denah saved');
        return redirect()->to('/denah')->with('success', 'STO Layout has been saved.');
    }


    public function show(Map $map)
    {
        //
    }

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

    public function update(Request $request, $id)
    {
        $denah = Map::find($id);

        if (!$denah) {
            return redirect()->back()->with('unusual', 'An Error Occurred, Please Try Again');
        }

        $validator = Validator::make($request->all(), [
            'sto_id' => 'required|integer|exists:dropdowns,id',
            'room_id' => 'required|integer|exists:dropdowns,id',
            'file.*' => 'nullable|file|max:2048'
        ]);

        $validator->after(function ($validator) use ($request) {
            if ($request->hasFile('file')) {
                foreach ($request->file('file') as $file) {
                    $extension = $file->getClientOriginalExtension();
                    $allowedExtensions = ['vsd', 'png', 'jpg', 'jpeg'];
                    if (!in_array($extension, $allowedExtensions)) {
                        $validator->errors()->add('file', 'All files must be of type .vsd, .png, .jpg, or .jpeg');
                    }
                }
            }
        });

        if ($validator->fails()) {
            Log::info('Validation failed');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->hasFile('file')) {
            if ($denah->file) {
                $oldFilePath = str_replace(asset('storage/'), '', $denah->file);
                Storage::disk('public')->delete($oldFilePath);
            }
            if ($denah->converted_image && $denah->file) {
                $oldConvertedImagePath = str_replace(asset('storage/'), '', $denah->converted_image);
                Storage::disk('public')->delete($oldConvertedImagePath);
            }

            Log::info('File upload detected');
            $filePaths = [];
            foreach ($request->file('file') as $file) {
                $fileExtension = $file->getClientOriginalExtension();
                $fileName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                $timestamp = time();
                $fileName = $fileName . '-' . $timestamp . '.' . $fileExtension;

                if ($fileExtension == 'vsd') {
                    $filePath = $file->storeAs('uploads/denah', $fileName, 'public');
                    $convertedImagePath = $this->convertVsdToImage($filePath);
                    Log::info('Converted image path: ' . $convertedImagePath);
                    $filePaths[] = [
                        'file' => asset('storage/' . $filePath),
                        'converted_image' => asset($convertedImagePath)
                    ];
                } else {
                    $convertedImagePath = $file->storeAs('converted_images', $fileName, 'public');
                    $filePaths[] = [
                        'file' => null,
                        'converted_image' => asset('storage/' . $convertedImagePath)
                    ];
                }
            }
            $denah->file = $filePaths[0]['file'] ?? null;
            $denah->converted_image = $filePaths[0]['converted_image'] ?? null;
        }

        $denah->sto_id = $request->input('sto_id');
        $denah->room_id = $request->input('room_id');
        $denah->save();

        Log::info('Denah updated');
        return redirect()->route('denah.index')->with('success', 'Layout data saved successfully.');
    }

    public function destroy($id)
    {
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

        $denah->delete();
        return redirect()->route('viewdenah')->with('success', 'Item deleted successfully.');
    }
}
