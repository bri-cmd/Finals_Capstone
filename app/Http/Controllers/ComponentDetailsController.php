<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ComponentDetailsController extends Controller
{
    public function index() {
        return view('staff.componentdetails');
    }
}
