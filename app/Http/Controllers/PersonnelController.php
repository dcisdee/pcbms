<?php

namespace App\Http\Controllers;

use App\Models\Personnel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class PersonnelController extends Controller
{
    public function index()
    {
        $personnel = Personnel::all();
        return view('admin.personnel', compact('personnel'));
    }

    public function store(Request $request)
    {
        try {
            // dd($request);
            $request->validate([
                'first_name' => 'required',
                'mid_initial' => 'required',
                'last_name' => 'required',
                'sex' => 'required',
                'email' => 'required',
                'phone' => 'required|max:12',
                'address' => 'required',
                'is_admin' => 'required'
            ]);

            $personnel = Personnel::create($request->all());

            $logController = new LogController();
            $logController->store("Personnel Creation", "success", "created", $personnel->id);

            session()->flash('flash.banner', 'Personnel Data Added Successfully');
            session()->flash('flash.bannerStyle', 'success');

        } catch (ValidationException $e) { // Validation failed
            $errorMessage = 'The following errors occurred while validating the personnel data:<br>';
            foreach ($e->validator->errors()->all() as $error) {
                $errorMessage .= "- $error<br>";
            }

            session()->flash('flash.banner', $errorMessage);
            session()->flash('flash.bannerStyle', 'danger');

        } catch (\Exception $e) { // Other unexpected errors
            $logController = new LogController();
            $logController->store("Personnel Creation", "failed", "created");

            session()->flash('flash.banner', 'Failed To Add Personnel.');
            session()->flash('flash.bannerStyle', 'danger');
        }
        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        // dd($request);
        try {
            $request->validate([
                'first_name' => 'required',
                'mid_initial' => 'required',
                'last_name' => 'required',
                'sex' => 'required',
                'email' => 'required',
                'phone' => 'required|max:12',
                'address' => 'required',
                'is_admin' => 'required'
            ]);

            $personnel = Personnel::findOrFail($id);
            $personnel->update($request->all());

            $logController = new LogController();
            $logController->store("Personnel Update", "success", "updated", $id);

            session()->flash('flash.banner', 'Personnel Data Updated Successfully');
            session()->flash('flash.bannerStyle', 'success');

        } catch (ValidationException $e) { // Validation failed
            $errorMessage = 'The following errors occurred while validating the personnel data:<br>';
            foreach ($e->validator->errors()->all() as $error) {
                $errorMessage .= "- $error<br>";
            }

            session()->flash('flash.banner', $errorMessage);
            session()->flash('flash.bannerStyle', 'danger');

        } catch (ModelNotFoundException $e) { // Personnel not found
            $logController = new LogController();
            $logController->store("Personnel Update", "failed", "updated", $id);

            session()->flash('flash.banner', 'Personnel Not Found.');
            session()->flash('flash.bannerStyle', 'danger');
        }
        return redirect()->back();
    }

    public function destroy($id)
    {
        try {
            $personnel = Personnel::find($id);

            if($personnel->user)
            {
                $personnel->user->delete();
                $personnel->delete();
            }

            $logController = new LogController();
            $logController->store("Personnel Deletion", "success", "deleted", $id);

            session()->flash('flash.banner', 'Personnel Data Deleted Successfully');
            session()->flash('flash.bannerStyle', 'success');

        } catch (\Exception $e) { // Other unexpected errors
            $logController = new LogController();
            $logController->store("Personnel Deletion", "failed", "deleted", $id);

            session()->flash('flash.banner', 'Failed To Delete Personnel.' . $e);
            session()->flash('flash.bannerStyle', 'danger');
        }
        return redirect()->back();

    }
    public function show($id)
    {
        $personnel = Personnel::findOrFail($id);
        return redirect()->back();
    }
}
