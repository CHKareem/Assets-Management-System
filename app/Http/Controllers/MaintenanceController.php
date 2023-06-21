<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MaintenanceImport;
use App\Exports\MaintenanceExport;

class MaintenanceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return response()->json(Maintenance::with('assets')->get());
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
        $maintenance = Maintenance::create($request->all());
        return response()->json($maintenance);
    }

    /**
     * Display the specified resource.
     */
    public function show($maintenance)
    {
        //
        return response()->json(Maintenance::with('assets')->where('id', $maintenance)->get());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Maintenance $maintenance)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        Maintenance::where('id', '=', $id)->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($maintenance)
    {
        //
        Maintenance::where('id', $maintenance)->delete();
    }

    public function import_maintenances(Request $request){

        $this->validate($request, [
            'file'  => 'required|mimes:xls,xlsx'
           ]);


        Excel::import(new MaintenanceImport, $request->file('file')->getRealPath());
    }

    public function export_maintenances(Request $request){
            return Excel::download(new MaintenanceExport, 'Maintenances.xlsx');
     }

     public function show_maintenances($maintenance){
        return response()->json(Maintenance::with('assets')->where('asset_id', $maintenance)->get());
     }
     
}
