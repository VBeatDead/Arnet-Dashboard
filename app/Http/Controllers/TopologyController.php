<?php

namespace App\Http\Controllers;

use App\Models\Dropdown;
use App\Models\Map;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class TopologyController extends Controller
{
    public function index()
    {
        $user = User::find(session('user_id'));
        $topologies = DB::table('topology')
            ->join('dropdowns', 'topology.device_id', '=', 'dropdowns.id')
            ->select('topology.*', 'dropdowns.subtype as device_type')
            ->get();

        return view('topology.index', ['user' => $user, 'topologies' => $topologies]);
    }

    public function store(Request $request)
    {
        Log::info('Store method called', ['request' => $request->all()]);

        $validator = Validator::make($request->all(), [
            'device_id' => 'required|integer|exists:dropdowns,id',
            'file' => 'required|file|mimes:png,jpg,jpeg|max:2048'
        ]);

        if ($validator->fails()) {
            Log::error('Validation failed', ['errors' => $validator->errors()]);
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $file = $request->file('file');
        $originalFileName = $file->getClientOriginalName();
        $fileName = pathinfo($originalFileName, PATHINFO_FILENAME);
        $extension = $file->getClientOriginalExtension();
        $filePath = 'uploads/topology/' . $originalFileName;

        $counter = 1;
        while (Storage::disk('public')->exists($filePath)) {
            $newFileName = $fileName . '_' . $counter . '.' . $extension;
            $filePath = 'uploads/topology/' . $newFileName;
            $counter++;
        }

        $file->storeAs('uploads/topology', basename($filePath), 'public');

        DB::table('topology')->insert([
            'file' => basename($filePath),
            'device_id' => $request->input('device_id'),
            'last_updated' => now(),
        ]);
        Log::info('Topology record inserted', ['file' => basename($filePath), 'device_id' => $request->input('device_id')]);

        return redirect()->route('topology.index')->with('success', 'Topology file uploaded successfully!');
    }

    public function create()
    {
        $topology = Dropdown::where('type', 'topology')->get();
        return view('topology.create', ['topology' => $topology]);
    }

    public function edit($id)
    {
        $topology = DB::table('topology')->where('id', $id)->first();
        $devices = Dropdown::where('type', 'topology')->get();
        return view('topology.edit', ['topology' => $topology, 'devices' => $devices]);
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'device_id' => 'required|integer|exists:dropdowns,id',
            'file' => 'nullable|file|mimes:png,jpg,jpeg|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $topology = DB::table('topology')->where('id', $id)->first();
        $filePath = $topology->file;

        if ($request->hasFile('file')) {
            if ($filePath && Storage::disk('public')->exists('uploads/topology/' . $filePath)) {
                Storage::disk('public')->delete('uploads/topology/' . $filePath);
            }

            $file = $request->file('file');
            $originalFileName = $file->getClientOriginalName();
            $fileName = pathinfo($originalFileName, PATHINFO_FILENAME);
            $extension = $file->getClientOriginalExtension();
            $filePath = 'uploads/topology/' . $originalFileName;

            $counter = 1;
            while (Storage::disk('public')->exists($filePath)) {
                $newFileName = $fileName . '_' . $counter . '.' . $extension;
                $filePath = 'uploads/topology/' . $newFileName;
                $counter++;
            }

            $file->storeAs('uploads/topology', basename($filePath), 'public');
        }

        DB::table('topology')->where('id', $id)->update([
            'device_id' => $request->input('device_id'),
            'file' => basename($filePath),
            'last_updated' => now(),
        ]);

        return redirect()->route('topology.index')->with('success', 'Topology updated successfully!');
    }

    public function destroy($id)
    {
        $topology = DB::table('topology')->where('id', $id)->first();
        if ($topology) {
            $filePath = $topology->file;
            if ($filePath && Storage::disk('public')->exists('uploads/topology/' . $filePath)) {
                Storage::disk('public')->delete('uploads/topology/' . $filePath);
            }
            DB::table('topology')->where('id', $id)->delete();
        }
        return redirect()->route('topology.index')->with('success', 'Topology deleted successfully!');
    }
}
