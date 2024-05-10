<?php

namespace App\Http\Controllers;
use App\Models\module_has_formateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShowModuleAffected extends Controller
{
    //
    function Show (){
        $user_id = Auth::id(); // Retrieve the logged-in formateur's ID
        $modulesList = module_has_formateur::where('formateur_id', $user_id)->get();

        return view('formateurDashboard.FormateurModule.FormateurModuleList', ['modulesList' => $modulesList]);
    }
   
}
