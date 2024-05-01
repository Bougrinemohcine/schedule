<?php

namespace App\Http\Controllers;
use App\Models\formateur_has_group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ShowGroupAffected extends Controller
{
    //
    function Show (){
        $user_id = Auth::id(); // Retrieve the logged-in formateur's ID
        $GroupsList = formateur_has_group::where('formateur_id', $user_id)->get();
        return view('formateurDashboard.FormateurGroupe.FormateurGroupeList',['GroupsList'=> $GroupsList]);
    }
}
