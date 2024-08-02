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
    // CmeController.php
    public function index()
    {
        $cmes = Cme::all();
        $lastUpdated = Cme::max('last_updated');
        $gds = Cme::select('sto_id', DB::raw('SUM(count) as total_count'))->groupBy('sto_id')->get();
        $grandtotal = [];
        $chartData = [];
        foreach ($gds as $gd) {
            if ($gd->sto_id && $gd->total_count) {
                $sto = $gd->cmeSto;
                $grandtotal[] = [
                    'id' => $gd->sto_id,
                    'sto' => $sto->subtype,
                    'total' => $gd->total_count,
                ];
                $types = Cme::select('type_id', DB::raw('SUM(count) as total'))
                    ->where('sto_id', $gd->sto_id)
                    ->groupBy('type_id')
                    ->get();
                $labels = [];
                $values = [];
                $colors = [];
                $typess = [];
                foreach ($types as $type) {
                    $typeInfo = $type->cmeType;
                    $labels[] = $typeInfo->subtype;
                    $values[] = $type->total;
                    $colors[] = sprintf('#%06X', mt_rand(0, 0xFFFFFF));
                    $typess[] = $typeInfo->id;
                }
                $chartData[] = [
                    'id' => $gd->sto_id,
                    'type' => $typess,
                    'labels' => $labels,
                    'values' => $values,
                    'colors' => $colors,
                ];
            }
        }
        return view('cme.index', compact('grandtotal', 'chartData', 'lastUpdated'));
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
    // CmeController.php
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

        // Update the last updated timestamp for all records
        DB::table('cmes')->update(['last_updated' => now()]);

        return redirect()->route('cme.index')->with('success', 'File berhasil diupload.');
    }

    /**
     * Display the specified resource.
     */
    public function show($sto_id, $typeId)
    {
        $cmes = Cme::where('sto_id', $sto_id)
            ->where('type_id', $typeId)
            ->get();

        $chartData = [];
        foreach ($cmes as $cme) {
            $underfive = $cme->underfive;
            $morethanfive = $cme->morethanfive;
            $morethanten = $cme->morethanten;
            $total = $underfive + $morethanfive + $morethanten;

            if ($total > 0) {
                $chartData[] = [
                    'name' => $cme->cmeSto->subtype,
                    'device' => $cme->cmeType->subtype,
                    'underfive' => $underfive,
                    'morethanfive' => $morethanfive,
                    'morethanten' => $morethanten,
                    'count' => $cme->count,
                    'percentages' => [
                        'underfive' => ($underfive / $total) * 100,
                        'morethanfive' => ($morethanfive / $total) * 100,
                        'morethanten' => ($morethanten / $total) * 100,
                    ],
                ];
            }
        }

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
