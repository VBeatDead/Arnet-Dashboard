<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Document;
use App\Models\Dropdown;
use App\Models\User;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class DocumentController extends Controller
{
    public function index()
    {
        $user = User::find(session('user_id'));
        $documents = Document::all();
        return view('surat.index', ['surat' => $documents, 'user' => $user]);
    }

    public function create()
    {
        $user = User::find(session('user_id'));
        $sto = Dropdown::where('type', 'sto')->get();
        $type = Dropdown::where('type', 'room')->get();
        return view('surat.create', ['sto' => $sto, 'type' => $type]);
    }

    public function store(Request $request)
    {
        Log::info('Store method called');
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'type_id' => 'required|integer',
            'brand' => 'required|string|max:255',
            'serial' => 'required|string|max:255',
            'first_sto_id' => 'required|string:max:255',
            'last_sto_id' => 'required|string|max:255',
            'evidence' => 'required|mimes:jpeg,png|max:2048',
            'berita_acara' => 'required|mimes:pdf,docx|max:2048',
            'status' => 'required|string|in:belum scrap,scrap',
            'tahun' => 'nullable|required_if:status,scrap|string|max:4'
        ]);

        if ($validator->fails()) {
            Log::info('Validation failed');
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Log::info('File upload detected');
        $evidence = $request->file('evidence');
        $evidenceName = time() . '_' . $evidence->getClientOriginalName();
        $evidencePath = $evidence->storeAs('uploads/evidence', $evidenceName, 'public');

        $beritaAcara = $request->file('berita_acara');
        $beritaAcaraName = time() . '_' . $beritaAcara->getClientOriginalName();
        $beritaAcaraPath = $beritaAcara->storeAs('uploads/berita_acara', $beritaAcaraName, 'public');

        $document = new Document();
        $document->name = $request->input('name');
        $document->type_id = $request->input('type_id');
        $document->brand = $request->input('brand');
        $document->serial = $request->input('serial');
        $document->first_sto_id = $request->input('first_sto_id');
        $document->last_sto_id = $request->input('last_sto_id');
        $document->evidence = $evidencePath;
        $document->ba = $beritaAcaraPath;
        $document->status = $request->input('status');
        $document->additional = $request->input('tahun');
        $document->save();

        Log::info('Document saved');

        return redirect()->route('document.index')->with('success', 'Document saved successfully.');
    }

    // public function show($id)
    // {
    //     $document = Document::findOrFail($id);
    //     return response($document->file)
    //         ->header('Content-Type', 'application/pdf');
    // }

    /**
     * Show the form for editing the specified resource.
     */
    // DocumentController.php

    public function edit($id)
    {
        $document = Document::find($id);
        $sto = Dropdown::where('type', 'sto')->get();
        $type = Dropdown::where('type', 'room')->get();
        return view('surat.edit', ['surat' => $document, 'sto' => $sto, 'type' => $type]);
    }

    public function update(Request $request, $id)
    {
        $document = Document::find($id);

        if (!$document) {
            return redirect()->back()->with('error', 'Document not found please try again.');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'type_id' => 'required|integer',
            'brand' => 'required|string|max:255',
            'serial' => 'required|string|max:255',
            'first_sto_id' => 'required|integer',
            'last_sto_id' => 'required|integer',
            'evidence' => 'nullable|mimes:jpeg,png|max:2048',
            'berita_acara' => 'nullable|mimes:pdf,docx|max:2048',
            'status' => 'required|string|in:belum scrap,scrap',
            'tahun' => 'nullable|required_if:status,scrap|string|max:4'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->hasFile('evidence')) {
            if ($document->evidence) {
                Storage::disk('public')->delete($document->evidence);
            }
            $evidence = $request->file('evidence');
            $evidenceName = time() . '_' . $evidence->getClientOriginalName();
            $evidencePath = $evidence->storeAs('uploads/evidence', $evidenceName, 'public');
            $document->evidence = $evidencePath;
        }

        if ($request->hasFile('berita_acara')) {
            if ($document->ba) {
                Storage::disk('public')->delete($document->ba);
            }
            $beritaAcara = $request->file('berita_acara');
            $beritaAcaraName = time() . '_' . $beritaAcara->getClientOriginalName();
            $beritaAcaraPath = $beritaAcara->storeAs('uploads/berita_acara', $beritaAcaraName, 'public');
            $document->ba = $beritaAcaraPath;
        }

        $document->name = $request->input('name');
        $document->type_id = $request->input('type_id');
        $document->brand = $request->input('brand');
        $document->serial = $request->input('serial');
        $document->first_sto_id = $request->input('first_sto_id');
        $document->last_sto_id = $request->input('last_sto_id');
        $document->status = $request->input('status');
        $document->additional = $request->input('tahun');
        $document->save();

        return redirect()->route('document.index')->with('success', 'Document updated successfully.');
    }

    public function destroy($id)
    {
        try {
            $document = Document::findOrFail($id);
            Storage::disk('public')->delete(str_replace(asset('storage/'), '', $document->ba));
            Storage::disk('public')->delete(str_replace(asset('storage/'), '', $document->evidence));
            $document->delete();

            return redirect()->route('document.index')->with('success', 'Document deleted successfully');
        } catch (\Exception $e) {
            return redirect()->route('document.index')->with('errors', [$e->getMessage()]);
        }
    }
}
