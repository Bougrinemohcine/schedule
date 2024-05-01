<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ScheduleChaqueGroup extends Controller
{
    function index(){
        return view('adminDashboard.Main.PourchaqueGroup');
    }
}
