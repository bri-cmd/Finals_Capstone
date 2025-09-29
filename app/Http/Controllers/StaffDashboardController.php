<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class StaffDashboardController extends Controller
{
    public function index()
    {
        // You can make a simple staff view, or load staff data here
        return view('staff.dashboard');
    }
}
    