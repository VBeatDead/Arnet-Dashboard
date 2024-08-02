<?php

namespace App\Http\Controllers;

use App\Models\Dropdown;
use App\Models\Map;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class TopologyController extends Controller
{
    //
    public function index()
    {
        $user = User::find(session('user_id'));
        // dd($user->toArray());
        
        return view('topology/index', ['user' => $user]);
    }

    public function store(){

    }

    public function create(){
        return view('topology/create');
    }
}
