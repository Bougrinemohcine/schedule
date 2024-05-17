<?php

namespace App\Http\Controllers;
use App\Models\formateur_has_group;
use App\Models\module_has_formateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShowgroupAffected extends Controller
{
    //
    function Show (){
        $user_id = Auth::id(); // Retrieve the logged-in formateur's ID
        $groupsList = formateur_has_group::where('formateur_id', $user_id)->get();
        return view('formateurDashboard.FormateurGroupe.formateurGroupeList',['groupsList'=> $groupsList]);
    }
    function ShowInHomegroupAndModuleAffected (){
        $user_id = Auth::id(); // Retrieve the logged-in formateur's ID
        $groupsList = formateur_has_group::where('formateur_id', $user_id)->get();
        $modulesList = module_has_formateur::where('formateur_id', $user_id)->get();
        return view('formateurDashboard.Home.formateur',['groupsList'=> $groupsList,'modulesList' => $modulesList]);
    }
}
