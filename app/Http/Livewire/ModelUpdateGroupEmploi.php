<?php
// ModelUpdateGroupEmploi.php

namespace App\Http\Livewire;

use App\Models\group;
use Livewire\Component;
use App\Models\sission;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ModelUpdateGroupEmploi extends Component
{
    use LivewireAlert;
    public $modules;
    public $formateurs;
    public $salles;
    public $classType;
    public $formateur;
    public $salle;
    public $TypeSesion;
    public $module;
    public $salleclassTyp;
    public $sissions;
    public $idCase;
    public $receivedVariable;
    public $FormateurOrgroup;

    protected $listeners = ['receiveVariable' => 'receiveVariable','receiveidEmploiid'=>'receiveidEmploiid', 'fresh'=>'$refresh'];

           // receive  id case
           public function receiveVariable($variable)
           {
            //    dd($variable);
               // session(['idCase'=>$variable]);
               $this->receivedVariable = $variable;
           }

    public function receiveidEmploiid($variable){
            // $receivedValue = $variable;
            session(['idEmploiSelected' => $variable]);
    }


      public function UpdateSession()
    {
        // dd($this);
         $idcase = $this->receivedVariable;
        // $idcase =  session('idCase');
        try{

            dd($idcase);
            $day = substr( $idcase , 0, 3);
            $day_part = substr( $idcase, 3, 5);
            // if($FormateurOrgroup==='Group'){
                $group_id = substr($idcase, 10);
            // }

            // dd($group_id);
            $dure_sission = substr($idcase, 8, 2);
            $session = sission::where([
                'main_emploi_id' => session()->get('idEmploiSelected'),
                'day' => $day,
                'day_part' => $day_part,
                'group_id' => $group_id,
                'dure_sission' => $dure_sission,
            ])->first();
            // dd($session);
            if($session){
                    $session->day = $day;
                    $session->day_part = $day_part;
                    $session->group_id = $group_id || $this->group;
                    $session->dure_sission = $dure_sission;
                    $session->module_id = $this->module;
                    $session->establishment_id = session()->get('establishment_id');
                    $session->user_id = $this->formateur;
                    $session->class_room_id = $this->salle;
                    $session->main_emploi_id = session()->get('idEmploiSelected');
                    $session->demand_emploi_id = null;
                    $session->message = null;
                    $session->sission_type = $this->TypeSesion;
                    $session->status_sission = null;
                    $session->validate_date = null;
                    $session->save(); //
                    $this->emit('fresh');
            }else{
                // dd(substr($idcase,3,5));
                // $idcase =  session()->get('idCase');
                 sission::create([
                    'day'=>substr($idcase,0,3),
                    'day_part'=>substr($idcase,3,5),
                    'dure_sission'=>substr($idcase,8,2),
                    'module_id'=>$this->module,
                    'group_id'=>substr($idcase,10),
                    'establishment_id'=>session()->get('establishment_id'),
                    'user_id'=>$this->formateur,
                    'class_room_id'=>$this->salle,
                    'validate_date'=>null,
                    'main_emploi_id'=>session()->get('idEmploiSelected'),
                    "demand_emploi_id"=>null,
                    'message'=>null,
                    'sission_type'=>$this->TypeSesion,
                    'status_sission'=>null,]);
            }
                    // dd($session);
        }catch(\Exception $e){
            dd( $e->getMessage());

        }
            // $this->alert("error", "Vous avez supprimé la seance .", [
            //     'position' => 'center',
            //     'timer' => 1600,
            //     'toast' => false,
            //     'width' =>650,
            //    ]);


    }
    public function DeleteSession()
    {

        // $idcase =  session()->get('idCase');
        $idcase = $this->receivedVariable;
            $day = substr( $idcase , 0, 3);
            $day_part = substr( $idcase, 3, 5);
            $group_id = substr($idcase, 10);
            $dure_sission = substr($idcase, 8, 2);
         sission::where([
            'main_emploi_id' => Session::get('idEmploiSelected'),
            'day' => $day,
            'day_part' => $day_part,
            'group_id' => $group_id,
            'dure_sission' => $dure_sission
        ])->delete();
        return redirect()->route('toutlesEmploi');
    }

    public function render()
    {
        $establishment_id = session()->get('establishment_id');
        $groups = group::where('establishment_id', $establishment_id)->get();
        return view('livewire.model-update-group-emploi',['groups'=>$groups]);
    }
}






