<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    protected $modules = ['dashboard'];
    public function index(Request $request)
    {

        return match ($request->user()->roles->first()->name) {
            'administrator' => view('admin.index'),
            default => view('dashboard'),
        };
    }
}
