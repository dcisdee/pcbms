<?php

namespace App\Http\Controllers;

use App\Models\PurchaseItems;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PurchaseItemsController extends Controller
{
    public function index()
    {
        $purchase_items = PurchaseItems::all();
        return view('admin.purchase_items', compact('purchase_items'));
    }

    public function store($purchase_order_id, Request $request)
    {
        for ($i = 1; $i <= $request->items_num; $i++) {
            PurchaseItems::create([
                'purchase_order_id' => $purchase_order_id,
                'barcode' => $request->input("item_barcode_$i"),
                'product_name' => $request->input("item_product_name_$i"),
                'qty' => $request->input("item_qty_$i"),
                'price' => $request->input("item_prices_$i"),
                'total' => $request->input("item_total_$i"),
            ]);
        }
    }

    public function destroy($id)
    {
        $purchase_items = PurchaseItems::find($id);
        $purchase_items->delete();
    }
}
