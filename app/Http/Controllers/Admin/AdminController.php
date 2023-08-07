<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function login()
    {
        return view('admin.auth.login');
    }

    public function forgotPassword()
    {
        return view('admin.auth.forgot-password');
    }

    public function logout(Request $request) 
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect()->route('admin.login');
    }

    public function profile()
    {
        $adminData = User::find(Auth::user()->id);
        return view('admin.auth.profile', compact('adminData'));
    }

    public function profileUpdate(Request $request)
    {
        $id = Auth::user()->id;
        $data = User::find($id);
        $data->name = $request->name;
        $data->email = $request->email;
        $data->phone = $request->phone;
        $data->address = $request->address; 


        if ($request->file('photo')) {
            $file = $request->file('photo');
            @unlink(public_path('uploads/admin/'.$data->photo));
            $filename = date('YmdHi').'_'.$file->getClientOriginalName();
            $file->move(public_path('uploads/admin'),$filename);
            $data['photo'] = $filename;
        }

        $data->save();

        return redirect()->back()->with('success', 'Profile info updated successfully.');
    }

    public function changePassword()
    {
        return view('admin.auth.change-password');
    }

    public function updatePassword(Request $request)
    {
        //Validation check
        $request->validate([
            'old_password' => 'required',
            'password' => 'required|confirmed'
        ]);

        //Old password match
        if(!Hash::check($request->old_password, Auth::user()->password)) {
            return redirect()->back()->with('error', 'Old password does not match!');
        }

        //update password
        User::whereId(Auth::user()->id)->update([
            'password' => Hash::make($request->password)
        ]);

        return back()->with('success', 'Password changed successfully.');
    }


}
