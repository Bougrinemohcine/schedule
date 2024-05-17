<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use App\Models\group;
use App\Models\branch;
use App\Models\module;
use App\models\group_has_module;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class AddGroupes extends Component
{
    use LivewireAlert;
    public $branches ;
    public $groupesModules ;
    public $modules ;
    public $dataGroups;
    public $groups ;
    public $selectedBranch;
    // form var
    public $group_name ;
    public $branch;
    public $selectedModules ;
    public $year;

    // Edit Groupe
    public $Idgroup ;
    public $oldIdGroup ;
    public $oldGroupName ;
    public $oldyear ;
    public $oldBranch ;

    protected $listeners = ['componentRefreshed' => '$refresh' , 'GetIdGroupe' => 'GetIdGroupe' ,'updateGroup'=>'$refresh'];
    public function FNrefresh(){
        $this->reset();
    }

    public function GetIdGroupe($idGroup){
        $this->Idgroup =$idGroup ;
    }

 // insert groups
public function create()
{
    $establishment = session()->get('establishment_id');

    try {
        $groupNameWithoutSpaces = str_replace([' ', "'" ,"/" , "#"] , '', $this->group_name);


        // dd($this);
        $group = group::create([
            'id' => $establishment .$groupNameWithoutSpaces,
            'group_name' => $this->group_name,
            'year' => $this->year,
            'barnch_id' => $this->selectedBranch,
            'establishment_id' => $establishment
        ]);

        $modules = $this->selectedModules;
        if ($group && $modules) {
            foreach ($modules as $module) {
                // Check if the group has already been assigned this module
                $isExist = group_has_module::where([
                    'module_id' => $module,
                    'group_id' => $establishment . $groupNameWithoutSpaces, // Use the newly created group's ID here
                ])->exists();

                if (!$isExist) {
                    group_has_module::create([
                        'module_id' => $module,
                        'group_id' => $establishment . $groupNameWithoutSpaces, // Use the newly created group's ID here
                    ]);

                }
            }

            $this->alert('success', 'Vous avez ajouté un nouveau groupe', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => true,
            ]);


            $this->emitSelf('componentRefreshed');
                        $this->resetForm();


        } else {
            if ($group) {
                $this->alert('success', 'Vous avez ajouté un nouveau groupe', [
                    'position' => 'center',
                    'timer' => 3000,
                    'toast' => true,
                ]);

                $this->emitSelf('componentRefreshed');
                $this->resetForm();

            } else {
                $this->alert('error', "Il y a eu un problème lors de l'ajout du groupe", [
                    'position' => 'center',
                    'timer' => 3000,
                    'toast' => true,
                ]);
            }
        }
    } catch (\Illuminate\Database\QueryException $e) {
        $this->alert('error', "Ce groupe a déjà été créé.", [
            'position' => 'center',
            'timer' => 3000,
            'toast' => true,
        ]);
        // dd($e->getMessage());
    }
}



    private function resetForm()
    {
        $this->group_name = '';
        $this->branch = null;
        $this->selectedModules = [];
        $this->year = '';
    }

    public function delete($id)
    {
        $group = group::find($id);

        if ($group) {
            $group->delete();
            $this->alert('success', 'Vous avez supprimé un groupe', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => true,
            ]);
        } else {
            $this->alert('error', 'Le groupe que vous essayez de supprimer n\'existe pas.', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => true,
            ]);
        }
    }

    public function render()
    {

        $establishment = session()->get('establishment_id');
        $this->branches = branch::where('establishment_id',$establishment)->get();

        $this->groupesModules = DB::table('groups')
            ->join('groupe_has_modules as ghm', 'ghm.group_id', '=', 'groups.id')
            ->join('modules as m', 'm.id' , '=', 'ghm.module_id')
            ->select('m.id as module_name', 'groups.*')
            ->where('groups.establishment_id', $establishment)
            ->get();

        $this->modules = module::where('establishment_id',$establishment)->get();

            // Query to fetch groups with branches and modules
            $dataGroupsWithBranchAndModules = DB::table('groups')
            ->join('groupe_has_modules as ghm', 'ghm.group_id', '=', 'groups.id')
            ->join('modules as m', 'm.id', '=', 'ghm.module_id')
            ->join('branches as br' , 'br.id' , '=' , 'groups.barnch_id')
            ->select('groups.id as group_id', 'groups.group_name', 'groups.year', 'groups.barnch_id', 'br.name as branch_name','m.id as module_name')
            ->where('groups.establishment_id', $establishment);
            // Query to fetch groups without any branches or modules
            $dataGroupsWithoutBranchAndModules = DB::table('groups')
            ->leftJoin('groupe_has_modules as ghm', 'ghm.group_id', '=', 'groups.id')
            ->leftJoin('modules as m', 'm.id', '=', 'ghm.module_id')
            ->leftJoin('branches as br' , 'br.id' , '=' , 'groups.barnch_id')
            ->select('groups.id as group_id', 'groups.group_name', 'groups.year', 'groups.barnch_id', 'br.name as branch_name','m.id as module_name')
            ->where('groups.establishment_id', $establishment)
            ->whereNull('groups.barnch_id')
            ->orwhereNull('m.id');
            // Combine both queries using union
            $dataGroups = $dataGroupsWithBranchAndModules->union($dataGroupsWithoutBranchAndModules)->get();
            // Group modules by group_id
            $this->groups = $dataGroups->groupBy('group_id')->map(function ($group) {
            // Merge all modules into one array for each group
            $modules = $group->pluck('module_name')->toArray();
            return [
                'group_id' => $group[0]->group_id,
                'group_name' => $group[0]->group_name,
                'year' => $group[0]->year,
                'branch_id' => $group[0]->barnch_id,
                'branch'=> $group[0]->branch_name ,
                'modules' => $modules,
            ];
            })->values()->all();


             // set data on Edit Mudule
        if(!empty($this->Idgroup)){
             $group = group::find($this->Idgroup);

             $this->oldBranch = $group->barnch_id;
             $this->oldGroupName = $group->group_name;
             $this->oldyear = $group->year;
        }
        // end set data on Edit Modules
        return view('livewire.add-groupes');
    }
}
