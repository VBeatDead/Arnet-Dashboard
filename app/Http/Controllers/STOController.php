<?php

namespace App\Http\Controllers;

use App\Models\Dropdown;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class STOController extends Controller
{
    public function index()
    {

        $user = User::find(session('user_id'));
        $sto = Dropdown::where('type', 'sto')->get();
        // sort bye name
        $sto = $sto->sortBy('subtype');
        return view('sto/index', ['stos' => $sto, 'user' => $user]);
    }

    public function create()
    {
        return view('sto/create');
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $sto = new Dropdown;
        $sto->type = 'sto';
        $sto->subtype = $request->name;
        $sto->save();
        return redirect('/sto');
    }

    public function edit($id)
    {
        $sto = Dropdown::find($id);
        return view('sto/edit', ['sto' => $sto]);
    }

    public function update(Request $request, $id)
    {
        $sto = Dropdown::find($id);
        $sto->subtype = $request->name;
        $sto->save();
        return redirect('/sto');
    }

    public function destroy($id)
    {
        $sto = Dropdown::find($id);
        $sto->delete();
        return redirect('/sto');
    }
}
