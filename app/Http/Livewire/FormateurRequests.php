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
use Illuminate\Support\Facades\Auth;
use function PHPUnit\Framework\isEmpty;
use Illuminate\Support\Facades\Notification;

use Illuminate\Support\Facades\Session;
use Jantinnerezo\LivewireAlert\LivewireAlert;
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
    public $selectedGroups;
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


    protected $listeners = [
        'receiveidEmploiid' => 'receiveidEmploiid',
        'fresh' => '$refresh'
    ];

    public function mount()
    {
         // Retrieve main emploi ID from the request data
         $this->emploiID = main_emploi::latest()->value('id');

         // Fetch all main emplois

         // Fetch initial seances data
         $this->handleEmploiChange($this->emploiID);

    }

    public function handleEmploiChange($main_emploi_id)
    {
        $this->emploiID = $main_emploi_id;

        $this->allSeances = Sission::where('user_id', Auth::id())
            ->where('main_emploi_id', $this->emploiID)
            ->get();


        // Check if a request exists for the user and employment ID
        $this->existingRequest = RequestEmploi::where('user_id', Auth::id())
            ->where('main_emploi_id', $main_emploi_id)
            ->exists();
    }

    // NEWADD
    public $isCaseEmpty = true;

    public function updateCaseStatus($isEmpty, $variable)
    {
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
        $this->selectedGroups = [];
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
        try {
            $idcase = $this->receivedVariable;
            $day = substr($idcase, 0, 3);
            $day_part = substr($idcase, 3, 5);
            $user_id = Auth::id();
            $dure_sission = substr($idcase, 8, 3);
            $requestEmploiId = RequestEmploi::where('user_id', $user_id)
            ->where('main_emploi_id', $this->emploiID)
            ->value('id');
            if (!$requestEmploiId) {
                $this->alert('error', 'Tu dois créer une demande d\'emploi pour cet emploi d\'abord.');
            }else{

                $sessionData = [
                    'day' => $day,
                    'day_part' => $day_part,
                    'dure_sission' => $dure_sission,
                    'module_id' => $this->module,
                    'establishment_id' => session()->get('establishment_id'),
                    'class_room_id' => $this->salle,
                    'main_emploi_id' => $this->emploiID,
                    'demand_emploi_id' => null,
                    'message' => null,
                    'typeSalle'=>$this->salleclassTyp,
                    'sission_type' => $this->TypeSesion,
                    'status_sission' => 'Pending',
                ];
                $sessionData['group_id'] = $this->group;
                $sessionData['user_id'] = $user_id;
                $session = sission::where([
                    'main_emploi_id' => $this->emploiID,
                    'day' => $day,
                    'day_part' => $day_part,
                    'user_id' => $user_id,
                    'dure_sission' => $dure_sission,
                ])->first();

            if ($session) {
                $session->update($sessionData);
            } else {
                sission::create($sessionData);
                // $MainUser = User::where('role', 'admin')->first();
                // $comment = $sessionData['message'];
                // $mainEmploiId = $sessionData['main_emploi_id'];
                // $type = 'seance';
                // $FormateurRequest = Auth::user()->user_name;
                // Notification::send($MainUser, new RequestEmploiNotification($type, $session->id, $FormateurRequest, $mainEmploiId, $comment, $session->status_sission));
            }
            $this->mount();
            $this->alert('success', 'vous avez crée une séance');
            }
            // dd($sessionData);

        } catch (\Exception $e) {
            $this->alert('error', 'il y a un problème', [
                'position' => 'center',
                'timer' => 3000,
                'toast' => true,
            ]);
        }
    }


    public function render()
    {

        $this->mainEmplois = main_emploi::all();

         // Define lists of days of week, days part, and seances part
         $this->daysOfWeek = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
         $this->daysPart = ["Matin", "Amidi"];
         $this->seancesPart = ["SE1", "SE2", "SE3", "SE4"];

        // Initialize variables
        $establishment_id = session()->get('establishment_id');
        $this->yearFilter = DB::table('groups')
            ->where('establishment_id', $establishment_id)
            ->select('year')
            ->distinct()
            ->pluck('year');

        $MainUser = User::where('role', 'admin')->first();


            $this->checkValues = Setting::select('typeSession', 'branch', 'year', 'module', 'formateur', 'salle', 'typeSalle')
            ->where('userId', $MainUser->id)
            ->get();



        // Fetch data from branches table
        $this->baranches = DB::table('branches')
            ->select('branches.*')
            ->join('formateur_has_filier', 'formateur_has_filier.barnch_id', '=', 'branches.id')
            ->where('formateur_has_filier.formateur_id', Auth::id())
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

            $this->modules = Module::join('module_has_formateur as MHF', 'MHF.module_id', '=', 'modules.id')
                ->join('groupe_has_modules as GHM', 'GHM.module_id', '=', 'modules.id')
                ->where('modules.establishment_id', $establishment_id)
                ->where('MHF.formateur_id', Auth::id())
                ->where('GHM.group_id', $this->group)
                ->select('modules.*')
                ->get();


        // Fetch class rooms data
        $this->salles = Class_room::where('id_establishment', $establishment_id)->get();
        $this->classType = Class_room_type::where('establishment_id', $establishment_id)->get();

        // Fetch sissions data
        $sissions = DB::table('sissions')
    ->select('sissions.*', 'modules.id as module_name', 'groups.group_name', 'users.*', 'class_rooms.class_name')
    ->leftJoin('modules', 'modules.id', '=', 'sissions.module_id')
    ->join('groups', 'groups.id', '=', 'sissions.group_id')
    ->join('users', 'users.id', '=', 'sissions.user_id')
    ->join('class_rooms', 'class_rooms.id', '=', 'sissions.class_room_id')
    ->where('sissions.establishment_id', $establishment_id)
    ->where('sissions.main_emploi_id', $this->emploiID)
    ->get();
;

        // Fetch groups data
        $groupsQuery = group::join('formateur_has_groups as f', 'f.group_id', '=', 'groups.id')
            ->where('groups.establishment_id', $establishment_id)
            ->where('f.formateur_id', Auth::id())
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
        $allseances = sission::where('main_emploi_id', $this->emploiID)->get();

        $seance = $this->findSeance()->first();
        // Render view
        $existingRequests = $this->existingRequest;
        return view('livewire.formateur-requests', [
            'existingRequest' => $existingRequests,
        ]);    }
}
