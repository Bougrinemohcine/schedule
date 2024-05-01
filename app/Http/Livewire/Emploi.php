<?php

namespace App\Http\Livewire;

use Livewire\Component;
use App\Models\sission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\group;
use App\Models\module;
use App\Models\class_room;
use App\Models\class_room_type;
use App\Models\user;
use App\Models\formateur_has_group;
use App\Models\EmploiStrictureModel;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

use Jantinnerezo\LivewireAlert\LivewireAlert;

class Emploi extends Component
{
    use LivewireAlert;
    public $modulee;
    public $group;
    public $formateur;
    public $salle ;
    public $salleClasstyp;
    public $dure ;
    public $dayPart;
    public $TypeSession;
    public $receivedVariable;

    public $groups;
    public $modules ;
    public $formateurs ;
    public $salles;
    public $classType;
    // for catche date from  form Module
    public $salleclassTyp;
    public $sissions = [];
    public $module ;
    public $idCase;
    public $TypeSesion;
    public $checkValues ;
    public $groupID;
    public $dataEmploi ;
    public $SearchValue ;
    public $tableEmploi ;


    public $isCaseEmpty = true;
    public $isActive = true ;

    // Method to update $isCaseEmpty based on the clicked case
    public function updateCaseStatus($isEmpty , $isActivee)
    {
        $this->isCaseEmpty = $isEmpty;
        $this->isActive =  $isActivee ;
    }

    public function DeleteSession()
{
    $idcase = $this->receivedVariable;
    $day = substr($idcase, 0, 3);
    $day_part = substr($idcase, 3, 5);
    $group_id = substr($idcase, 11);
    $dure_sission = substr($idcase,8,3);


  sission::where([
    'main_emploi_id' => session()->get('id_main_emploi'),
     'day' => $day,
     'day_part' => $day_part,
     'group_id' => $group_id,
     'dure_sission' => $dure_sission
 ])->delete();


}




    protected $listeners = ['receiveVariable' => 'receiveVariable',
    'closeModal'=>'closeModal' , 'freshComponent'=>'$refresh'];
    public function receiveVariable($variable)
    {
        $this->groupID = substr($variable,11);
        $this->receivedVariable = $variable;


    }

    public function UpdateSession()
{
    try {
        $idcase = $this->receivedVariable;
        $day = substr($idcase, 0, 3);
        $day_part = substr($idcase, 3, 5);
        $group_id = substr($idcase, 11);
        $dure_sission = substr($idcase, 8, 3);

        // dd($sessionData);
            $session = sission::where([
                'main_emploi_id' => session()->get('id_main_emploi'),
                'day' => $day,
                'day_part' => $day_part,
                'group_id' => $group_id,
                'dure_sission' => $dure_sission,
            ])->first();
            $sessionData = [
                'day' => $day,
                'day_part' => $day_part ,
                'dure_sission' => $dure_sission ,
                'establishment_id' => session()->get('establishment_id'),
                'class_room_id' => $this->salle,
                'main_emploi_id' => session()->get('id_main_emploi') ,
                'demand_emploi_id' => null,
                'message' => null,
                'sission_type' => $this->TypeSesion,
                'status_sission' => 'Accepted',
                'user_id'=> $this->formateur,
                'group_id'=> $group_id
            ];

        if ($session) {
            if ($this->module !== null) {
                $session->update(['module_id'=> $this->module]);
            }

            if ($this->formateur !== null) {
                $session->update(['user_id'=> $this->formateur]);
            }
            if ($this->salle !== null) {
                $session->update(['class_room_id'=> $this->salle]);
            }
            if ($this->TypeSesion !== null) {
                $session->update(['sission_type'=> $this->TypeSesion]);
            }
        } else {

                if ($this->module !== null) {
                    $sessionData['module_id'] = $this->module;
                }
                sission::create($sessionData);
        }

        $this->emit('fresh');
    } catch (\Exception $e) {
        $this->alert('error', $e->getMessage() , [
            'position' => 'center',
            'timer' => 3000,
            'toast' => true,
        ]);


    }
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
    public function deleteAllSessions(){

        DB::table('sissions')->where('establishment_id', session()->get('establishment_id'))
        ->where('main_emploi_id', session()->get('id_main_emploi'))->delete();
        DB::table('main_emploi')->where('establishment_id', session()->get('establishment_id'))
        ->where('id', session()->get('id_main_emploi'))->delete();
        $this->Alert('success', "Vous supprimez toutes les séances.", [
            'position' => 'center',
            'timer' => 12000,
            'toast' => false,
            'width' =>650,
           ]);
        Session::forget('id_main_emploi');
        Session::forget('datestart');
        return redirect()->route('CreateEmploi');

    }
    public function render()
    {
        $this->tableEmploi = EmploiStrictureModel::where('user_id', Auth::user()->id)->get();
        $this->dataEmploi =DB::table('main_emploi')
        ->where('id', session()->get('id_main_emploi'))->get();
        // data for  model form
        $establishment_id = session()->get('establishment_id');
        $this->classType = class_room_type::where('establishment_id', $establishment_id)->get();
        $this->groups = group::where('group_name' , 'like' ,'%'.$this->SearchValue.'%')->where('establishment_id', $establishment_id)->get();
        // $this->modules = module::where('establishment_id', $establishment_id)->get();
        $salles = class_room::where('id_establishment', $establishment_id)->get();

        $this->modules =   Module::join('module_has_formateur as MHF', 'MHF.module_id', '=', 'modules.id')
        ->join('groupe_has_modules as GHM', 'GHM.module_id', '=', 'modules.id')
        ->where('modules.establishment_id', $establishment_id)
        ->where('MHF.formateur_id', $this->formateur)
        ->where('GHM.group_id', $this->groupID)
        ->select('modules.*')
        ->get();

        $formateurs =  user::select('users.*')
        ->join('formateur_has_groups as f', 'f.formateur_id', '=', 'users.id')
        ->where('users.status' , '=' , 'active')
        ->where('f.group_id', substr($this->receivedVariable,11)) // Select ID along with group_name
        ->get();

        $sissions = DB::table('sissions')
        ->select('sissions.*', 'modules.id as module_name', 'groups.group_name', 'users.user_name', 'class_rooms.class_name')
        ->leftJoin('modules', 'modules.id', '=', 'sissions.module_id')
        ->join('groups', 'groups.id', '=', 'sissions.group_id')
        ->join('users', 'users.id', '=', 'sissions.user_id')
        ->join('class_rooms', 'class_rooms.id', '=', 'sissions.class_room_id')
        ->where('sissions.establishment_id', $establishment_id)
        ->where('sissions.main_emploi_id', session()->get('id_main_emploi'))
        ->get();


        $formateurShouldRemove = [];
        $salleShouldRemove = [];

        foreach ($sissions as $session) {
            $combinedValue = $session->day . $session->day_part . $session->dure_sission;
            if ($combinedValue === substr($this->receivedVariable, 0, 11)) {
                $formateurShouldRemove[] = $session->user_id;
                $salleShouldRemove[] = $session->class_room_id;
            }
        }

        $newFormateurs = $formateurs->reject(function ($formateur) use ($formateurShouldRemove) {
            return in_array($formateur->id, $formateurShouldRemove);
        });

        $newSalles = $salles->reject(function ($salle) use ($salleShouldRemove) {
            return in_array($salle->id, $salleShouldRemove);
        });

        $this->formateurs = $newFormateurs;
        $this->sissions = $sissions;
        $this->salles = $newSalles;

        $this->checkValues = Setting::select('typeSession','modeRamadan','module',
        'formateur','branch','salle','typeSalle')
        ->where('userId', Auth::id())->get() ;
        return view('livewire.emploi');
    }



}
