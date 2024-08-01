<?php

namespace App\Http\Controllers;

use App\Models\Core;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\DB;

class CoreController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cores = Core::all();

        $chartData = [];
        foreach ($cores as $core) {
            if (
                !is_numeric($core->ccount) && $core->ccount == 0 &&
                !is_numeric($core->good) && $core->good == 0 &&
                !is_numeric($core->bad) && $core->bad == 0 &&
                !is_numeric($core->used) && $core->used == 0 &&
                !is_numeric($core->total) && $core->total == 0
            ) {
                continue;
            }

            $chartData[] = [
                'ruas' => $core->segment,
                'ccount' => $core->ccount,
                'good' => $core->good,
                'bad' => $core->bad,
                'used' => $core->used,
                'total' => $core->total,
            ];
        }

        return view('core.index', compact('chartData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('core.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:2048',
        ]);
        $fileName = 'Core.' . $request->file('file')->getClientOriginalExtension();
        if (Storage::disk('public')->exists('core/' . $fileName)) {
            Storage::disk('public')->delete('core/' . $fileName);
        }
        $request->file('file')->storeAs('core', $fileName, 'public');
        shell_exec("python ../resources/pyScript/core.py");
        return redirect()->route('core.index')->with('success', 'File berhasil diupload.');
    }
    /**
     * Display the specified resource.
     */
    public function show(Core $core)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Core $core)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Core $core)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(core $core)
    {
        //
    }
}
