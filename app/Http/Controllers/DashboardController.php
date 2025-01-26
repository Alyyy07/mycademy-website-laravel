<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $modules = ['dashboard'];
    public function index(Request $request)
    {

        return view('admin.index');
    }
}
