<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\AssetImport;
use App\Exports\AssetExport;
use App\Exports\CustomCodeNamaaExport;
use App\Exports\CustomGPExport;

class AssetController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        return response()->json(Asset::all());
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
        // $asset = Asset::create($request->all());
        for($i=0; $i< count($request->codeNamaa); $i++){
            Asset::create([
                'item_id' => $request->item_id,
                'type_id' => $request->type_id,
                'codeNamaa' => $request->codeNamaa[$i],
                'status' => $request->status,
                'quantity' => $request->quantity,
                'realPrice' => $request->realPrice,
                'expectedPrice' => $request->expectedPrice,
                'serialNumber' => $request->serialNumber[$i],
                'aquisitionDate' => $request->aquisitionDate,
                'aquisitionType' => $request->aquisitionType,
                'fundedBy' => $request->fundedBy,
		'partnerName' => $request->partnerName,
                'documentNumber' => $request->documentNumber,
                'notes' => $request->notes,
                'inService' => $request->inService,
                'description' => $request->description,
            ]);
        }
        return response()->json();
    }

    /**
     * Display the specified resource.
     */
    public function show($asset)
    {
        //
        return response()->json(Asset::with('types', 'items')->where('id', $asset)->get());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Asset $asset)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //
        Asset::where('id', '=', $id)->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($asset)
    {
        //
        Asset::where('id', $asset)->delete();
    }

    public function getCodeAsset(Request $request)
    {
        //

        return response()->json(Asset::where('codeNamaa', 'like', $request->codeNamaa.'%')->limit(5)->get());
    }

    public function getCodeSerial(Request $request)
    {
        //
        return response()->json(Asset::where('serialNumber', 'like', $request->serialNumber.'%')->limit(5)->get());
    }

    public function import_assets(Request $request){

        $this->validate($request, [
            'file'  => 'required|mimes:xls,xlsx'
           ]);


        Excel::import(new AssetImport, $request->file('file')->getRealPath());
    }

    public function export_assets(Request $request){
        // return response()->json(Asset::all());
            return Excel::download(new AssetExport, 'Assets.xlsx');
        //  return (new export_employees)->download('Employees.xlsx');
     }

     public function export_custom_code_namaa(Request $request, $firstDate, $secondDate){
        // return response()->json(Asset::all());
        // dd($firstDate, $secondDate);
            return Excel::download(new CustomCodeNamaaExport($firstDate, $secondDate), 'Custom-Code-Namaa.xlsx');
        //  return (new export_employees)->download('Employees.xlsx');
     }

     public function export_custom_GP(Request $request, $firstDate, $secondDate){
            return Excel::download(new CustomGPExport($firstDate, $secondDate), 'Custom-GP-Report.xlsx');
     }


}
