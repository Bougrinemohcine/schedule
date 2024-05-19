<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\group;
use App\Models\module;
use App\Models\Setting;
use App\Models\sission;
use Livewire\Component;
use App\Models\class_room;
use App\Models\main_emploi;
use App\Models\RequestEmploi;
use App\Models\class_room_type;
use Illuminate\Support\Facades\DB;
use App\Models\EmploiStrictureModel;
use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\isEmpty;

use Illuminate\Support\Facades\Session;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Illuminate\Support\Facades\Notification;
use App\Notifications\RequestEmploiNotification;

class FormateurRequests extends Component
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
    public $emploiID; //i will sit default value here
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
    public $mainEmplois;
    public $daysOfWeek;
    public $daysPart;
    public $seancesPart;
    public $comment;
    public $statusseace;
    public $seance;
    public $seanceFirst;
    public $tableEmploi;
    public $isSessionUpdated ;
    public $allSeances ;
    public $existingRequest ;


    protected $listeners = [
        'receiveidEmploiid' => 'receiveidEmploiid',
        'fresh' => '$refresh'
    ];

    public function mount()
    {
         // Retrieve main emploi ID from the request data
         if(empty($this->emploiID)){

             $this->emploiID = main_emploi::latest()->value('id');

             // Fetch all main emplois

             // Fetch initial seances data
             $this->selectedGroups = [];

             $this->handleEmploiChange($this->emploiID);
         }else{
            $this->emploiID = $this->emploiID;
            $this->handleEmploiChange($this->emploiID);
         }

    }

    public function handleEmploiChange($main_emploi_id)
    {
        $this->emploiID = $main_emploi_id;

        $this->allSeances = Sission::where('user_id', Auth::id())
            ->where('main_emploi_id', $this->emploiID)
            ->get();


        // dd( $this->allSeances);
        // Check if a request exists for the user and employment ID
        $this->existingRequest = RequestEmploi::where('user_id', Auth::id())
            ->where('main_emploi_id', $main_emploi_id)
            ->exists();
    }

    // NEWADD
    public $isCaseEmpty = true;

    public function updateCaseStatus($isEmpty, $variable)
    {
        $this->isSessionUpdated = false;

        $this->isCaseEmpty = $isEmpty;
        $this->receivedVariable = $variable . Auth::id();
        $idcase = $this->receivedVariable;
            $day = substr($idcase, 0, 3);
            $day_part = substr($idcase, 3, 5);
            $user_id = Auth::id();
            $dure_sission = substr($idcase, 8, 3);
            $this->seanceFirst = Sission::select('status_sission')
            ->where('main_emploi_id', $this->emploiID)
            ->where('user_id', Auth::id())
            ->where('day', $day)
            ->where('day_part', $day_part)
            ->where('dure_sission', $dure_sission)
            ->get();
        $this->formateurId = Auth::id();
        $this->brancheId = null;
        $this->formateur = null;
        $this->selectedYear = null;
        $this->salle = null;
        $this->module = null;
        $this->salleclassTyp = null;
        $this->TypeSesion = null;
    }

    public function DeleteSession()
{
    try{
        $idcase = $this->receivedVariable;
        $day = substr($idcase, 0, 3);
        $day_part = substr($idcase, 3, 5);
        $user_id = substr($idcase, 11);
        $dure_sission = substr($idcase,8,3);
        $requestEmploiId = RequestEmploi::where('user_id', $user_id)
        ->where('main_emploi_id', $this->emploiID)
        ->value('id');

        if (!$requestEmploiId) {
            $this->alert('error', 'Tu dois créer une demande d\'emploi pour cet emploi d\'abord.');
        }else{
            sission::where([
                'main_emploi_id' => $this->emploiID,
                'day' => $day,
                'day_part' => $day_part,
                'user_id' => $user_id,
                'dure_sission' => $dure_sission
            ])->delete();
            $this->mount();
            $this->alert('success', 'vous avez supprimer une séance');
        }
    } catch (\Exception $e) {
        $this->alert('error', 'il y a un problème', [
            'position' => 'center',
            'timer' => 3000,
            'toast' => true,
        ]);
    }
}


    // Method to update selected type emploi group or formateur
    public function updateSelectedType($value)
    {
        $this->selectedType = $value;
    }
    // Method to update selected id emploi

    public function findSeance()
    {
        $idcase = $this->receivedVariable;
        $day = substr($idcase, 0, 3);
        $day_part = substr($idcase, 3, 5);
        $user_id = Auth::id();
        $dure_sission = substr($idcase, 8, 3);

        $seance = null;

            $seance = sission::where([
                'main_emploi_id' => $this->emploiID,
                'day' => $day,
                'day_part' => $day_part,
                'user_id' => $user_id,
                'dure_sission' => $dure_sission
            ])->get();

        return $seance ?: collect(); // Return an empty collection if $seance is null
    }
    public function createRequestEmploi()
    {
        // Validate the incoming request data
        $this->validate([
            'comment' => 'nullable|string',
        ]);

        // Retrieve the validated comment from the request data
        $comment = $this->comment;
        $type = 'emploi';
        $MainUser = User::where('role', 'admin')->first();

        if ($this->existingRequest) {
            // If a request already exists, inform the user and abort
            session()->flash('error', 'A request for this emploi already exists.');
            // Notification::send($MainUser, new RequestEmploiNotification($type,$this->existingRequest->id, Auth::user()->user_name,$this->emploiID, $comment,''));
        } else {
            // If no request exists, create a new one
            $requestEmploi = new RequestEmploi([
                'date_request' => now(),
                'comment' => $comment,
                'user_id' => Auth::id(),
                'main_emploi_id' => $this->emploiID,
            ]);
            $requestEmploi->save();

            // Flash success message to the session
            session()->flash('success', 'Request emploi created successfully.');

            // Show an alert to the user
            $this->dispatchBrowserEvent('modal-hidden');
            Notification::send($MainUser, new RequestEmploiNotification($type,$requestEmploi->id, Auth::user()->user_name,$this->emploiID, $comment,''));
        }
        $this->mount();
    }
    public function UpdateSession()
    {
        if ($this->isSessionUpdated) {
            return;
        }

        // Set the flag to true to prevent re-execution
        $this->isSessionUpdated = true;
        try {
            $idcase = $this->receivedVariable;
            $day = substr($idcase, 0, 3);
            $day_part = substr($idcase, 3, 5);
            $dure_sission = substr($idcase, 8, 3);
            $user_id = Auth::id();
            $requestEmploiId = RequestEmploi::where('user_id', $user_id)
                ->where('main_emploi_id', $this->emploiID)
                ->value('id');

            if (!$requestEmploiId) {
                $this->alert('error', 'Tu dois créer une demande d\'emploi pour cet emploi d\'abord.');
                return;
            }

            if ($this->TypeSesion === null) {
                $this->alert('error', 'Vous devriez sélectionner le type de cette séance.', [
                    'position' => 'center',
                    'timer' => 3000,
                    'toast' => true,
                ]);
                return;
            }

            if (empty($this->selectedGroups)) {
                $this->alert('error', 'Vous devriez sélectionner le Groupe de cette séance.', [
                    'position' => 'center',
                    'timer' => 3000,
                    'toast' => true,
                ]);
                return;
            }

            $session = Sission::where([
                'main_emploi_id' => $this->emploiID,
                'day' => $day,
                'day_part' => $day_part,
                'user_id' => $user_id,
                'dure_sission' => $dure_sission,
            ])->get();

            if ($session->isNotEmpty()) {
                if ($this->TypeSesion === 'teams') {

                    foreach ($session as $item) {
                        if ($this->module !== null) {
                            $item->update(['module_id' => $this->module]);
                        }

                        if (!empty($this->selectedGroups)) {
                            foreach ($this->selectedGroups as $group) {
                                $item->update(['group_id' => $group]);
                            }
                            $this->alert('success', 'Vous modifiez le Groupe de cette séance.', [
                                'position' => 'center',
                                'timer' => 3000,
                                'toast' => true,
                            ]);
                        }

                            $item->update(['class_room_id' => $this->salle]);
                            $this->alert('success', 'Vous modifiez la salle de cette séance.', [
                                'position' => 'center',
                                'timer' => 3000,
                                'toast' => true,
                            ]);
                        if ($this->TypeSesion !== null) {
                            $item->update(['sission_type' => $this->TypeSesion]);
                            $this->alert('success', 'Vous modifiez le type de cette séance.', [
                                'position' => 'center',
                                'timer' => 3000,
                                'toast' => true,
                            ]);
                        }

                        if ($this->salleclassTyp !== null) {
                            $item->update(['typeSalle' => $this->salleclassTyp]);
                            $this->alert('success', 'Vous modifiez le type de Salle.', [
                                'position' => 'center',
                                'timer' => 3000,
                                'toast' => true,
                            ]);
                        }
                    }
                }elseif(!empty($this->salle)){
                    foreach ($session as $item) {
                        if ($this->module !== null) {
                            $item->update(['module_id' => $this->module]);
                        }

                        if (!empty($this->selectedGroups)) {
                            foreach ($this->selectedGroups as $group) {
                                $item->update(['group_id' => $group]);
                            }
                            $this->alert('success', 'Vous modifiez le Groupe de cette séance.', [
                                'position' => 'center',
                                'timer' => 3000,
                                'toast' => true,
                            ]);
                        }

                    if ($this->salle !== null) {

                            $item->update(['class_room_id' => $this->salle]);
                            $this->alert('success', 'Vous modifiez la salle de cette séance.', [
                                'position' => 'center',
                                'timer' => 3000,
                                'toast' => true,
                            ]);
                        }
                        if ($this->TypeSesion !== null) {
                            $item->update(['sission_type' => $this->TypeSesion]);
                            $this->alert('success', 'Vous modifiez le type de cette séance.', [
                                'position' => 'center',
                                'timer' => 3000,
                                'toast' => true,
                            ]);
                        }

                        if ($this->salleclassTyp !== null) {
                            $item->update(['typeSalle' => $this->salleclassTyp]);
                            $this->alert('success', 'Vous modifiez le type de Salle.', [
                                'position' => 'center',
                                'timer' => 3000,
                                'toast' => true,
                            ]);
                        }
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
                            'main_emploi_id' => $this->emploiID,
                            "demand_emploi_id" => null,
                            'typeSalle' => $this->salleclassTyp,
                            'message' => null,
                            'sission_type' => $this->TypeSesion,
                            'status_sission' => 'Pending',
                        ]);
                    }

                    $this->mount();
                    $this->alert('success', 'Vous créez une nouvelle session', [
                        'position' => 'center',
                        'timer' => 3000,
                        'toast' => true,
                    ]);
                    $this->selectedGroups = [];
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
                                'main_emploi_id' => $this->emploiID,
                                "demand_emploi_id" => null,
                                'typeSalle' => $this->salleclassTyp,
                                'message' => null,
                                'sission_type' => $this->TypeSesion,
                                'status_sission' => 'Pending',
                            ]);
                        }

                        $this->mount();
                        $this->alert('success', 'Vous créez une nouvelle session', [
                            'position' => 'center',
                            'timer' => 3000,
                            'toast' => true,
                        ]);
                        $this->selectedGroups = [];
                }elseif(empty($this->salle)){
                    $this->alert('error', 'Vous devriez sélectionner la salle.', [
                        'position' => 'center',
                        'timer' => 3000,
                        'toast' => true,
                    ]);
                    return;
                }
            }

            $comment = '';
            $type = 'seance';
            $MainUser = User::where('role', 'admin')->first();
            Notification::send($MainUser, new RequestEmploiNotification($type, $requestEmploiId, Auth::user()->user_name, $this->emploiID, $comment, ''));

            $this->mount();
            $this->emit('fresh');
        } catch (\Illuminate\Database\QueryException $e) {
            $error_message = $e->errorInfo[2];
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
                $this->alert('error', $error_message, [
                    'position' => 'center',
                    'timer' => 3000,
                    'toast' => true,
                ]);
                return redirect()->back()->withErrors(['insertion_error' => $error_message]);
            }
        }
    }



    public function render()
    {$this->mainEmplois = main_emploi::all();

        $this->daysOfWeek = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
        $this->daysPart = ["Matin", "Amidi"];
        $this->seancesPart = ["SE1", "SE2", "SE3", "SE4"];
        $this->tableEmploi = EmploiStrictureModel::where('user_id', Auth::user()->id)->get();

        $establishment_id = session()->get('establishment_id');
        $this->yearFilter = DB::table('groups')
            ->where('establishment_id', $establishment_id)
            ->select('year')
            ->distinct()
            ->pluck('year');

        $MainUser = User::where('role', 'admin')->first();

        // branches
        $this->baranches = DB::table('branches')
            ->select('branches.*')
            ->join('formateur_has_filier', 'formateur_has_filier.barnch_id', '=', 'branches.id')
            ->where('formateur_has_filier.formateur_id', Auth::id())
            ->get();
        // groupes
        $groupsQuery = group::join('formateur_has_groups as f', 'f.group_id', '=', 'groups.id')
            ->where('groups.establishment_id', $establishment_id)
            ->where('f.formateur_id', Auth::id())
            ->select('groups.id', 'groups.group_name'); // Select ID along with group_name

        // Check if $this->brancheId is set and add the condition if it is
        if ($this->brancheId !== 'Filiére' && $this->brancheId) {
            $groupsQuery->where('groups.barnch_id', $this->brancheId);
        }
        if ($this->selectedYear !== 'année' && $this->selectedYear) {
            $groupsQuery->where('groups.year', "{$this->selectedYear}");
        }

        $this->groupes = $groupsQuery->get();
        // data for  model form

        $this->classType = class_room_type::where('establishment_id', $establishment_id)->get();
        // $this->modules = module::where('establishment_id', $establishment_id)->get();
        $salles = class_room::where('id_establishment', $establishment_id)->get();
        $this->modules = Module::join('module_has_formateur as MHF', 'MHF.module_id', '=', 'modules.id')
            ->join('groupe_has_modules as GHM', 'GHM.module_id', '=', 'modules.id')
            ->where('modules.establishment_id', $establishment_id)
            ->where('MHF.formateur_id', Auth::id())
            ->whereIn('GHM.group_id', $this->selectedGroups)
            ->select('modules.*')
            ->get();

            $sessions = DB::table('sissions')
            ->select('sissions.*', 'modules.id as module_name', 'groups.group_name', 'users.user_name', 'class_rooms.class_name')
            ->leftJoin('modules', 'modules.id', '=', 'sissions.module_id')
            ->join('groups', 'groups.id', '=', 'sissions.group_id')
            ->join('users', 'users.id', '=', 'sissions.user_id')
            ->join('class_rooms', 'class_rooms.id', '=', 'sissions.class_room_id')
            ->where('sissions.establishment_id', $establishment_id)
            ->where('sissions.status_sission', 'Accepted')
            ->where('sissions.main_emploi_id', session()->get('id_main_emploi'))
            ->get();

        $groupsToRemove = [];
        $salleShouldRemove = [];

        foreach ($sessions as $session) {
            $combinedValue = $session->day . $session->day_part . $session->dure_sission;
            if ($combinedValue === substr($this->receivedVariable, 0, 11)) {
                $groupsToRemove[] = $session->group_id;
                $salleShouldRemove[] = $session->class_room_id;
            }
        }

        $newSalles = $salles->reject(function ($salle) use ($salleShouldRemove) {
            return in_array($salle->id, $salleShouldRemove);
        });

        $newGroups = [];
        foreach ($this->groupes as $group) {
            if (!in_array($group->id, $groupsToRemove)) {
                $newGroups[] = $group;
            }
        }

        $this->groupes = $this->groupes->reject(function ($groupe) use ($groupsToRemove) {
            return in_array($groupe->id, $groupsToRemove);
        });

        $this->groups = $newGroups;
        $this->sissions = $sessions;
        $this->salles = $newSalles;

        $this->checkValues = Setting::where('userId', $MainUser->id)->get();


        // Render view
        $existingRequests = $this->existingRequest;
        return view('livewire.formateur-requests', [
            'existingRequest' => $existingRequests,
        ]);    }
}
