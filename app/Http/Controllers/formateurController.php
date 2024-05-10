<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\formateur;
use App\Models\branch;
use App\Models\group;
use App\Models\module;
use App\Models\formateur_has_group;
use App\Models\module_has_formateur;
use App\Models\group_has_module;
use App\Models\formateur_has_branche;
use App\Models\RequestEmploi;
use Illuminate\Support\Facades\Auth;

class formateurController extends Controller
{

    public function index()
    {
        return view('adminDashboard.addFormateur.add_formateur');
    }


    public function showHomepage(){
        $id_formateur = session()->get('user_id');
        //Assuming the model name is 'Formateur' and you're looking for a single record.
        $formateur = formateur::select('user_name')->where('id', $id_formateur)->first();
         
 
        return view('formateurDashboard.Home.formateur',['formateur'=>$formateur]);
        //return $formateur->user_name ;
    }

    public function show_update_page($id)
    {
        return view('adminDashboard.addFormateur.update_formateur');
    }
    


    // return data  to module edit
    public function reserved($id ){
           $establishment_id = session()->get('establishment_id');
            $branches = Branch::select('branches.*')
            ->join('formateur_has_filier as FHF', 'FHF.barnch_id', '=', 'branches.id')
            ->where('FHF.formateur_id', $id)
            ->where('establishment_id', $establishment_id)
            ->get();

            $modules = module::select('modules.*')
            ->join('module_has_formateur as FHM', 'FHM.module_id', '=', 'modules.id')
            ->where('FHM.formateur_id', $id)
            ->where('establishment_id', $establishment_id)
            ->get();

            $groupes = group::select('groups.*')
            ->join('formateur_has_groups as FHG', 'FHG.group_id', '=', 'groups.id')
            ->where('FHG.formateur_id', $id)
            ->where('establishment_id', $establishment_id)
            ->get();

            $formateur = Formateur::find($id);
            if($formateur ||  $groupes || $modules || $branches)
            {
                return response()->json(['branches'=>$branches , 'status'=> 200 , 'formateur'=>$formateur , 'modules' => $modules , 'Groupes'=>$groupes ] ) ;

            }
            else{
                return response()->json(['error' => 'Il y a quelque chose qui ne va pas.' , 'status '=>400]);
            }
    }

   



}
