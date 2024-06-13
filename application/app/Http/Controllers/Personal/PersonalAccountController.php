<?php
/*
* Workday - A time clock application for employees
* Support: official.codefactor@gmail.com
* Version: 1.6
* Author: Brian Luna
* Copyright 2020 Codefactor
*/
namespace App\Http\Controllers\personal;
use DB;
use App\Classes\Table;
use App\Classes\Permission;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;

class PersonalAccountController extends Controller
{
    public function viewUser(Request $request) 
    {
        $myuser = table::users()->where('id', \Auth::user()->id)->first();
        $myrole = table::roles()->where('id', $myuser->role_id)->value('role_name');
        
        return view('personal.personal-update-user', compact('myuser', 'myrole'));
    }

    public function viewPassword() 
    {
        return view('personal.personal-update-password');
    }

    public function updateUser(Request $request) 
    {
		$v = $request->validate([
            'name' => 'required|max:100',
            'email' => 'required|email|max:100',
		]);

        $id = \Auth::id();
        $name = mb_strtoupper($request->name);
        $email = mb_strtolower($request->email);

        if($id == null) 
        {
            return redirect('personal/update-user')->with('error', trans("Invalid request!"));
        }

        table::users()->where('id', $id)->update([
            'name' => $name,
            'email' => $email,
        ]);

        return redirect('personal/update-user')->with('success', trans("Update was successful!"));
    }

    public function updatePassword(Request $request) 
    {
        $v = $request->validate([
            'currentpassword' => 'required|max:100',
            'newpassword' => 'required|min:8|max:100',
            'confirmpassword' => 'required|min:8|max:100',
        ]);

        $id = \Auth::id();
        $p = \Auth::user()->password;
        $c_password = $request->currentpassword;
        $n_password = $request->newpassword;
        $c_p_password = $request->confirmpassword;

        if($id == null) 
        {
            return redirect('personal/update-user')->with('error', trans("Invalid request!"));
        }
        
        if($n_password != $c_p_password) 
        {
            return redirect('personal/update-password')->with('error', trans("The new passwords must match!"));
        }

        if(Hash::check($c_password, $p)) 
        {
            table::users()->where('id', $id)->update([
                'password' => Hash::make($n_password),
            ]);

            return redirect('personal/update-password')->with('success', trans("Password is successfully updated!"));
        } else {
            return redirect('personal/update-password')->with('error', trans("Wrong credentials!"));
        }
    }
}

