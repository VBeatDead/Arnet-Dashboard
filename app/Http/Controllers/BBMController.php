<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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

        // Fetch the data for the table view, ensuring no duplicate STO entries
        $bbmDataQuery = DB::table('bbm')
            ->join('dropdowns', 'bbm.sto_id', '=', 'dropdowns.id')
            ->select('bbm.Lokasi', 'dropdowns.subtype as STO', 'bbm.BBM_L', 'bbm.UPDATED_AT')
            ->where('bbm.Lokasi', 'MALANG')
            ->whereIn('bbm.sto_id', $uniqueStos->keys())
            ->orderBy('bbm.UPDATED_AT', 'desc');

        // Filter data by selected STO ID if provided
        if ($stoId) {
            $bbmDataQuery->where('bbm.sto_id', $stoId);
        }

        $bbmData = $bbmDataQuery->get();

        // Fetch data for the line chart, grouped by date and STO ID
        $chartData = DB::table('bbm')
            ->select(DB::raw('sto_id, DATE(UPDATED_AT) as date, SUM(BBM_L) as total_bbm'))
            ->whereIn('sto_id', $uniqueStos->keys())
            ->groupBy('sto_id', 'date')
            ->orderBy('date', 'asc')
            ->get();

        // Pass data to the view
        return view('bbm.index', [
            'bbmData' => $bbmData,
            'chartData' => $chartData,
            'availableStos' => $uniqueStos,
            'currentStoId' => $stoId
        ]);
    }
}
