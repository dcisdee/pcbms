<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class ItemController extends Controller
{
    public function index()
    {
        $item = Item::all();
        return view('admin.item', compact('item'));
    }

    public function store(Request $request)
    {
        try{
            $request->validate([
                'barcode' => 'required|max:9|min:8',
                'product_name' => 'required',
                'category' => 'required',
                'expiration' => 'required',
                'qty' => 'required|max:12',
                'purchase_unit_price' => 'required|numeric',
                'selling_unit_price' => 'required|numeric'
            ]);

            $item = Item::create($request->all());

            $logController = new LogController();
            $logController->store("Item Creation", "success", "created", $item->id);

            session()->flash('flash.banner', 'Item Data Added Successfully');
            session()->flash('flash.bannerStyle', 'success');

        } catch (ValidationException $e) { // Validation failed
            $errorMessage = 'The following errors occurred while validating the item data:<br>';
            foreach ($e->validator->errors()->all() as $error) {
                $errorMessage .= "- $error<br>";
            }

            session()->flash('flash.banner', $errorMessage);
            session()->flash('flash.bannerStyle', 'danger');

        } catch (\Exception $e) { // Other unexpected errors
            $logController = new LogController();
            $logController->store("Item Creation", "failed", "created");

            session()->flash('flash.banner', 'Failed To Add Item.');
            session()->flash('flash.bannerStyle', 'danger');
        }
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'barcode' => 'required|max:9|min:8',
                'product_name' => 'required',
                'category' => 'required',
                'expiration' => 'required',
                'qty' => 'required|max:12',
                'purchase_unit_price' => 'required|numeric',
                'selling_unit_price' => 'required|numeric'
            ]);

            $item = Item::findOrFail($id);
            $item->update($request->all());

            $logController = new LogController();
            $logController->store("Item Update", "success", "update", $id);

            session()->flash('flash.banner', 'Item Data Updated Successfully');
            session()->flash('flash.bannerStyle', 'success');

        } catch (ValidationException $e) { // Validation failed
            $errorMessage = 'The following errors occurred while validating the item data:<br>';
            foreach ($e->validator->errors()->all() as $error) {
                $errorMessage .= "- $error<br>";
            }

            session()->flash('flash.banner', $errorMessage);
            session()->flash('flash.bannerStyle', 'danger');

        } catch (\Exception $e) { // Other unexpected errors
            $logController = new LogController();
            $logController->store("Item Update", "failed", "update", $id);

            session()->flash('flash.banner', 'Failed To Updated Item.');
            session()->flash('flash.bannerStyle', 'danger');
        }
        return redirect()->back();
    }

    public function destroy($id)
    {
        try {
            $item = Item::find($id);
            $item->delete();

            $logController = new LogController();
            $logController->store("Item Deletion", "success", "delete", $id);

            session()->flash('flash.banner', 'Item Data Deleted Successfully');
            session()->flash('flash.bannerStyle', 'success');

        } catch (\Exception $e) { // Other unexpected errors
            $logController = new LogController();
            $logController->store("Item Deletion", "failed", "delete", $id);

            session()->flash('flash.banner', 'Failed To Delete Personnel.');
            session()->flash('flash.bannerStyle', 'danger');
        }
        return redirect()->back();
    }
}
