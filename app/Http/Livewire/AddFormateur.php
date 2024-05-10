<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\formateur;
use App\Models\branch;
use App\Models\module;
use App\Models\group;
use App\Models\formateur_has_branche;
use App\Models\formateur_has_group;
use App\Models\module_has_formateur;
use App\Models\Establishment;
use App\Models\group_has_module;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class AddFormateur extends Component
{
    use LivewireAlert ;
    public $formateurs = [];
    public $branches = [];
    public $groupes = [];
    public $modules = [];
    public $formateur_name;
    public $idFormateur;
    public $selectedBranches = [];
    public $selectedGroupes = [];
    public $selectedModules = [];
    public $New_formateur_name;
    public $New_idFormateur;
    public $New_selectedBranches = [];
    public $New_selectedGroupes = [];
    public $New_selectedModules = [];
    public $formateurBranches = [];
    public $desactive;
    public $active;
    public $New_Password;
    public $addFormateur = false;
    public $adBranche = false;
    public $addGroupe = false;
    public $addModule = false;
    public $SearchValue ;
    public $branchesForEashFormateur = [];

    // filter
    public $branchesIdsSelected  ;




    protected $listeners = [
    'postAdded' => 'incrementPostCount' ,
     'refreshComponentB' => '$refresh'];
    // protected $listeners = [];
    public function incrementPostCount($id)
    {
        $this->New_idFormateur = $id;
    }



    public function render()
    {

        $establishment_id = session()->get('establishment_id');
        $groupesAll = group::where('establishment_id', $establishment_id);
        if(!empty($this->selectedBranches)){
             $groupesAll->whereIn('barnch_id',$this->selectedBranches)->get();

        }
        $this->groupes = $groupesAll->get();

        $this->formateurs = Formateur::where('user_name' , 'like' ,'%'.$this->SearchValue.'%')->where('role', 'formateur')
            ->where('establishment_id', $establishment_id)
            ->get();

        $this->branchesForEashFormateur = Branch::select('branches.*')
        ->join('formateur_has_filier as FHF', 'FHF.barnch_id', '=', 'branches.id')
        ->where('FHF.formateur_id', )
        ->where('establishment_id', $establishment_id)
        ->get(); ;
            $this->branches = Branch::where('establishment_id', $establishment_id)->get();
            if(empty($this->selectedGroupes)){
                 $this->modules = Module::select('modules.id')->where('establishment_id', $establishment_id)->get();
            }else{
                // $this->modules = group_has_module::select('module_id as id')->whereIn('group_id' ,$this->selectedGroupes)->get();
                // dd($this->modules->id);
                $this->modules= Module::select('modules.id')
                ->join('groupe_has_modules','groupe_has_modules.module_id','=','modules.id')
                ->whereIn('group_id' ,$this->selectedGroupes)
                ->where('establishment_id', $establishment_id)
                ->get();
            };


        if($this->New_idFormateur){
            $formateur = Formateur::find($this->New_idFormateur);
            $this->New_formateur_name = $formateur->user_name;
            $this->New_Password = $formateur->passwordClone;

        }

        return view('livewire.add-formateur');
    }

      // create a new formateur
      public function create()
      { try{

          $establishment_id = session()->get('establishment_id');
          // Generate password
          function generatePassword($length = 8) {
              $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
              $charactersLength = strlen($characters);
              $randomPassword = '';
              for ($i = 0; $i < $length; $i++) {
                  $randomPassword .= $characters[random_int(0, $charactersLength - 1)];
              }
              return $randomPassword;
          }
          $password = generatePassword();
          // Create formateur
          $formateur = formateur::create([
              'id'=>$this->idFormateur,
              'passwordClone' => $password,
              'password' => bcrypt($password),
              'role' => 'formateur',
              'status' => 'active',
              'user_name' => $this->formateur_name,
              'establishment_id' => $establishment_id
          ]);

          if ($formateur) {
              // Associate selected branches if they are provided
              if (!empty($this->selectedBranches)) {

                  foreach ($this->selectedBranches as $branche) {
                      // Check if the association already exists
                      $existingAssociation = formateur_has_branche::where('formateur_id', $this->idFormateur)
                          ->where('barnch_id', $branche)
                          ->first();

                      // If the association doesn't exist, create it
                      if (!$existingAssociation) {
                          formateur_has_branche::create([
                              'formateur_id' => $this->idFormateur,
                              'barnch_id' => $branche
                          ]);
                          $this->adBranche = true ;
                      }
                      else{
                          // if already  association exist  should tell  user  about it
                          $this->alert('error', 'Certains filiéres sont déjà associés à ce formateur.', [
                              'position' => 'center',
                              'timer' => 3000,
                              'toast' => true,
                          ]);
                      }
                  }

              }

              // Associate selected groupes if they are provided
              if (!empty($this->selectedGroupes)) {
                  foreach ($this->selectedGroupes as $groupe) {
                      // Check if the association already exists
                      $existingGroupes = formateur_has_group::where('formateur_id', $this->idFormateur)
                          ->where('group_id', $groupe)
                          ->first();

                      // If the association doesn't exist, create it
                      if (!$existingGroupes) {
                          formateur_has_group::create([
                              'formateur_id' => $this->idFormateur,
                              'group_id' => $groupe
                          ]);
                          $this->addGroupe = true ;
                      }

                      else{
                          // if already  association exist  should tell  user  about it
                          $this->alert('error', 'Certains groupes sont déjà associés à ce formateur.', [
                              'position' => 'center',
                              'timer' => 3000,
                              'toast' => true,
                          ]);
                      }
                  }
              }
              // Associate selected modules if they are provided
              if (!empty($this->selectedModules)) {
                  foreach ($this->selectedModules as $module) {
                      // Check if the association already exists
                      $existingModules= module_has_formateur::where('formateur_id', $this->idFormateur)
                          ->where('module_id', $module)
                          ->first();
                      // If the association doesn't exist, create it
                      if (!$existingModules) {
                          module_has_formateur::create([
                              'formateur_id' => $this->idFormateur,
                              'module_id' => $module
                          ]);
                          $this->addModule = true ;
                      }
                      else{
                          // if already  association exist  should tell  user  about it
                          $this->alert('error', 'Certains modules sont déjà associés à ce formateur.', [
                              'position' => 'center',
                              'timer' => 3000,
                              'toast' => true,
                          ]);
                      }
                  }
              }

              if( $this->addModule ||  $this->addGroupe ||  $this->adBranche){
                  $this->alert('success', "Vous avez ajouté un nouveau formateur", [
                      'position' => 'center',
                      'timer' => 3000,
                      'toast' => true,
                  ]);
              }
          }
      }catch ( \Illuminate\Database\QueryException $e) {
          $this->alert('error', "Ce formateur existe déjà.", [
              'position' => 'center',
              'timer' => 3000,
              'toast' => true,
          ]);
          }
      }


      public function destroy($id)
      {
          $formateur = formateur::destroy($id);

              $this->alert('success', "Vous avez supprimé ce formateur.", [
                  'position' => 'center',
                  'timer' => 3000,
                  'toast' => true,
              ]);

       

      }






}
