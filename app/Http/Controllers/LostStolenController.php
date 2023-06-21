<?php

namespace App\Http\Controllers;

use App\Models\LostStolen;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\LostStolenImport;
use App\Exports\LostStolenExport;


class LostStolenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return response()->json(LostStolen::with('alters', 'assets')->get());
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
        $lostStolen = LostStolen::create($request->all());
        return response()->json($lostStolen);
    }

    /**
     * Display the specified resource.
     */
    public function show($lostStolen)
    {
        //
        return response()->json(LostStolen::with('alters', 'assets')->where('id', $lostStolen)->get());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(LostStolen $lostStolen)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        LostStolen::where('id', '=', $id)->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($lostStolen)
    {
        //
        LostStolen::where('id', $lostStolen)->delete();
    }

    public function import_lostStolens(Request $request){

        $this->validate($request, [
            'file'  => 'required|mimes:xls,xlsx'
           ]);


        Excel::import(new LostStolenImport, $request->file('file')->getRealPath());
    }

    public function export_lostStolens(Request $request){
            return Excel::download(new LostStolenExport, 'LostStolens.xlsx');
     }

}
