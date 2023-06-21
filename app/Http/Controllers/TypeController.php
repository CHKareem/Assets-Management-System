<?php

namespace App\Http\Controllers;

use App\Models\Type;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\TypeImport;
use App\Exports\TypeExport;

class TypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        return response()->json(Type::all());
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

        $type = Type::create($request->all());
        return response()->json($type);
    }

    /**
     * Display the specified resource.
     */
    public function show($type)
    {
        //

        return response()->json(Type::where('id', $type)->get());
    }

    public function getType(Request $request)
    {
        //

        return response()->json(Type::where('typeName', 'like', $request->typeName.'%')->limit(5)->get());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Type $type)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //

        Type::where('id', '=', $id)->update(['typeName' => $request->typeName, 'arabicTypeName' => $request->arabicTypeName]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($type)
    {
        //

        Type::where('id', $type)->delete();
    }

    public function import_types(Request $request){

        $this->validate($request, [
            'file'  => 'required|mimes:xls,xlsx'
           ]);


        Excel::import(new TypeImport, $request->file('file')->getRealPath());
    }

    public function export_types(Request $request){
            return Excel::download(new TypeExport, 'Types.xlsx');
     }

}
