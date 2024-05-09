<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\group;
use App\Models\branch;
use App\Models\module;
use App\models\group_has_module;
use Illuminate\Support\Facades\DB;

class groupController extends Controller
{
     //show all groups
    public function index(){

        return view('adminDashboard.addGroups.add_groups') ;
    }










    //display page setting
    public function settingView(){
        return view('adminDashboard.setting.setting');
    }

}
