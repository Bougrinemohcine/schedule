<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB ;
use App\Models\group ;
use App\Models\group_has_module;
use App\Models\module ;
use Illuminate\Auth\Events\Validated;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class UpdateGroupes extends Component
{
    use LivewireAlert ;
    public $group ;
    public $branches = [] ;
    public $modules =  [] ;
    public $branch;
    public $group_name ;
    public $year ;
    public $selectedModules = [] ;
    public $Allmodules =[] ;
    public $selectedBranch;
    public $groupID;



    public function mount($group, $modules , $branches)
    {
        $this->groupID = $group['group_id'];
        $groupModel = group::find($group['group_id']);
        $this->group_name = $groupModel->group_name;
        $this->year = $groupModel->year;
        $this->branches = $branches;

        $assignModulesIDs = $groupModel->modules()->pluck('modules.id')->toArray();
        $this->selectedBranch = $groupModel->barnch_id;
        foreach ($modules as $module) {
            $this->selectedModules[$module->id] = in_array($module->id, $assignModulesIDs);
        }
    }

    public function update()
    {

        try {
            $this->validate([
                'group_name' => 'required',
                'selectedBranch' => 'required',

            ]);

            $group = group::find($this->groupID);
            $group->group_name = $this->group_name;
            $group->year = $this->year;
            $group->barnch_id = $this->selectedBranch;
            $group->save();

            $modules = array_keys(array_filter($this->selectedModules));

            $group->modules()->sync($modules);

            $this->Alert("success", 'Group updated successfully', [
                'position' => 'center',
                'timer' => 2300,
                'toast' => true,
                'width' => 450,
            ]);
            $this->emit('updateGroup');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e->getMessage());
        }
    }



    public function render()
    {
        return view('livewire.update-groupes');
    }
}
