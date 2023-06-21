<?php

namespace App\Http\Controllers;

use App\Models\Document;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DocumentImport;
use App\Exports\DocumentExport;


class DocumentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return response()->json(Document::all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $document = Document::create($request->all());
        return response()->json($document);
    }

    /**
     * Display the specified resource.
     */
    public function show($document)
    {
        //
        return response()->json(Document::where('id', $document)->get());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Document $document)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        Document::where('id', '=', $id)->update(['documentName' => $request->documentName, 'documentType' => $request->documentType]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($document)
    {
        //
        Document::where('id', $document)->delete();
    }

    public function import_documents(Request $request){

        $this->validate($request, [
            'file'  => 'required|mimes:xls,xlsx'
           ]);


        Excel::import(new DocumentImport, $request->file('file')->getRealPath());
    }

    public function export_documents(Request $request){
            return Excel::download(new DocumentExport, 'Documents.xlsx');
     }

}
