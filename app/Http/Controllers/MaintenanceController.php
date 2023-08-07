<?php

namespace App\Http\Controllers;

use App\Models\Maintenance;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\MaintenanceImport;
use App\Exports\MaintenanceExport;
use App\Exports\CustomMaintenanceExport;
use PhpOffice\PhpWord\TemplateProcessor;

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

     public function show_maintenances($maintenance, $firstDate, $secondDate){
        return response()->json(Maintenance::with('assets', 'assets.items', 'assets.types')->where('asset_id', $maintenance)->whereBetween('created_at',[$firstDate, $secondDate])->get());
     }
     
     public function export_custom_maintenance(Request $request, $maintenanceCode, $firstDate, $secondDate){
        return Excel::download(new CustomMaintenanceExport($maintenanceCode, $firstDate, $secondDate), 'Custom-maintenances.xlsx');
 }

 public function export_word_report_maintenance(Request $request, $maintenanceId){
    $maintenance = Maintenance::with('assets', 'assets.transportAssets', 'assets.items', 'assets.types')->findOrFail($maintenanceId);
    $templateProcessor = new TemplateProcessor('technicalDisclosure.docx');
                // $templateProcessor->setValue('fullName', $maintenance->assets->employees->fullName);
                // $templateProcessor->setValue('positionName', $maintenance->transportAssets->positions->positionName);
                $templateProcessor->setValue('codeNamaa', $maintenance->assets->codeNamaa == null ? null : $maintenance->assets->codeNamaa);
                $templateProcessor->setValue('serialNumber', $maintenance->assets->serialNumber == null ? null : $maintenance->assets->serialNumber);
                $templateProcessor->setValue('item', $maintenance->assets->items->itemName);
                $templateProcessor->setValue('type', $maintenance->assets->types->typeName);
                $templateProcessor->setValue('technicalDisclosureNumber', $maintenance->technicalDisclosureNumber);
                $templateProcessor->setValue('reason', $maintenance->reason);
        $templateProcessor->saveAs('maintenance '.$maintenance->assets->codeNamaa.'.docx');
        return response()->download('maintenance '.$maintenance->assets->codeNamaa.'.docx');
 }

}
