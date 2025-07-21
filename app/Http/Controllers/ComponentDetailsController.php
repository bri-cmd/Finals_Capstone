<?php

namespace App\Http\Controllers;

use App\Models\Hardware\Motherboard;
use Illuminate\Http\Request;

class ComponentDetailsController extends Controller
{
    public function index() {
        $mobos = Motherboard::all();
        
        return view('staff.componentdetails', compact('mobos'));
    }
}
