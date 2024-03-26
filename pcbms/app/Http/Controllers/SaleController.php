<?php

namespace App\Http\Controllers;

use App\Models\Sale;
// use App\Models\SaleItems;
// use App\Http\Controllers\ItemController;
use App\Http\Controllers\SaleItemsController;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SaleController extends Controller
{
    public function index()
    {
        $sale = Sale::all();
        return view('admin.sale', compact('sale'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'grand_total' => 'required',
                'cash' => 'required|gt:0',
                'change' => 'required|gt:0',
                'transaction_status' => 'required'
            ]);

            $sale = Sale::create([
                'total' => $request->input("grand_total"),
                'cash' => $request->input("cash"),
                'change' => $request->input("change"),
                'transaction_status' => $request->input("transaction_status"),
            ]);

            $saleItemsController = new SaleItemsController();
            $saleItemsController->store($sale->id, $request);

            $logController = new LogController();
            $logController->store("Sale Transaction Creation", "success", "created", $sale->id);

            session()->flash('flash.banner', 'Sale Transaction created successfully!');
            session()->flash('flash.bannerStyle', 'success');

        } catch (ValidationException $e) { // Validation failed
            $errorMessage = 'The following errors occurred while validating the sale transaction data:<br>';
            foreach ($e->validator->errors()->all() as $error) {
                $errorMessage .= "- $error<br>";
            }

            session()->flash('flash.banner', $errorMessage);
            session()->flash('flash.bannerStyle', 'danger');

        } catch (\Exception $e) { // Other unexpected errors
            $logController = new LogController();
            $logController->store("Sale Transaction Creation", "failed", "created");

            session()->flash('flash.banner', 'Failed To Add Sale Transaction Error: ' . $e->getMessage());
            session()->flash('flash.bannerStyle', 'danger');
        }
        return redirect()->back();
    }

    public function destroy($id)
    {
        try {
            $sale = Sale::find($id);
            $sale->delete();

            $logController = new LogController();
            $logController->store("Sale Transaction Deletion", "success", "delete", $id);

            session()->flash('flash.banner', 'Sale Transaction Data Deleted Successfully');
            session()->flash('flash.bannerStyle', 'success');

        } catch (\Exception $e) { // Other unexpected errors
            $logController = new LogController();
            $logController->store("Sale Transaction Deletion", "failed", "delete", $id);

            session()->flash('flash.banner', 'Failed To Delete Sale Transaction.');
            session()->flash('flash.bannerStyle', 'danger');
        }
        return redirect()->back();
    }
}
