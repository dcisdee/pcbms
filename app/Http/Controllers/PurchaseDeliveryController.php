<?php

namespace App\Http\Controllers;

use App\Models\PurchaseDelivery;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PurchaseDeliveryController extends Controller
{
    public function index()
    {
        $purchase_delivery = PurchaseDelivery::all();
        return view('admin.purchase_delivery', compact('purchase_delivery'));
    }

    public function store($purchase_order_id, Request $request)
    {
        try {
            $request->validate([
                'purchase_status' => 'required'
            ]);

            PurchaseDelivery::create([
                'purchase_order_id' => $purchase_order_id,
                'purchase_status' => $request->input('purchase_status'),
            ]);

        } catch (\Exception $e) { // Other unexpected errors
            session()->flash('flash.banner', 'Failed To Create Purchase Order Delivery. Error: ' . $e->getMessage());
            session()->flash('flash.bannerStyle', 'danger');
        }
    }


    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'purchase_status' => 'required'
            ]);

            $purchase_delivery = PurchaseDelivery::where('purchase_order_id', $id)->firstOrFail();
            $purchase_delivery->update($request->all());

        } catch (\Exception $e) { // Other unexpected errors
            session()->flash('flash.banner', 'Failed To Update Purchase Order Delivery. Error: ' . $e->getMessage());
            session()->flash('flash.bannerStyle', 'danger');
        }
    }

    public function destroy($id)
    {
        $purchase_delivery = PurchaseDelivery::find($id);
        $purchase_delivery->delete();
    }
}
