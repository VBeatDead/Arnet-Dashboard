<?php

namespace App\Http\Controllers;

use App\Models\Dropdown;
use App\Models\Map;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB; // Add this line at the top if not already present

class TopologyController extends Controller
{
    //
    public function index()
    {
        $user = User::find(session('user_id'));
        $topologies = DB::table('topology')
            ->join('dropdowns', 'topology.device_id', '=', 'dropdowns.id')
            ->select('topology.*', 'dropdowns.subtype as device_type')
            ->get();

        return view('topology.index', ['user' => $user, 'topologies' => $topologies]);
    }


    public function store(Request $request) {
        Log::info('Store method called', ['request' => $request->all()]);
    
        $validator = Validator::make($request->all(), [
            'device_id' => 'required|integer|exists:dropdowns,id',
            'file' => 'required|file|max:2048'
        ]);
    
        $validator->after(function ($validator) use ($request) {
            if ($request->file('file')) {
                $extension = $request->file('file')->getClientOriginalExtension();
                $allowedExtensions = ['png', 'jpg', 'jpeg'];
                Log::info('File extension validation', ['extension' => $extension, 'allowed' => $allowedExtensions]);
                if (!in_array($extension, $allowedExtensions)) {
                    $validator->errors()->add('file', 'File must be of type png, jpg, or jpeg');
                    Log::warning('Invalid file extension', ['extension' => $extension]);
                }
            }
        });
    
        if ($validator->fails()) {
            Log::error('Validation failed', ['errors' => $validator->errors()]);
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
        $file = $request->file('file');
        $originalFileName = $file->getClientOriginalName();
        Log::info('File information', ['originalFileName' => $originalFileName]);
    
        $filePath = $file->storeAs('uploads', $originalFileName, 'public');
        Log::info('File stored', ['filePath' => $filePath]);
    
        DB::table('topology')->insert([
            'file' => $originalFileName,
            'device_id' => $request->input('device_id'),
            'last_updated' => now(),
        ]);
        Log::info('Topology record inserted', ['file' => $originalFileName, 'device_id' => $request->input('device_id')]);
    
        return redirect()->route('topology.index')->with('success', 'Topology file uploaded successfully!');
    }
    
    public function create()
    {
        $topology = Dropdown::where('type', 'topology')->get();
        return view('topology/create', ['topology' => $topology]);
    }
}
