<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\branch;
use App\Models\group;
use App\Models\module;
use App\models\formateur;
use Jantinnerezo\LivewireAlert\LivewireAlert;
class UpdateFormateur extends Component
{

    use LivewireAlert;
    public $formateur;
    public $branches = [];
    public $groupes = [];
    public $modules = [];
    public $name;
    public $password;
    public $selectedModules = [];
    public $selectedGroupes = [];
    public $selectedBranches = [];
    public $New_idFormateur ;
    public $status ;


    public function mount($formateur, $branches, $groupes, $modules)
    {
        $this->formateur = $formateur;
        $this->name = $formateur->user_name;
        $this->New_idFormateur = $formateur->id;
        $this->password = $formateur->passwordClone;
        $this->status = $formateur->status ;

        $assignedBranchesIds = $formateur->branches()->pluck('id')->toArray();
        $assignedGroupesIds = $formateur->groupes()->pluck('groups.id')->toArray();
        $assignedModulesIds = $formateur->modules()->pluck('id')->toArray();

        foreach ($branches as $branch) {
            $this->selectedBranches[$branch->id] = in_array($branch->id, $assignedBranchesIds);
        }

        foreach ($groupes as $groupe) {
            $this->selectedGroupes[$groupe->id] = in_array($groupe->id, $assignedGroupesIds);
        }

        foreach ($modules as $module) {
            $this->selectedModules[$module->id] = in_array($module->id, $assignedModulesIds);
        }
    }




public function update()
{
    $this->validate([
        'name' => 'required',
        'password' => 'required',
    ]);
    $formateur = Formateur::find($this->formateur->id);
    $formateur->user_name = $this->name;
    $formateur->password = bcrypt($this->password);
    $formateur->passwordClone = $this->password ;
    $formateur->id = $this->New_idFormateur;

    $formateur->save();

    // Sync selected branches, groupes, and modules
    $formateur->branches()->sync(array_keys(array_filter($this->selectedBranches)));
    $formateur->groupes()->sync(array_keys(array_filter($this->selectedGroupes)));
    $formateur->modules()->sync(array_keys(array_filter($this->selectedModules)));

    // Update formateur status
    $formateur->status = $this->status;
    $formateur->save();
    if($formateur){
        $this->emit('refreshComponentB');
        $this->Alert("success",'Formateur updated successfully.', [
            'position' => 'center',
            'timer' => 2300,
            'toast' => true,
            'width' => 450,
           ]);
    }






}

    public function render()
    {
        
        return view('livewire.update-formateur');
    }
}
