<?php

namespace App\Http\Controllers;

use App\Models\Cme;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
class CmeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $cmes = Cme::all();

        # data for count column where the the sto_id is same from cmes
        $gds = Cme::select('sto_id',DB::raw('SUM(count) as total_count'))->groupBy('sto_id')->get(); 


        $grandtotal = [];
        foreach ($gds as $gd) {
            if (
                !is_numeric($gd->sto_id) && $gd->sto_id == 0 &&
                !is_numeric($gd->total_count) && $gd->total_count == 0
            ) {
                continue;
            }

            $grandtotal[] = [
                'id' => $gd->sto_id,
                'sto' => $gd->cmeSto->subtype,
                'total'=> $gd->total_count,
            ];
        }

        

        return view('cme.index', compact('grandtotal'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('cme.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:2048',
        ]);
        $fileName = 'Cme.' . $request->file('file')->getClientOriginalExtension();
        if (Storage::disk('public')->exists('cme/' . $fileName)) {
            Storage::disk('public')->delete('cme/' . $fileName);
        }
        $request->file('file')->storeAs('cme', $fileName, 'public');
        shell_exec("python ../resources/pyScript/cme.py");
        return redirect()->route('cme.index')->with('success', 'File berhasil diupload.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        // Ambil data berdasarkan ID
        $cmes = Cme::where('sto_id', $id)->get();

        $chartData = [];
        foreach ($cmes as $cme) {
            if (
                !is_numeric($cme->underfive) && $cme->underfive == 0 &&
                !is_numeric($cme->morethanfive) && $cme->morethanfive == 0 &&
                !is_numeric($cme->morethanten) && $cme->morethanten == 0 
            ) {
                continue;
            }

            $chartData[] = [
                'name' => $cme->cmeSto->subtype,
                'device' => $cme->cmeType->subtype,
                'underfive' => $cme->underfive,
                'morethanfive' => $cme->morethanfive,
                'morethanten' => $cme->morethanten,
            ];
        }
        // Kirim data ke view
        return view('cme.bar', compact('chartData'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cme $cme)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cme $cme)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cme $cme)
    {
        //
    }
}
