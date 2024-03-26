<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\SaleItems;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class SaleItemsController extends Controller
{
    public function index()
    {
        $sale_items = SaleItems::all();
        // return view('admin.sale_items', compact('sale_items'));
    }

    public function store($sale_id, Request $request)
    {
        $validationRules = [
            'items_num' => 'required',
        ];


        $request->validate($validationRules);

        for ($i = 1; $i <= $request->items_num; $i++) {
            SaleItems::create([
                'item_id' => $request->input("item_id_$i"),
                'sale_id' => $sale_id,
                'quantity' => $request->input("item_qty_$i"),
                'price' => $request->input("item_price_$i"),
                'total' => $request->input("item_total_price_$i"),
            ]);

            $item = Item::findOrFail($request->input("item_id_$i"));
            $qty_update = $item->qty - $request->input("item_qty_$i");
            $item->update(['qty' => $qty_update]);
        }
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'item_id' => 'required',
            'sale_id' => 'required',
            'quantity' => 'required',
            'price' => 'required',
            'total' => 'required'
        ]);

        $sale_items = SaleItems::findOrFail($id);
        $sale_items->update($request->all());
        return redirect()->route('sale_items')
        ->with('success', 'SaleItems updated successfully.');
    }

    public function destroy($id)
    {
        $sale_items = SaleItems::find($id);
        $sale_items->delete();
        return redirect()->route('sale_items')
        ->with('success', 'SaleItems deleted successfully');
    }
}
