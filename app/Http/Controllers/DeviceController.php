<?php

namespace App\Http\Controllers;

use App\Models\Dropdown;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class DeviceController extends Controller
{
    public function index()
    {
        $user = User::find(session('user_id'));
        $devices = Dropdown::where('type', 'topology')->get();
        // Sort by name
        $devices = $devices->sortBy('subtype');
        return view('device/index', ['devices' => $devices, 'user' => $user]);
    }

    public function create()
    {
        return view('device.create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $exists = Dropdown::where('type', 'topology')->where('subtype', $request->name)->exists();

        if ($exists) {
            return redirect()->back()->with('errors', ['The Topology location already exists.'])->withInput();
        }

        $device = new Dropdown;
        $device->type = 'topology';
        $device->subtype = $request->name;
        $device->save();

        return redirect('/device')->with('success', 'Device successfully created');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $device = Dropdown::find($id);
        if ($device) {
            $device->subtype = $request->name;
            $device->save();
            return redirect('/device')->with('success', 'Device successfully updated');
        } else {
            return redirect('/device')->with('error', 'Device not found');
        }
    }

    public function destroy($id)
    {
        $device = Dropdown::find($id);
        if ($device) {
            $device->delete();
            return redirect('/device')->with('success', 'Device successfully deleted');
        } else {
            return redirect('/device')->with('error', 'Device not found');
        }
    }
}
