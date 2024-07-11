<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class surat extends Controller
{
    public function index()
    {
        // Pass any required data to the view
        return view('surat');
    }
}
