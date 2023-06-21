<?php

namespace App\Http\Controllers;

use App\Models\Transport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TransportImport;
use App\Exports\TransportExport;
use App\Exports\CustomTransportExport;

class TransportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return response()->json(Transport::with('assets', 'employees', 'positions', 'prevs')->get());
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
        // $transport = Transport::create($request->all());
        // return response()->json($transport);
// dd($request->transports);
        foreach($request->transports as $transport){
            Transport::create([
                'center_id' => $request->center_id,
                'department_id' => $request->department_id,
                'position_id' => $request->position_id,
                'employee_id' => $request->employee_id,
                'employee_prev_id' => $request->employee_prev_id,
                'asset_id' => $transport['asset_id'],
                'transportDate' => $transport['transport_date'],
                'documentNumber' => $transport['document_number'],
                'documentType' => $transport['document_type'],
                'isHanded' => $transport['is_handed'],
            ]);
        }
        return response()->json();

    }

    /**
     * Display the specified resource.
     */
    public function show($transport)
    {
        //
        return response()->json(Transport::with('assets', 'employees', 'positions', 'prevs', 'centers', 'departments')->where('id', $transport)->get());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transport $transport)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        // Transport::where('id', '=', $id)->update($request->all());

        foreach($request->transports as $transport){
            Transport::where('id', '=', $id)->update([
            'center_id' => $request->center_id,
            'department_id' => $request->department_id,
            'position_id' => $request->position_id,
            'employee_id' => $request->employee_id,
            'employee_prev_id' => $request->employee_prev_id,
            'asset_id' => $transport['asset_id'],
            'transportDate' => $transport['transport_date'],
            'documentNumber' => $transport['document_number'],
            'documentType' => $transport['document_type'],
            'isHanded' => $transport['is_handed'],
            ]);
           }
           
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($transport)
    {
        //
        Transport::where('id', $transport)->delete();
    }

    public function import_transports(Request $request){

        $this->validate($request, [
            'file'  => 'required|mimes:xls,xlsx'
           ]);


        Excel::import(new TransportImport, $request->file('file')->getRealPath());
    }

    public function export_transports(Request $request){
            return Excel::download(new TransportExport, 'Transports.xlsx');
     }

     public function show_transports($transport){
        return response()->json(Transport::with('assets', 'employees', 'positions', 'prevs', 'centers', 'departments', 'assets.items', 'assets.types')->where('asset_id', $transport)->orWhere('employee_id', $transport)->get());
     }

     public function export_custom_transport(Request $request, $transportCode){
            return Excel::download(new CustomTransportExport($transportCode), 'Custom-tranports.xlsx');
     }

}
