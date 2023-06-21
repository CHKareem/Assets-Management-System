<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ItemImport;
use App\Exports\ItemExport;

class ItemController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

        return response()->json(Item::all());
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

        $item = Item::create($request->all());
        return response()->json($item);
    }

    /**
     * Display the specified resource.
     */
    public function show($item)
    {
        //

        return response()->json(Item::where('id', $item)->get());
    }

    public function getItem(Request $request)
    {
        //

        return response()->json(Item::where('itemName', 'like', $request->itemName.'%')->limit(5)->get());
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Item $item)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        //

        Item::where('id', '=', $id)->update(['itemName' => $request->itemName, 'arabicItemName' => $request->arabicItemName]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($item)
    {
        //

        Item::where('id', $item)->delete();
    }

    public function import_items(Request $request){

        $this->validate($request, [
            'file'  => 'required|mimes:xls,xlsx'
           ]);


        Excel::import(new ItemImport, $request->file('file')->getRealPath());
    }

    public function export_items(Request $request){
            return Excel::download(new ItemExport, 'Items.xlsx');
     }
}
