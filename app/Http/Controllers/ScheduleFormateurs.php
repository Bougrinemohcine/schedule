<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ScheduleFormateurs extends Controller
{
    function index(){
        return view('adminDashboard.Main.emploiForToutFormateur');
    }
}
