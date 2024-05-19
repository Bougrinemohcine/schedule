<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// Models
use App\Models\formateur;
use App\Models\establishment;
use App\Models\group;
use App\Models\module;
use Illuminate\Support\Facades\DB;
use App\Models\class_room;
use App\Models\class_room_type;
use App\Models\class_has_type;
use App\Models\user;
use App\Models\main_emploi;
use App\Models\formateur_has_group;
use App\Models\module_has_formateur;
use App\Models\group_has_module;
use App\Models\branch;
use App\Models\formateur_has_branche;
use Illuminate\Support\Facades\Notification;
use App\Notifications\RequestEmploiNotification;

use Illuminate\Support\Facades\Auth;

class FileExcel extends Controller
{
    public function index(){
        return view('adminDashboard.Excel.Uploed');
    }
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx',
        ]);

        // Store the uploaded file
        $filePath = $request->file('file')->storeAs('excel', $request->file('file')->getClientOriginalName());

        // Load the Excel file
        $reader = new \PhpOffice\PhpSpreadsheet\Reader\Xlsx();
        $spreadsheet = $reader->load(storage_path('app/' . $filePath));
        $worksheet = $spreadsheet->getActiveSheet();
        $highestRow = $worksheet->getHighestRow();

      $FormateursInfo = [];
      $ModulesInfo = [];
      $GroupsInfo = [];
      $BranchesInfo = [];

        for ($row = 1; $row <= $highestRow; $row++) {
            $Formateur   = $worksheet->getCell('U' . $row)->getValue();
            $Matricule   = $worksheet->getCell('T' . $row)->getValue();
            $Groupe      = $worksheet->getCell('I' . $row)->getValue();
            $Branches    = $worksheet->getCell('E' . $row)->getValue();
            $Modules     = $worksheet->getCell('Q' . $row)->getValue();
            $neveau      = $worksheet->getCell('O' . $row)->getValue();
            $codeModules = $worksheet->getCell('R' . $row)->getValue();
            $brancheName = $worksheet->getCell('F' . $row)->getValue();

            if ($Formateur !== '' && $Matricule !== '' && $Groupe !== '' &&
            $Branches !== '' && $Modules !== "") {
                // Check if the formateur already exists in FormateursInfo
                $foundFormateurIndex = null;
                foreach ($FormateursInfo as $index => $formateurInfo) {
                    if ($formateurInfo['matricule'] === $Matricule) {
                        $foundFormateurIndex = $index;
                        break;
                    }
                }

                // If formateur doesn't exist, add a new entry
                if ($foundFormateurIndex === null) {
                    $FormateursInfo[] = [
                        'name' => $Formateur,
                        'matricule' => $Matricule,
                        'groupes' => [$Groupe],
                        'branches' => [$Branches],
                        'modules' => [$Modules],
                    ];
                } else {
                    // Check if the group already exists for this formateur
                    $groupExists = in_array($Groupe, $FormateursInfo[$foundFormateurIndex]['groupes']);
                    $branchExists = in_array($Branches, $FormateursInfo[$foundFormateurIndex]['branches']);
                    $modulesExists = in_array($Modules, $FormateursInfo[$foundFormateurIndex]['modules']);

                    // If the group doesn't exist, add it to the existing formateur entry
                    if (!$groupExists) {
                        $FormateursInfo[$foundFormateurIndex]['groupes'][] = $Groupe;
                    }

                    if (!$branchExists) {
                        $FormateursInfo[$foundFormateurIndex]['branches'][] = $Branches;
                    }

                    if (!$modulesExists) {
                        $FormateursInfo[$foundFormateurIndex]['modules'][] = $Modules;
                    }
                }

                // Add group name to GroupsInfo if it doesn't exist
                $GroupIndex = null;
                foreach ($GroupsInfo as $index => $groupe) {
                    if ($groupe['code'] === $Groupe) {
                        $GroupIndex = $index;
                        break;
                    }
                }

                if ($GroupIndex === null) {
                    $GroupsInfo[] = [
                        'code' => $Groupe,
                        'neveau' => $neveau,
                        'branch' => $Branches,
                        'modules' => [$Modules]
                    ];
                } else {
                    $GroupsInfo[$GroupIndex]['modules'][] = $Modules;
                }

                // Add module name to ModulesInfo if it doesn't exist
                $ModulesIndex = null;
                foreach ($ModulesInfo as $index => $module) {
                    if ($module['code'] === $Modules) {
                        $ModulesIndex = $index;
                        break;
                    }
                }

                if ($ModulesIndex === null) {
                    $ModulesInfo[] = ['name' => $codeModules, 'code' => $Modules];
                }

                // Add Branches name to BranchesInfo if it doesn't exist
                $BranchesIndex = null;
                foreach ($BranchesInfo as $index => $branche) {
                    if ($branche['code'] === $Branches) {
                        $BranchesIndex = $index;
                        break;
                    }
                }

                if ($BranchesIndex === null) {
                    $BranchesInfo[] = ['code' => $Branches, 'name' => $brancheName];
                }
            }
        }

        // Now remove the first element from each array if they are not empty
        if (!empty($FormateursInfo)) {
            array_shift($FormateursInfo);
        }

        if (!empty($GroupsInfo)) {
            array_shift($GroupsInfo);
        }

        if (!empty($ModulesInfo)) {
            array_shift($ModulesInfo);
        }

        if (!empty($BranchesInfo)) {
            array_shift($BranchesInfo);
        }

        // dd($FormateursInfo, $GroupsInfo, $ModulesInfo, $BranchesInfo);


      try {


          // inserting data into DB
          $establishment_id = session()->get('establishment_id');
          if(!empty($BranchesInfo)){
            foreach($BranchesInfo as $branch){
                branch::create([
               'id' => $establishment_id.$branch['code'],
               'name'=>$branch['name'],
               'establishment_id'=>$establishment_id
                ]);
             }
          }
          if(!empty($ModulesInfo)){
            foreach($ModulesInfo as $modul){
                module::create([
               'id' => $establishment_id.$modul['code'],
               'module_name'=>$modul['name'],
               'establishment_id'=>$establishment_id
                ]);
       }
          }
          if(!empty($GroupsInfo)){

            foreach($GroupsInfo as $group){
                group::create([
                   'id'=>$establishment_id.$group['code'],
                   'group_name' => $group['code'],
                   'barnch_id'=>$establishment_id.$group['branch'],
                   'year'=>$group['neveau'],
                   'establishment_id'=>$establishment_id
                ]);

                foreach($group['modules'] as $modul){
                    group_has_module::create([
                        'group_id'=>$establishment_id.$group['code'],
                        'module_id'=>$establishment_id.$modul
                    ]);
                }
            }


          }

          if(!empty($FormateursInfo)){
            foreach($FormateursInfo as $formateur){
                $password = $this->generatePassword();
                formateur::create([
                        'passwordClone'=>$password,
                        'password'=>bcrypt($password),
                        'role'=>'formateur',
                        'status'=>'active',
                        'user_name'=> $formateur['name'],
                        'establishment_id'=>$establishment_id,
                        'id'=>$formateur['matricule']
                    ]);
                    
                    

                    // assigne branch
                    foreach( $formateur['branches'] as $branch){
                        formateur_has_branche::create([
                            'barnch_id'=> $establishment_id.$branch ,
                            'formateur_id'=>  $formateur['matricule'],
                        ]);
                    }

                    foreach ($formateur['modules'] as $modul){
                        module_has_formateur::create([
                            'module_id' =>$establishment_id.$modul,
                            'formateur_id' => $formateur['matricule'],
                        ]);
                    }

                    foreach($formateur['groupes'] as $group){
                        formateur_has_group::create([
                            'group_id' => $establishment_id.$group,
                            'formateur_id' =>$formateur['matricule'],
                        ]);
                    };

            }
           
            $type = 'createAccount';
            $mainUsers = User::where('role', 'formateur')->get();
            Notification::send($mainUsers, new RequestEmploiNotification($type,'', Auth::user()->user_name,'','',''));
          }
          unlink(storage_path('app/' . $filePath));
        return redirect()->route('UploedFileExcelView')->with(['success'=>'Vous avez configuré les paramètres de votre compte avec succès.']);
    }
      catch(\Illuminate\database\QueryException $e){
        unlink(storage_path('app/' . $filePath));
            return  redirect()->route('UploedFileExcelView')->withErrors(['errors'=>$e->errorInfo[2]]);
        }


}

    function generatePassword($length = 8) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $charactersLength = strlen($characters);
        $randomPassword = '';
        for ($i = 0; $i < $length; $i++) {
            $randomPassword .= $characters[random_int(0, $charactersLength - 1)];
        }
        return $randomPassword;
    }

}
