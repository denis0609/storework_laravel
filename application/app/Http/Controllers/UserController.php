<?php
/*
* Workday - A time clock application for employees
* Support: official.codefactor@gmail.com
* Version: 1.6
* Author: Brian Luna
* Copyright 2020 Codefactor
*/
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    public function AuthRouteAPI(Request $request) 
    {
        return $request->user();
    }
}
