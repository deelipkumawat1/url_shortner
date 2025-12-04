<?php

namespace App\Http\Controllers\SAdmin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        return view('sadmin.dashboard');
    }
}
