<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Map;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;

class UserController extends Controller
{

    public function register()
    {
        return view('auth/register');
    }

    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:12|unique:users',
            'password' => 'required|string',
        ]);

        $this->create($request->all());

        return redirect('/login');
    }
    public function index()
    {

        return view('auth/login');
    }

    public function signin(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('name', 'password');

        $user = User::where('name', $credentials['name'])->first();
        if ($user && Hash::check($credentials['password'], $user->password)) {
            $request->session()->put('user_id', $user->id);
            return redirect()->route('denah.index');
        } else {
            return redirect()->route('login')->with('error', 'Username or password incorrect.');
        }
    }

    public function logout(Request $request)
    {
        $request->session()->forget('user_id');
        $request->session()->flush();
        return redirect()->route('login');
    }

    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'password' => Hash::make($data['password']),
            'role' => '1',
        ]);
    }

    public function createView()
    {
        return view('user/create');
    }

    public function store(Request $request)
    {
        //
        $request->validate([
            'name' => 'required|string|max:12|unique:users',
            'password' => 'required|string',
            'role' => 'required',
        ]);

        $user = User::create([
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);
        $user->save();
        return redirect()->to('viewuser')->with('success', 'User created successfully');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        $user = User::all();
        
        return view('user/index', ['users' => $user]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        //
        $user = User::find($id);
        return view('user/edit', ['user' => $user]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:12',
            'password' => 'nullable|string',
            'role' => 'required|string',
        ]);

        $user = User::find($user->id);        
        $user->name = $request->name;
        if ($request->password) {
            $user->password = Hash::make($request->password);
        }
        $user->role = $request->role;
        $user->save();
        return redirect()->to('viewuser')->with('success', 'User updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        
        $user = User::find($id);
        $user->delete();
        return redirect()->to('viewuser')->with('success', 'User deleted successfully');
    }
}
