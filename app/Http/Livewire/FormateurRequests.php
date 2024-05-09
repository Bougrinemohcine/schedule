<?php

namespace App\Http\Livewire;

use App\Models\User;
use App\Models\Sission;
use Livewire\Component;
use App\Models\main_emploi;
use App\Models\RequestEmploi;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use App\Notifications\RequestEmploiNotification;

class FormateurRequests extends Component
{
    public $mainEmplois;
    public $daysOfWeek;
    public $daysPart;
    public $seancesPart;
    public $allSeances;
    public $emploiID;
    public $comment;
    public $existingRequest;

    public function mount()
    {
        // Retrieve main emploi ID from the request data
        $this->emploiID = main_emploi::latest()->value('id');

        // Fetch all main emplois
        $this->mainEmplois = main_emploi::all();

        // Define lists of days of week, days part, and seances part
        $this->daysOfWeek = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
        $this->daysPart = ["Matin", "Amidi"];
        $this->seancesPart = ["SE1", "SE2", "SE3", "SE4"];

        // Fetch initial seances data
        $this->handleEmploiChange($this->emploiID);
    }


    public function handleEmploiChange($main_emploi_id)
    {
        $this->emploiID = $main_emploi_id;
        $this->allSeances = Sission::where('user_id', Auth::id())
            ->where('main_emploi_id', $main_emploi_id)
            ->get();

        // Check if a request exists for the user and employment ID
        $this->existingRequest = RequestEmploi::where('user_id', Auth::id())
            ->where('main_emploi_id', $main_emploi_id)
            ->exists();
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
        Notification::send($MainUser, new RequestEmploiNotification($type,$this->existingRequest->id, Auth::user()->user_name,$this->emploiID, $comment,''));
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
}




    public function render()
    {
        // Pass the $existingRequest variable to the Blade view
        $dddd = $this->existingRequest;
        return view('livewire.formateur-requests', [
            'existingRequest' => $dddd,
        ]);
    }


}
