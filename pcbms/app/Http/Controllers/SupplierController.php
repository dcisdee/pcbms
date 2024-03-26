<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class SupplierController extends Controller
{
    public function index()
    {
        $supplier = Supplier::all();
        return view('admin.supplier', compact('supplier'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'company' => 'required',
                'phone' => 'required|max:12|min:11',
                'address' => 'required'
            ]);

            $supplier = Supplier::create($request->all());

            $message = 'Supplier Data Added Successfully';
            $bannerStyle = 'success';

            $logController = new LogController();
            $logController->store("Supplier Creation", "success", "created", $supplier->id);

        } catch (ValidationException $e) {
            $errorMessage = 'Validation errors occurred:<br>';
            $errorMessage .= implode('<br>', $e->validator->errors()->all());
            $message = $errorMessage;
            $bannerStyle = 'danger';

        } catch (\Exception $e) {
            $message = 'Failed To Add Supplier.';
            $bannerStyle = 'danger';

            $logController = new LogController();
            $logController->store("Supplier Creation", "failed", "created");
        }

        session()->flash('flash.banner', $message);
        session()->flash('flash.bannerStyle', $bannerStyle);

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'company' => 'required',
                'phone' => 'required|max:12|min:11',
                'address' => 'required'
            ]);

            $supplier = Supplier::findOrFail($id);
            $supplier->update($request->all());

            $message = 'Supplier Data Updated Successfully';
            $bannerStyle = 'success';

            $logController = new LogController();
            $logController->store("Supplier Update", "success", "update", $id);

        } catch (ValidationException $e) {
            $errorMessage = 'Validation errors occurred:<br>';
            $errorMessage .= implode('<br>', $e->validator->errors()->all());
            $message = $errorMessage;
            $bannerStyle = 'danger';

        } catch (\Exception $e) {
            $message = 'Failed To Add Supplier.';
            $bannerStyle = 'danger';

            $logController = new LogController();
            $logController->store("Supplier Update", "failed", "update", $id);
        }

        session()->flash('flash.banner', $message);
        session()->flash('flash.bannerStyle', $bannerStyle);

        return redirect()->back();
    }

    public function destroy($id)
    {
        try {
            $supplier = Supplier::findOrFail($id);
            $supplier->delete();

            $message = 'Supplier deleted successfully';
            $bannerStyle = 'success';

            $logController = new LogController();
            $logController->store("Supplier Deletion", "success", "delete", $id);
        } catch (\Exception $e) {
            $message = 'Failed to delete Supplier: Supplier is being used in Purchase Order';
            $bannerStyle = 'danger';

            $logController = new LogController();
            $logController->store("Supplier Deletion", "failed", "delete", $id);
        }

        session()->flash('flash.banner', $message);
        session()->flash('flash.bannerStyle', $bannerStyle);

        return redirect()->back();
    }
}
