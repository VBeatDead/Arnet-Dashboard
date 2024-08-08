<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\Dropdown;
use Illuminate\Support\Facades\Validator;


class RoomController extends Controller
{
    //
    public function index()
    {
        $user = User::find(session('user_id'));
        $room = Dropdown::where('type', 'room')->get();
        return view('room/index', ['rooms' => $room, 'user' => $user]);
    }

    public function create()
    {
        return view('room/create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $existingRoom = Dropdown::where('type', 'room')->where('subtype', $request->name)->first();
        if ($existingRoom) {
            return redirect()->back()->with('error', 'Room already exists.')->withInput();
        }

        $room = new Dropdown;
        $room->type = 'room';
        $room->subtype = $request->name;
        $room->save();

        return redirect('/room')->with('success', 'Room successfully created.');
    }


    public function edit($id)
    {
        $room = Dropdown::find($id);
        return view('room/edit', ['room' => $room]);
    }

    public function update(Request $request, $id)
    {
        $room = Dropdown::find($id);

        $existingRoom = Dropdown::where('type', 'room')->where('subtype', $request->name)->first();
        if ($existingRoom) {
            return redirect()->back()->with('error', 'Room already exists.')->withInput();
        }

        if ($room) {
            $room->subtype = $request->name;
            $room->save();
            return redirect('/room')->with('success', 'Room updated successfully.');
        } else {
            return redirect('/room')->with('error', 'Room not found.');
        }
    }
    public function destroy($id)
    {
        $room = Dropdown::find($id);

        if ($room) {
            $room->delete();
            return redirect('/room')->with('success', 'Room deleted successfully.');
        } else {
            return redirect('/room')->with('error', 'Room not found.');
        }
    }
}
