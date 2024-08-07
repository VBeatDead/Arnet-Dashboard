<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class BBMController extends Controller
{
    public function index(Request $request)
    {
        // Get the selected STO ID from the request or default to the first available STO ID
        $stoId = $request->input('sto_id', null);

        // Fetch unique STOs for the table view, avoiding duplicates
        $uniqueStos = DB::table('dropdowns')
            ->where('type', 'sto')
            ->pluck('subtype', 'id');

        // Fetch data for the line chart, grouped by date and STO ID
        $chartData = DB::table('bbm')
            ->select(DB::raw('sto_id, DATE(UPDATED_AT) as date, SUM(BBM_L) as total_bbm'))
            ->whereIn('sto_id', $uniqueStos->keys())
            ->groupBy('sto_id', 'date')
            ->orderBy('date', 'asc')
            ->get();

        // Filter unique STOs that have data
        $stosWithData = $chartData->pluck('sto_id')->unique();

        // Pass data to the view
        return view('bbm.index', [
            'chartData' => $chartData,
            'availableStos' => $uniqueStos->only($stosWithData),
            'currentStoId' => $stoId
        ]);
    }

    public function create()
    {
        return view('bbm.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls|max:2048',
        ]);
        $fileName = 'Bbm.' . $request->file('file')->getClientOriginalExtension();
        if (Storage::disk('public')->exists('bbm/' . $fileName)) {
            Storage::disk('public')->delete('bbm/' . $fileName);
        }
        $request->file('file')->storeAs('bbm', $fileName, 'public');
        shell_exec("python ../resources/pyScript/bbm.py");

        return redirect()->route('bbm.index')->with('success', 'File berhasil diupload.');
    }
}
