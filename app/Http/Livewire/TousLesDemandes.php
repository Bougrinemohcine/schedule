<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\main_emploi;
use Illuminate\Support\Facades\DB;
use App\Models\group;
use App\Models\User;
use App\Models\module;
use App\Models\class_room;
use Illuminate\Support\Facades\Auth;
use App\Models\Setting;
use App\Models\class_room_type;
use Illuminate\Support\Facades\Session;
use App\Models\sission;
use Jantinnerezo\LivewireAlert\LivewireAlert;

use function PHPUnit\Framework\isEmpty;

class TousLesDemandes extends Component
{
    use LivewireAlert;
    public $modules;
    public $salles;
    public $classType;
    public $formateur;
    public $salle;
    public $TypeSesion;
    public $module;
    public $salleclassTyp;
    public $idCase;
    public $group;
    public $FormateurOrgroup;
    // Model
    public $idMainEmploi;
    public $sissions  = [];
    public $formateurs;
    public $selectedValue; //i will sit default value here
    public $selectedType;
    public $groups;
    public $receivedVariable;
    public $Main_emplois;
    public $checkValues;
    public $groupes = [];
    public $selectedGroups = [];
    public $brancheId;
    public $baranches;
    public $Group_has_formateurs;
    public $yearFilter = [];
    public $selectedYear;
    public $SearchValue;
    public $formateurId;
    public $groupID;


    protected $listeners = [
        'receiveidEmploiid' => 'receiveidEmploiid',
        'fresh' => '$refresh'
    ];

    public function mount()
    {
        // Fetch the last emploi from the database
        $lastEmploi = main_emploi::latest()->first();

        // Check if $lastEmploi exists
        if ($lastEmploi) {
            // Set the default value for selectedValue
            $this->selectedValue = $lastEmploi->id;
        }
    }

    public function getidCase($variable)
    {
        $this->receivedVariable = $variable;
        $this->selectedGroups = [];
        $this->brancheId = null;
        $this->formateur = null;
    }
    public function updateSelectedType($value)
    {
        $this->selectedType = $value;
    }
    // NEWADD
    public $isCaseEmpty = true;

    public function updateCaseStatus($isEmpty, $variable)
    {
        $this->isCaseEmpty = $isEmpty;
        $this->receivedVariable = $variable;
        $this->formateurId = substr($variable, 11);
        $this->brancheId = null;
        $this->formateur = null;
        $this->selectedGroups = [];
        $this->selectedYear = null;
        $this->salle = null;
        $this->module = null;
        $this->salleclassTyp = null;
        $this->TypeSesion = null;
    }






    public function Canceled()
    {
        $day = substr($this->receivedVariable, 0, 3);
        $day_part = substr($this->receivedVariable, 3, 5);
        $group_id = substr($this->receivedVariable, 11);
        $user_id = substr($this->receivedVariable, 11);
        $dure_sission = substr($this->receivedVariable, 8, 3);

        $sessionsQuery = sission::where([
            'main_emploi_id' => $this->selectedValue,
            'day' => $day,
            'day_part' => $day_part,
            'dure_sission' => $dure_sission,
        ]);

        if ($this->selectedType === "Group") {
            $sessionsQuery->where('group_id', $group_id);
        } else {
            $sessionsQuery->where('user_id', $this->formateurId);
        }

        $sessions = $sessionsQuery->get();

        if ($sessions->isNotEmpty()) {
            foreach ($sessions as $session) {
                $session->status_sission = 'Cancelled';
                $session->save();
            }

            $this->alert('success', 'Sessions Cancelled successfully.', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => true,
            ]);
        } else {
            $this->alert('error', 'No sessions found to cancel.', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => true,
            ]);
        }

    }

    public function Accepte()
{
    $day = substr($this->receivedVariable, 0, 3);
    $day_part = substr($this->receivedVariable, 3, 5);
    $group_id = substr($this->receivedVariable, 11);
    $user_id = substr($this->receivedVariable, 11);
    $dure_sission = substr($this->receivedVariable, 8, 3);

    $sessionsQuery = sission::where([
        'main_emploi_id' => $this->selectedValue,
        'day' => $day,
        'day_part' => $day_part,
        'dure_sission' => $dure_sission,
    ]);

    if ($this->selectedType === "Group") {
        $sessionsQuery->where('group_id', $group_id);
    } else {
        $sessionsQuery->where('user_id', $this->formateurId);
    }

    $sessions = $sessionsQuery->get();

    if ($sessions->isNotEmpty()) {
        foreach ($sessions as $session) {
            $session->status_sission = 'Accepted';
            $session->save();
        }

        $this->alert('success', 'Sessions accepted successfully.', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => true,
        ]);
    } else {
        $this->alert('error', 'No sessions found to accept.', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => true,
        ]);
    }
}

    //--------------------------------------------------------------- NEWADD

    public function receiveidEmploiid($variable)
    {
        session(['idEmploiSelected' => $variable]);
        $this->selectedValue = $variable;

    }
    public function updateSelectedIDEmploi($value)
    {
        session(['idEmploiSelected' => $value]);
        $this->selectedValue = $value;
    }
    public function UpdateSession()
{
    try {
        $idcase = $this->receivedVariable;
        $day = substr($idcase, 0, 3);
        $day_part = substr($idcase, 3, 5);
        $group_id = substr($idcase, 11);
        $user_id = substr($idcase, 11);
        $dure_sission = substr($idcase, 8, 3);

        if ($this->selectedType !== "Group") {
            $sessionQuery = Sission::where([
                'main_emploi_id' => $this->selectedValue,
                'day' => $day,
                'day_part' => $day_part,
                'dure_sission' => $dure_sission,
            ]);
            $sessionQuery->where('user_id', $user_id);
            $session = $sessionQuery->first();

            if ($session) {
                if ($this->TypeSesion === 'teams') {
                        $session->update(['class_room_id' => $this->salle]);
                        $this->alert('success', 'Vous modifiez la salle de cette séance.', [
                            'position' => 'center',
                            'timer' => 3000,
                            'toast' => true,
                        ]);
                    if ($this->TypeSesion !== null) {
                        $session->update(['sission_type' => $this->TypeSesion]);
                        $this->alert('success', 'Vous modifiez le type de cette séance.', [
                            'position' => 'center',
                            'timer' => 3000,
                            'toast' => true,
                        ]);
                    }
                    if ($this->salleclassTyp !== null) {
                        $session->update(['typeSalle' => $this->salleclassTyp]);
                        $this->alert('success', 'Vous modifiez le type de Salle.', [
                            'position' => 'center',
                            'timer' => 3000,
                            'toast' => true,
                        ]);
                    }
                    if ($this->module !== null) {
                        $session->update(['module_id' => $this->module]);
                    }

                    if (!empty($this->selectedGroups)) {
                        foreach ($this->selectedGroups as $group) {
                            $session->update(['group_id' => $group]);
                        }

                        $this->alert('success', 'Vous modifiez le Formateur de cette séance.', [
                            'position' => 'center',
                            'timer' => 3000,
                            'toast' => true,
                        ]);
                    }
                }elseif(!empty($this->salle)){
                    if ($this->salle !== null) {
                        $session->update(['class_room_id' => $this->salle]);
                        $this->alert('success', 'Vous modifiez la salle de cette séance.', [
                            'position' => 'center',
                            'timer' => 3000,
                            'toast' => true,
                        ]);
                    }
                    if ($this->TypeSesion !== null) {
                        $session->update(['sission_type' => $this->TypeSesion]);
                        $this->alert('success', 'Vous modifiez le type de cette séance.', [
                            'position' => 'center',
                            'timer' => 3000,
                            'toast' => true,
                        ]);
                    }
                    if ($this->salleclassTyp !== null) {
                        $session->update(['typeSalle' => $this->salleclassTyp]);
                        $this->alert('success', 'Vous modifiez le type de Salle.', [
                            'position' => 'center',
                            'timer' => 3000,
                            'toast' => true,
                        ]);
                    }
                    if ($this->module !== null) {
                        $session->update(['module_id' => $this->module]);
                    }

                    if (!empty($this->selectedGroups)) {
                        foreach ($this->selectedGroups as $group) {
                            $session->update(['group_id' => $group]);
                        }

                        $this->alert('success', 'Vous modifiez le Formateur de cette séance.', [
                            'position' => 'center',
                            'timer' => 3000,
                            'toast' => true,
                        ]);
                    }
                } elseif (empty($this->salle)) {
                    $this->alert('error', 'Vous devriez sélectionner la salle.', [
                        'position' => 'center',
                        'timer' => 3000,
                        'toast' => true,
                    ]);
                    return;
                }
            } else {
                if($this->TypeSesion === 'teams'){
                    foreach ($this->selectedGroups as $group) {
                        Sission::create([
                            'day' => $day,
                            'day_part' => $day_part,
                            'dure_sission' => $dure_sission,
                            'module_id' => $this->module,
                            'group_id' => $group,
                            'establishment_id' => session()->get('establishment_id'),
                            'user_id' => $this->formateurId,
                            'class_room_id' => $this->salle,
                            'validate_date' => null,
                            'main_emploi_id' => session()->get('id_main_emploi'),
                            "demand_emploi_id" => null,
                            'typeSalle' => $this->salleclassTyp,
                            'message' => null,
                            'sission_type' => $this->TypeSesion,
                            'status_sission' => 'Accepted',
                        ]);
                        $this->selectedGroups = [];
                        $this->alert('success', 'Vous créez une nouvelle session', [
                            'position' => 'center',
                            'timer' => 3000,
                            'toast' => true,
                        ]);
                    }
                }elseif(!empty($this->salle)){
                    foreach ($this->selectedGroups as $group) {
                        Sission::create([
                            'day' => $day,
                            'day_part' => $day_part,
                            'dure_sission' => $dure_sission,
                            'module_id' => $this->module,
                            'group_id' => $group,
                            'establishment_id' => session()->get('establishment_id'),
                            'user_id' => $this->formateurId,
                            'class_room_id' => $this->salle,
                            'validate_date' => null,
                            'main_emploi_id' => session()->get('id_main_emploi'),
                            "demand_emploi_id" => null,
                            'typeSalle' => $this->salleclassTyp,
                            'message' => null,
                            'sission_type' => $this->TypeSesion,
                            'status_sission' => 'Accepted',
                        ]);
                        $this->selectedGroups = [];
                        $this->alert('success', 'Vous créez une nouvelle session', [
                            'position' => 'center',
                            'timer' => 3000,
                            'toast' => true,
                        ]);
                    }
                }elseif(empty($this->salle)){
                    $this->alert('error', 'Vous devriez sélectionner la salle.', [
                        'position' => 'center',
                        'timer' => 3000,
                        'toast' => true,
                    ]);
                    return;
                }

            }
        }else{
            $sessionData = [
                'day' => $day,
                'day_part' => $day_part,
                'dure_sission' => $dure_sission,
                'module_id' => $this->module,
                'establishment_id' => session()->get('establishment_id'),
                'class_room_id' => $this->salle,
                'main_emploi_id' => $this->selectedValue,
                'demand_emploi_id' => null,
                'message' => null,
                'sission_type' => $this->TypeSesion,
                'status_sission' => 'Accepted',
            ];
            $sessionData['group_id'] = $group_id;
            $sessionData['user_id'] = $this->formateur;

            $session = sission::where([
                'main_emploi_id' => $this->selectedValue,
                'day' => $day,
                'day_part' => $day_part,
                'group_id' => $group_id,
                'dure_sission' => $dure_sission,
            ])->first();
            if($this->TypeSesion === 'teams'){

                if ($session) {
                    $session->update($sessionData);
                } else {
                    sission::create($sessionData);
                }
            }elseif(!empty($this->salle)){

                if ($session) {
                    $session->update($sessionData);
                } else {
                    sission::create($sessionData);
                }
            }elseif(empty($this->salle)){
                $this->alert('error', 'Vous devriez sélectionner la salle.', [
                    'position' => 'center',
                    'timer' => 3000,
                    'toast' => true,
                ]);
                return;
            }
        }

        $this->emit('fresh');
    } catch (\Illuminate\Database\QueryException $e) {
        if (strpos($e->getMessage(), "Column 'main_emploi_id' cannot be null") !== false) {
            $this->alert('error', 'Vous devriez sélectionner la date de début.', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => true,
            ]);
        } elseif (strpos($e->getMessage(), "Column 'user_id' cannot be null") !== false) {
            $this->alert('error', 'Vous devriez sélectionner le formateur.', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => true,
            ]);
        } elseif (strpos($e->getMessage(), "Column 'class_room_id' cannot be null") !== false) {
            $this->alert('error', 'Vous devriez sélectionner la salle.', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => true,
            ]);
        } else {
            // Generic error handling
            $this->alert('error', $e->errorInfo[2], [
                'position' => 'center',
                'timer' => 3000,
                'toast' => true,
            ]);
            return redirect()->back()->withErrors(['insertion_error' => $e->errorInfo[2]]);
        }
    }
}



    public function DeleteSession()
    {
        $idcase = $this->receivedVariable;
        $day = substr($idcase, 0, 3);
        $day_part = substr($idcase, 3, 5);
        $group_id = substr($idcase, 11);
        $user_id = substr($idcase, 11);
        $dure_sission = substr($idcase, 8, 3);

        if ($this->selectedType === "Group") {
            sission::where([
                'main_emploi_id' => session()->get('id_main_emploi'),
                'day' => $day,
                'day_part' => $day_part,
                'group_id' => $group_id,
                'dure_sission' => $dure_sission
            ])->delete();
        } else {
            sission::where([
                'main_emploi_id' => session()->get('id_main_emploi'),
                'day' => $day,
                'day_part' => $day_part,
                'user_id' => $user_id,
                'dure_sission' => $dure_sission
            ])->delete();
        }
    }


    // Method to update selected type emploi group or formateur

    // Method to update selected id emploi

    public function findSeance()
    {
        $idcase = $this->receivedVariable;
        $day = substr($idcase, 0, 3);
        $day_part = substr($idcase, 3, 5);
        $user_id = substr($idcase, 11);
        $group_id = substr($idcase, 11);
        $dure_sission = substr($idcase, 8, 3);

        $seance = null;

        // Check if $user_id is numeric to determine if it's a formateur ID
        if ($this->selectedType === "Group") {
            // Query using user ID

            $seance = sission::where([
                'main_emploi_id' => $this->selectedValue,
                'day' => $day,
                'day_part' => $day_part,
                'group_id' => $group_id,
                'dure_sission' => $dure_sission
            ])->get();
        } else {
            // Query using group ID
            $seance = sission::where([
                'main_emploi_id' => $this->selectedValue,
                'day' => $day,
                'day_part' => $day_part,
                'user_id' => $user_id,
                'dure_sission' => $dure_sission
            ])->get();
        }

        return $seance ?: collect(); // Return an empty collection if $seance is null
    }


    // Livewire component method
    public function AccepteAlll($groupID)
    {
        // Find all sessions for the current group and main_emploi
        $sessions = Sission::where([
            'group_id' => $groupID,
            'main_emploi_id' => $this->selectedValue
        ])->get();

        // Update the status of each session to "Accepted"
        foreach ($sessions as $session) {
            $session->status_sission = 'Accepted';
            $session->save();
        }

        // Show a success message
        $this->alert('success', 'All sessions accepted successfully.', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => true,
        ]);

        // Refresh the page
        $this->render();
    }

    public function AccepteAll($formateurID)
    {
        // Find all sessions for the current formateur and main_emploi
        $sissions = Sission::where([
            'user_id' => $formateurID,
            'main_emploi_id' => $this->selectedValue
        ])->get();

        // Update the status of each session to "Accepted"
        foreach ($sissions as $sission) {
            $sission->status_sission = 'Accepted';
            $sission->save();
        }

        // Show a success message
        $this->alert('success', 'All sessions accepted successfully.', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => true,
        ]);

        // Refresh the page
        $this->render();
    }
    // for delate all sessions
    public function deleteAllSessions()
    {
        DB::table('sissions')->where('establishment_id', session()->get('establishment_id'))
            ->where('main_emploi_id',  $this->selectedValue)->delete();
        DB::table('main_emploi')->where('establishment_id', session()->get('establishment_id'))
            ->where('id',  $this->selectedValue)->delete();

        $this->Alert("success", "Vous avez supprimé l'emploi du template.", [
            'position' => 'center',
            'timer' => 3000,
            'toast' => false,
            'width' => 650,
        ]);
        return redirect()->route('toutlesEmploi');
    }

    public function render()
    {

        // Initialize variables
        $establishment_id = session()->get('establishment_id');
        $this->yearFilter = DB::table('groups')
            ->where('establishment_id', $establishment_id)
            ->select('year')
            ->distinct()
            ->pluck('year');


        $this->checkValues = Setting::select('typeSession', 'branch', 'year', 'module', 'formateur', 'salle', 'typeSalle')
            ->where('userId', Auth::id())->get();

        // Fetch data from branches table
        $this->baranches = DB::table('branches')
            ->select('branches.*')
            ->join('formateur_has_filier', 'formateur_has_filier.barnch_id', '=', 'branches.id')
            ->where('formateur_has_filier.formateur_id', substr($this->receivedVariable, 11))
            ->get();

        // Fetch data related to formateurs
        $allFormateursByGroup = User::select('users.*')
            ->join('formateur_has_groups as f', 'f.formateur_id', '=', 'users.id')
            ->where('users.status', '=', 'active')
            ->where('f.group_id', substr($this->receivedVariable, 11))
            ->get();

        // Fetch main emploi data
        $this->Main_emplois  = DB::table('main_emploi')
            ->where('establishment_id', $establishment_id)
            ->orderBy('datestart', 'desc')
            ->get();

        // Fetch modules data
        if ($this->selectedType !== 'Group') {
            // Fetch modules based on formateurId if selectedType is not 'Group'
            $this->modules = Module::join('module_has_formateur as MHF', 'MHF.module_id', '=', 'modules.id')
                ->join('groupe_has_modules as GHM', 'GHM.module_id', '=', 'modules.id')
                ->where('modules.establishment_id', $establishment_id)
                ->where('MHF.formateur_id', $this->formateurId)
                ->whereIn('GHM.group_id', $this->selectedGroups)
                ->select('modules.*')
                ->distinct()
                ->get();
        } else {
            // Fetch modules based on receivedVariable if selectedType is 'Group'
            $this->modules = Module::join('module_has_formateur as MHF', 'MHF.module_id', '=', 'modules.id')
                ->join('groupe_has_modules as GHM', 'GHM.module_id', '=', 'modules.id')
                ->where('modules.establishment_id', $establishment_id)
                ->where('MHF.formateur_id', $this->formateur)
                ->where('GHM.group_id', substr($this->receivedVariable, 11))
                ->select('modules.*')
                ->get();
        }

        // Fetch class rooms data
        $this->salles = Class_room::where('id_establishment', $establishment_id)->get();
        $this->classType = Class_room_type::where('establishment_id', $establishment_id)->get();

        // Fetch sissions data
        $sissions = DB::table('sissions')
        ->select('sissions.*', 'modules.id as module_name', 'groups.group_name', 'users.*', 'class_rooms.class_name')
        ->leftJoin('modules', 'modules.id', '=', 'sissions.module_id')
        ->join('groups', 'groups.id', '=', 'sissions.group_id')
        ->join('users', 'users.id', '=', 'sissions.user_id')
        ->leftJoin('class_rooms', 'class_rooms.id', '=', 'sissions.class_room_id')
        ->where('sissions.establishment_id', $establishment_id)
        ->where('sissions.main_emploi_id', $this->selectedValue)
        ->get();
;
        // Fetch groups data
        $groupsQuery = group::join('formateur_has_groups as f', 'f.group_id', '=', 'groups.id')
            ->where('groups.establishment_id', $establishment_id)
            ->where('f.formateur_id', substr($this->receivedVariable, 11))
            ->select('groups.id', 'groups.group_name');

        if ($this->brancheId !== 'Filiére' && $this->brancheId) {
            $groupsQuery->where('groups.barnch_id', $this->brancheId);
        }
        if ($this->selectedYear !== 'année' && $this->selectedYear) {

            $groupsQuery->where('groups.year', "{$this->selectedYear}");
        }

        $this->groupes = $groupsQuery->get();

        // Remove unnecessary data
        $removeSalles = [];
        $removeGroupes = [];
        $removeFormateur = [];

        foreach ($sissions as $session) {
            $combinedValue = $session->day . $session->day_part . $session->dure_sission;
            if ($combinedValue === substr($this->receivedVariable, 0, 11)) {
                $removeFormateur[] = $session->user_id;
                $removeSalles[] = $session->class_room_id;
                $removeGroupes[] = $session->group_id;
            }
        }


        // Filter data
        $this->Group_has_formateurs = $allFormateursByGroup->reject(function ($formateur) use ($removeFormateur) {
            return in_array($formateur->id, $removeFormateur);
        });

        $this->salles = $this->salles->reject(function ($salle) use ($removeSalles) {
            return in_array($salle->id, $removeSalles);
        });

        $this->groupes = $this->groupes->reject(function ($groupe) use ($removeGroupes) {
            return in_array($groupe->id, $removeGroupes);
        });

        // Fetch additional data
        $this->sissions = $sissions;
        $this->groups = group::where('group_name', 'like', '%' . $this->SearchValue . '%')->where('establishment_id', $establishment_id)->get();
        $this->formateurs = User::where('user_name', 'like', '%' . $this->SearchValue . '%')->where(['establishment_id' => $establishment_id, 'role' => 'formateur'])->get();

        // NEWADD
        $allseances = sission::where('main_emploi_id', $this->selectedValue)->get();

        $seance = $this->findSeance()->first();
        // Render view
        return view('livewire.tous-les-demandes', ['seance' => $seance, 'allseances' => $allseances]);
    }
}



