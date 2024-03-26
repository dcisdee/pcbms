<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class UserController extends Controller
{
    public function index()
    {
        $user = User::all();
        return view('admin.user', compact('user'));
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'personnel_id' => 'required',
                'email' => 'required',
                'password' => 'required',
                'is_admin' => 'required'
            ]);

            User::create($request->all());

            $message = 'User Data Added Successfully';
            $bannerStyle = 'success';

        } catch (ValidationException $e) {
            $errorMessage = 'Validation errors occurred:<br>';
            $errorMessage .= implode('<br>', $e->validator->errors()->all());
            $message = $errorMessage;
            $bannerStyle = 'danger';

        } catch (\Exception $e) {
            $message = 'Failed To Add User.';
            $bannerStyle = 'danger';
        }

        session()->flash('flash.banner', $message);
        session()->flash('flash.bannerStyle', $bannerStyle);

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'personnel_id' => 'required',
                'email' => 'required',
                'is_admin' => 'required'
            ]);

            $user = User::findOrFail($id);
            $user->update($request->all());

            $message = 'User Data Updated Successfully';
            $bannerStyle = 'success';

        } catch (ValidationException $e) {
            $errorMessage = 'Validation errors occurred:<br>';
            $errorMessage .= implode('<br>', $e->validator->errors()->all());
            $message = $errorMessage;
            $bannerStyle = 'danger';

        } catch (ModelNotFoundException $e) { // User not found
            $message = 'User Data Updated Successfully';
            $bannerStyle = 'success';
        } catch (\Exception $e) {
            $message = 'Failed To Add User.';
            $bannerStyle = 'danger';
        }

        session()->flash('flash.banner', $message);
        session()->flash('flash.bannerStyle', $bannerStyle);

        return redirect()->back();
    }

    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();

            $message = 'User deleted successfully';
            $bannerStyle = 'success';
        } catch (\Exception $e) {
            $message = 'Failed to delete User';
            $bannerStyle = 'danger';
        }

        session()->flash('flash.banner', $message);
        session()->flash('flash.bannerStyle', $bannerStyle);

        return redirect()->back();
    }
}
