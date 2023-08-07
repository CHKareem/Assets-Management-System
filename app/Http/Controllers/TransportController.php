<?php

namespace App\Http\Controllers;

use App\Models\Transport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TransportImport;
use App\Exports\TransportExport;
use App\Exports\CustomTransportExport;
use PhpOffice\PhpWord\TemplateProcessor;

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

     public function show_transports($transport, $transportType, $firesDate, $secondDate){
        // if($transportType == null){
        //     return response()->json(Transport::with('assets', 'employees', 'positions', 'prevs', 'centers', 'departments', 'assets.items', 'assets.types')->where('asset_id', $transport)->orWhere('employee_id', $transport)->whereBetween('transportDate',[$firesDate, $secondDate])->get());
        // }if($firesDate == null && $secondDate == null){
        //     return response()->json(Transport::with('assets', 'employees', 'positions', 'prevs', 'centers', 'departments', 'assets.items', 'assets.types')->where('asset_id', $transport)->orWhere('employee_id', $transport)->where('documentType', $transportType)->get());
        // }if($firesDate == null && $secondDate == null && $transportType == null){
        //     return response()->json(Transport::with('assets', 'employees', 'positions', 'prevs', 'centers', 'departments', 'assets.items', 'assets.types')->where('asset_id', $transport)->orWhere('employee_id', $transport)->get());
        // }else{
        return response()->json(Transport::with('assets', 'employees', 'positions', 'prevs', 'centers', 'departments', 'assets.items', 'assets.types')->where('asset_id', $transport)->orWhere('employee_id', $transport)->where('documentType', $transportType)->whereBetween('transportDate',[$firesDate, $secondDate])->get());
        // }
     }

     public function export_custom_transport(Request $request, $transportCode, $transportType, $firstDate, $secondDate){
            return Excel::download(new CustomTransportExport($transportCode, $transportType, $firstDate, $secondDate), 'Custom-tranports.xlsx');
     }


     public function export_word_report_transport(Request $request, $transportCode, $transportType, $firstDate, $secondDate){
        $transports = Transport::with('assets', 'employees', 'positions', 'prevs', 'centers', 'departments', 'assets.items', 'assets.types')->where('employee_id', $transportCode)->where('documentType', $transportType)->whereBetween('transportDate',[$firstDate, $secondDate])->get();
        if($transportType == 'ggo'){
            $templateProcessor = new TemplateProcessor('transportToEmployee.docx');
        }else{
            $templateProcessor = new TemplateProcessor('transportFromEmployee.docx');
        }
        foreach($transports as $index => $transport){
            // dd($transport, 'codenamaa'.$index, count($transports));
            // $index = 5;
            $indexIteration;
            if($index < count($transports)){
                $templateProcessor->setValue('fullName', $transport->employees->fullName);
                $templateProcessor->setValue('positionName', $transport->positions->positionName);
                $templateProcessor->setValue('centerName', $transport->centers->centerName);
                $templateProcessor->setValue('codeNamaa'.$index, $transport->assets->codeNamaa);
                $templateProcessor->setValue('serialNumber'.$index, $transport->assets->serialNumber);
                $templateProcessor->setValue('transportDate', $transport->transportDate);
                $templateProcessor->setValue('documentNumber', $transport->documentNumber);
                $templateProcessor->setValue('item'.$index, $transport->assets->items->itemName);
                $templateProcessor->setValue('type'.$index, $transport->assets->types->typeName);
                $templateProcessor->setValue('status'.$index, 'جيد');
                $indexIteration = $index + 1;
            }
            if($indexIteration >= count($transports)){
                // $dd = 10 - count($transports);
                // dd($dd);
                for($i = $indexIteration ; $i <= 10; $i++){
                    // dd($i);
                    $templateProcessor->setValue('codeNamaa'.$i, null);
                    $templateProcessor->setValue('serialNumber'.$i, null);
                    $templateProcessor->setValue('item'.$i, null);
                    $templateProcessor->setValue('type'.$i, null);
                    $templateProcessor->setValue('status'.$i, null);
                }
                // dd($dd);
            }
            // $templateProcessor->setValue('name', $transport->employees->fullName);
            // $templateProcessor->setValue('position', $transport->positions->positionName);
            // $templateProcessor->setValue('codenamaa'.$index, $transport->assets->codeNamaa);
            // $templateProcessor->setValue('codenamaa'.$index, $index > count($transports) ? null : $transport->assets->codeNamaa);
        }
        // dd($indexIteration);
        $templateProcessor->saveAs('transport '.$transport->employees->fullName.'.docx');
        return response()->download('transport '.$transport->employees->fullName.'.docx');

 }

        public function getTransportType(Request $request){
            return response()->json(Transport::where('documentType', 'like', $request->documentType.'%')->limit(5)->get());
        }

}
