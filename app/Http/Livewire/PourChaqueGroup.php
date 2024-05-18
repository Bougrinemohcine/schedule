<?php

namespace App\Http\Livewire;

use Livewire\Component;
// use livewire\Attribute\on;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\group;
use App\Models\module;
use App\Models\class_room;
use App\Models\class_room_type;
use App\Models\Setting;
use App\Models\sission ;
use Illuminate\Support\Facades\Auth;
use App\Models\formateur_has_group;
use App\Models\User;
use App\Models\branch;
use App\Models\formateur_has_branche;
use App\Models\EmploiStrictureModel;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class PourChaqueGroup extends Component
{
    use LivewireAlert;
    public $modulee;
    public $module;
    public $salleclassTyp;
    public $TypeSesion;
    public $group;

    public $salle ;
    public $salleClasstyp;
    public $dure ;
    public $dayPart;
    public $TypeSession;
    public $selectedOption;

    public $formateurId;
    public $modules;
    public $groups;
    public $sissions;
    public $formateurs = [];
    public $classType ;
    public $salles ;
    public $checkValues;
    public $receivedVariable;
    public $groupID;
    public $moduleID ;
    public $baranches = [] ;
    public $dataEmploi ;
    public $tableEmploi ;

    public $isCaseEmpty = true;
    public function updateCaseStatus($isEmpty)
    {
        $this->isCaseEmpty = $isEmpty;
    }




    protected $listeners = ['receiveVariable' => 'receiveVariable'];

    public function receiveVariable($variable)
    {
        $this->receivedVariable = $variable;
    }

    public function DeleteSession()
    {
        $idcase = $this->receivedVariable;
        // dd($idcase);
        $day = substr($idcase, 0, 3);
        $day_part = substr($idcase, 3, 5);
        $dure_sission = substr($idcase,8,3);

      sission::where([
        'main_emploi_id' => session()->get('id_main_emploi'),
         'day' => $day,
         'day_part' => $day_part,
         'group_id' => $this->groupID,
         'dure_sission' => $dure_sission
     ])->delete();


    }




    public function deleteAllSessions(){

        DB::table('sissions')
        ->where('establishment_id', session()->get('establishment_id'))
        ->where('main_emploi_id', session()->get('id_main_emploi'))
        ->where('group_id' , $this->groupID)
        ->delete();



        $this->Alert('success', "Vous supprimez toutes les séances.", [
            'position' => 'center',
            'timer' => 12000,
            'toast' => false,
            'width' =>650,
           ]);

        return redirect()->back();

    }

    public function UpdateSession()
    {
        try {
            $idcase = $this->receivedVariable;
            $day = substr($idcase, 0, 3);
            $day_part = substr($idcase, 3, 5);
            $dure_sission = substr($idcase, 8, 3);

            $session = Sission::where([
                'main_emploi_id' => session()->get('id_main_emploi'),
                'day' => $day,
                'day_part' => $day_part,
                'group_id' => $this->groupID,
                'dure_sission' => $dure_sission,
            ])->get();

            if ($session->isNotEmpty()) {
                if($this->TypeSesion === 'teams'){
                    foreach ($session as $item) {
                        if ($this->moduleID !== null) {
                            $item->update(['module_id' => $this->moduleID]);
                            $this->alert('success', 'Vous modifiez le module de cette séance.',[
                                                'position' => 'center',
                                                'timer' => 3000,
                                                'toast' => true,]);
                        }

                        if ($this->formateurId !== null ) {

                                $item->update(['user_id' => $this->formateurId]);
                                $this->alert('success', 'Vous modifiez le Formateur de cette séance.',[
                                    'position' => 'center',
                                    'timer' => 3000,
                                    'toast' => true,]);

                        }

                            $item->update(['class_room_id' => $this->salle]);
                            $this->alert('success', 'Vous modifiez la salle de cette séance.',[
                                'position' => 'center',
                                'timer' => 3000,
                                'toast' => true,]);
                        if ($this->TypeSesion !== null) {
                            $item->update(['sission_type' => $this->TypeSesion]);
                            $this->alert('success', 'Vous modifiez le type de cette séance.',[
                                'position' => 'center',
                                'timer' => 3000,
                                'toast' => true,]);
                        }
                        if ($this->salleclassTyp !== null) {
                            $item->update(['typeSalle'=> $this->salleclassTyp]);
                            $this->alert('success', 'Vous modifiez le type de Salle.',[
                                'position' => 'center',
                                'timer' => 3000,
                                'toast' => true,]);
                        }
                    }
                }elseif(!empty($this->salle)){
                    foreach ($session as $item) {
                        if ($this->moduleID !== null) {
                            $item->update(['module_id' => $this->moduleID]);
                            $this->alert('success', 'Vous modifiez le module de cette séance.',[
                                                'position' => 'center',
                                                'timer' => 3000,
                                                'toast' => true,]);
                        }

                        if ($this->formateurId !== null ) {

                                $item->update(['user_id' => $this->formateurId]);
                                $this->alert('success', 'Vous modifiez le Formateur de cette séance.',[
                                    'position' => 'center',
                                    'timer' => 3000,
                                    'toast' => true,]);

                        }
                        if ($this->salle !== null) {
                            $item->update(['class_room_id' => $this->salle]);
                            $this->alert('success', 'Vous modifiez la salle de cette séance.',[
                                'position' => 'center',
                                'timer' => 3000,
                                'toast' => true,]);
                        }
                        if ($this->TypeSesion !== null) {
                            $item->update(['sission_type' => $this->TypeSesion]);
                            $this->alert('success', 'Vous modifiez le type de cette séance.',[
                                'position' => 'center',
                                'timer' => 3000,
                                'toast' => true,]);
                        }
                        if ($this->salleclassTyp !== null) {
                            $item->update(['typeSalle'=> $this->salleclassTyp]);
                            $this->alert('success', 'Vous modifiez le type de Salle.',[
                                'position' => 'center',
                                'timer' => 3000,
                                'toast' => true,]);
                        }
                    }
                }elseif(empty($this->salle)){
                    $this->alert('error', 'Vous devriez sélectionner la salle.', [
                        'position' => 'center',
                        'timer' => 3000,
                        'toast' => true,
                    ]);
                    return;
                }
            } else {
                if($this->TypeSesion === 'teams'){
                    $session =   Sission::create([
                            'day' => $day,
                            'day_part' => $day_part,
                            'dure_sission' => $dure_sission,
                            'module_id' => $this->moduleID,
                            'group_id' => $this->groupID,
                            'establishment_id' => session()->get('establishment_id'),
                            'user_id' => $this->formateurId,
                            'class_room_id' => $this->salle,
                            'validate_date' => null,
                            'main_emploi_id' => session()->get('id_main_emploi'),
                            "demand_emploi_id" => null,
                            'message' => null,
                            'typeSalle'=>$this->salleclassTyp ,
                            'sission_type' => $this->TypeSesion,
                            'status_sission' => 'Accepted',
                        ]);
                        if (!$session) {
                            $this->alert('error', 'Session creation failed for group ID: $group', [
                                'position' => 'center',
                                'timer' => 3000,
                                'toast' => true,
                            ]);
                            }
                        $this->alert('success', 'Vous créez une nouvelle session', [
                            'position' => 'center',
                            'timer' => 3000,
                            'toast' => true,
                        ]);
                }elseif(!empty($this->salle)){
                    $session =   Sission::create([
                        'day' => $day,
                        'day_part' => $day_part,
                        'dure_sission' => $dure_sission,
                        'module_id' => $this->moduleID,
                        'group_id' => $this->groupID,
                        'establishment_id' => session()->get('establishment_id'),
                        'user_id' => $this->formateurId,
                        'class_room_id' => $this->salle,
                        'validate_date' => null,
                        'main_emploi_id' => session()->get('id_main_emploi'),
                        "demand_emploi_id" => null,
                        'message' => null,
                        'typeSalle'=>$this->salleclassTyp ,
                        'sission_type' => $this->TypeSesion,
                        'status_sission' => 'Accepted',
                    ]);
                    if (!$session) {
                        $this->alert('error', 'Session creation failed for group ID: $group', [
                            'position' => 'center',
                            'timer' => 3000,
                            'toast' => true,
                        ]);
                        }
                    $this->alert('success', 'Vous créez une nouvelle session', [
                        'position' => 'center',
                        'timer' => 3000,
                        'toast' => true,
                    ]);
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
                    // } elseif (strpos($e->getMessage(), "Column 'class_room_id' cannot be null") !== false) {
                    //     $this->alert('error', 'Vous devriez sélectionner la salle.', [
                    //         'position' => 'center',
                    //         'timer' => 3000,
                    //         'toast' => true,
                    //     ]);
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







        public function render()
        {
            $this->dataEmploi =DB::table('main_emploi')
            ->where('id', session()->get('id_main_emploi'))->get();

            $this->tableEmploi = EmploiStrictureModel::where('user_id', Auth::user()->id)->get();
            // dd($this->tableEmploi);
            $establishment_id = session()->get('establishment_id');
            $this->groups = group::where('establishment_id', $establishment_id)->get();
            $this->checkValues = Setting::select('typeSession','modeRamadan','branch','module','formateur','salle','typeSalle')
                ->where('userId', Auth::id())->get();

            if ($this->groupID) {
                // Load all formateurs for the selected group
                $formateurs = user::join('formateur_has_groups as FHG', 'FHG.formateur_id', '=', 'users.id')
                    ->where('FHG.group_id', $this->groupID)
                    ->select('users.*')
                    ->get();


                // Load modules for the selected group and formateur
                $this->modules = Module::join('module_has_formateur as MHF', 'MHF.module_id', '=', 'modules.id')
                    ->join('groupe_has_modules as GHM', 'GHM.module_id', '=', 'modules.id')
                    ->where('modules.establishment_id', $establishment_id)
                    ->where('MHF.formateur_id', $this->formateurId)
                    ->select('modules.*')
                    ->distinct()
                    ->get();

                    // Fetch all sessions for the selected group
                    $sessions = DB::table('sissions')
                    ->select('sissions.*', 'modules.id as module_name', 'groups.group_name', 'users.*', 'class_rooms.class_name')
                    ->leftJoin('modules', 'modules.id', '=', 'sissions.module_id')
                    ->join('groups', 'groups.id', '=', 'sissions.group_id')
                    ->join('users', 'users.id', '=', 'sissions.user_id')
                    ->leftJoin('class_rooms', 'class_rooms.id', '=', 'sissions.class_room_id')
                    ->where('sissions.establishment_id', $establishment_id)
                    ->where('sissions.status_sission', 'Accepted')
                    ->where('sissions.main_emploi_id', session()->get('id_main_emploi'))
                    ->orderBy('sissions.day') // Order by day
                    ->orderBy('sissions.dure_sission')
                    ->get();
                    // if($sessions){
                    //     dd($sessions);
                    // }

                    // Load class room types and available rooms for the establishment
                    $this->classType = class_room_type::where('establishment_id', $establishment_id)->get();
                    $salles = class_room::where('id_establishment', $establishment_id)->get();

                    // Prepare an array of room IDs that should be removed based on session criteria
                    $salleShouldRemove = [];
                    $formateurShouldRemove = [];
                    foreach ($sessions as $session) {
                    $combinedValue = $session->day . $session->day_part . $session->dure_sission;

                    if ($combinedValue === substr($this->receivedVariable, 0, 11)) {
                        $salleShouldRemove[] = $session->class_room_id;
                        $formateurShouldRemove[] = $session->user_id ;
                    }
                    }

                    // Filter the available rooms to exclude those that should be removed
                    $newSalles = $salles->reject(function ($salle) use ($salleShouldRemove) {
                        return in_array($salle->id, $salleShouldRemove);
                    });
                    $newFormateur =$formateurs->reject(function($formateur) use ($formateurShouldRemove){
                        return in_array($formateur->id , $formateurShouldRemove);
                    });
                    // Assign the filtered rooms to the component property
                    $this->formateurs = $newFormateur;
                    $this->salles = $newSalles;
                    $this->sissions = $sessions->where('group_id' , $this->groupID);

            } else {
                // If no group is selected, reset data
                $this->modules = [];
                $this->formateurs = [];
                $this->salles = [];
                $this->classType = [];
                $this->sissions = [];
            }

            return view('livewire.pour-chaque-group');
        }

        public function AddAutherEmploi(){
            Session::forget('id_main_emploi');
            Session::forget('datestart');
            $this->Alert('success','Maintenant, vous pouvez créer un autre emploi du temps en
            sélectionnant simplement la date de début.', [
                'position' => 'center',
                'timer' => 12000,
                'toast' => false,
                'width' =>650,
               ]);
            return redirect()->route('CreateEmploi');

        }

}
