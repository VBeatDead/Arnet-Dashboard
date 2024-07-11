<?php

namespace App\Http\Controllers;

use App\Models\User;
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
            return redirect()->route('login')->with('error', 'Username atau password salah.');
        }
    }


    public function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'password' => Hash::make($data['password']),
            'role' => '1',
        ]);
    }

    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        //
    }
}
