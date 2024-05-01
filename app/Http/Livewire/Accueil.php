<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB ;
use App\Models\sission ;
use App\Models\main_emploi ;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use App\Models\formateur ;
use Jantinnerezo\LivewireAlert\LivewireAlert;


class Accueil extends Component
{
    use LivewireAlert;
    public  $selectedValue ;
    public $Main_emplois;
    public $dateStart;
    public $successMessage;
    public $formateurs = [];





    public function SelectedIDEmploi($id){
        $this->selectedValue = $id ;
    }




    public function render()
    {
        $establishment_id = session()->get('establishment_id');
        $this->formateurs = formateur::select('user_name', 'status', 'id')
    ->where('establishment_id', $establishment_id)
    ->where('role' , 'formateur')
    ->limit(3)
    ->get(); 

        $this->Main_emplois = DB::table('main_emploi')
            ->where('establishment_id', $establishment_id) ->orderBy('datestart', 'desc')->get();
        return view('livewire.accueil');
    }
}
