<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DenahSto;

class DenahStoController extends Controller
{
    public function index()
    {
        $denahs = DenahSto::all();
        return view('denah.index', compact('denahs'));
    }

    public function create()
    {
        return view('denah.create');
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'vsd_file' => [
                'required',
                'file',
                function ($attribute, $value, $fail) {
                    $allowedExtensions = ['vsd'];
                    $extension = $value->getClientOriginalExtension();
                    if (!in_array($extension, $allowedExtensions)) {
                        $fail('The ' . $attribute . ' must be a file of type: vsd.');
                    }
                },
                'max:2048',
            ],
        ]);

        if ($request->hasFile('vsd_file')) {
            $vsdFile = $request->file('vsd_file');
            if ($vsdFile->isValid()) {
                $vsdContent = file_get_contents($vsdFile);

                DenahSto::create([
                    'lokasi_sto' => $request->name,
                    'denah' => $vsdContent // Simpan konten file VSD ke dalam kolom 'denah'
                ]);

                return redirect()->route('denah.index')->with('success', 'File VSD berhasil diunggah.');
            } else {
                return redirect()->back()->withInput()->withErrors(['vsd_file' => 'File VSD tidak valid.']);
            }
        }

        return redirect()->back()->withInput()->withErrors(['vsd_file' => 'File VSD tidak ditemukan.']);
    }
}
