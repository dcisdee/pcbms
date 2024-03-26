<?php

namespace App\Http\Controllers;

use App\Http\Controllers\PurchaseDeliveryController;
use App\Http\Controllers\PurchaseItemsController;
use App\Models\PurchaseOrder;
use App\Models\PurchaseDelivery;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;


class PurchaseOrderController extends Controller
{
    public function index()
    {
        $purchase_order = PurchaseOrder::all();
        return view('admin.purchase-order', compact('purchase_order'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'purchase_order_code' => 'required|max:9',
                'supplier_id' => 'required',
                'total' => 'required',
                'del_date' => 'required'
            ]);
            // dd($request);

            $purchase_order = PurchaseOrder::create([
                'purchase_order_code' => $request->input("purchase_order_code"),
                'supplier_id' => $request->input("supplier_id"),
                'total' => $request->input("total"),
                'del_date' => $request->input("del_date"),
            ]);

            $purchaseDeliveryController = new PurchaseDeliveryController();
            $purchaseDeliveryController->store($purchase_order->id, $request);

            $purchaseItemsController = new PurchaseItemsController();
            $purchaseItemsController->store($purchase_order->id, $request);

            $logController = new LogController();
            $logController->store("Purchase Order Creation", "success", "created", $purchase_order->id);

            session()->flash('flash.banner', 'Purchase Order created successfully!');
            session()->flash('flash.bannerStyle', 'success');

        } catch (\Exception $e) { // Other unexpected errors
            $logController = new LogController();
            $logController->store("Purchase Order Creation", "failed", "created");

            session()->flash('flash.banner', 'Failed To Add Purchase Order. Error: ' . $e->getMessage());
            session()->flash('flash.bannerStyle', 'danger');
        }
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'purchase_order_code' => 'required|max:9',
                'supplier_id' => 'required',
                'del_date' => 'required',
                'purchase_status' => 'required'
            ]);

            $purchase_order = PurchaseOrder::findOrFail($id);
            $purchase_order->update($request->all());

            $purchaseDeliveryController = new PurchaseDeliveryController();
            $purchaseDeliveryController->update($request, $id);

            $logController = new LogController();
            $logController->store("Purchase Order Update", "success", "updated", $id);

            session()->flash('flash.banner', 'Purchase Order updated successfully!');
            session()->flash('flash.bannerStyle', 'success');

        } catch (ValidationException $e) { // Validation failed
            $errorMessage = 'The following errors occurred while validating the purchase order data:<br>';
            foreach ($e->validator->errors()->all() as $error) {
                $errorMessage .= "- $error<br>";
            }

            session()->flash('flash.banner', $errorMessage);
            session()->flash('flash.bannerStyle', 'danger');

        } catch (\Exception $e) { // Other unexpected errors
            $logController = new LogController();
            $logController->store("Purchase Order Update", "failed", "updated", $id);

            session()->flash('flash.banner', 'Failed To Update Purchase Order. Error: ' . $e->getMessage());
            session()->flash('flash.bannerStyle', 'danger');
        }
        return redirect()->back();
    }

    public function destroy($id)
    {
        try {
            $purchase_order = PurchaseOrder::find($id);

            $purchaseDeliveryController = new PurchaseDeliveryController();
            $purchaseDeliveryController->delete($purchase_order->id);

            $purchaseItemsController = new PurchaseItemsController();
            $purchaseItemsController->delete($purchase_order->id);

            $purchase_order->delete();

            $logController = new LogController();
            $logController->store("Purchase Order Deletion", "success", "deleted", $id);

            session()->flash('flash.banner', 'Purchase Order Deleted!');
            session()->flash('flash.bannerStyle', 'success');
        } catch (\Exception $e) { // Other unexpected errors
            $logController = new LogController();
            $logController->store("Delete Purchase Order Deletion", "failed", "deleted", $id);

            session()->flash('flash.banner', 'Failed To Delete Purchase Order.');
            session()->flash('flash.bannerStyle', 'danger');
        }
        return redirect()->back();

    }
}
