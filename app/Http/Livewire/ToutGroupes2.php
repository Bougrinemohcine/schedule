<?php

namespace App\Http\Livewire;

use Livewire\Component;

class ToutGroupes2 extends Component
{
    public $groups ;
    public $sissions;
    
    public function render()
    {
        return view('livewire.tout-groupes2');
    }
}
