<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\module;
use App\Models\module_has_formateur;
use App\Models\User;

class FormateurHasModuleController extends Controller
{
    public function displayModules(Request $request)
{
    if ($request->isMethod('post')) {
        // Handle the form submission here
        $establishment_id = session()->get('establishment_id');

        foreach ($request->module as $moduleId) {
            // Assuming you have the formateur_id in the request, adjust accordingly
            module_has_formateur::create([
                'module_id' => $moduleId,
                'formateur_id' => $request->formateur,
            ]);
        }

        // Additional logic if needed

        // Redirect or return a response
        return redirect()->back()->with('success', 'Modules assigned successfully');
    }

    // If it's a GET request, display the form
    $establishment_id = session()->get('establishment_id');
    $modules = module::all()->where('establishment_id', $establishment_id);
    $formateurs = User::where(['role'=>'formateur' , 'establishment_id'=>$establishment_id])->get();

    return view('adminDashboard.affectation.ModuleList', ['modules' => $modules, 'formateurs' => $formateurs]);
}

    public function insertMyModules(Request $request){
        return $request ;

    }
}
