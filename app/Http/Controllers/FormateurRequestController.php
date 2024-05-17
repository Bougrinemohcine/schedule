<?php

namespace App\Http\Controllers;

use App\Models\class_room;
use App\Models\establishment;
use App\Models\formateur_has_group;
use App\Models\main_emploi;
use App\Models\module_has_formateur;
use App\Models\RequestEmploi;
use App\Models\sission;
use App\Models\User;
use App\Notifications\RequestEmploiNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Testing\Fakes\NotificationFake;

class FormateurRequestController extends Controller
{
    public function show(Request $request)
    {
        try {
            // Retrieve the authenticated user's ID
            $user_id = Auth::id();

            // Retrieve main emploi ID from the request data
            if ($request->input('emploiID')) {

                $emploiID = $request->input('emploiID');
            } else {
                $emploiID = main_emploi::latest()->value('id');
            }
            $allSeances = Sission::where('user_id', $user_id)
                ->where('main_emploi_id', $emploiID)
                ->get();

            // Fetch all seances related to the user and main emploi


            // Fetch groups list associated with the formateur
            $groupsList = formateur_has_group::where('formateur_id', $user_id)->get();

            // Fetch modules list associated with the formateur
            $modulesList = module_has_formateur::where('formateur_id', $user_id)->get();

            // Fetch all classrooms associated with the establishment
            $classRooms = class_room::where('id_establishment', session()->get('establishment_id'))->get();

            // Fetch all main emplois
            $mainEmplois = main_emploi::all();

            // Define lists of seances types, days of week, days part, and seances part
            $seancesType = ["PRESENTIELLE", "TEAMS", "EFM"];
            $daysOfWeek = ["Mon", "Tue", "Wed", "Thu", "Fri", "Sat"];
            $daysPart = ["Matin", "Amidi"];
            $seancesPart = ["SE1", "SE2", "SE3", "SE4"];

            return view('formateurDashboard.FormateurRequest.Request', [
                'main_emplois' => $mainEmplois,
                'days_of_week' => $daysOfWeek,
                'days_part' => $daysPart,
                'seances_part' => $seancesPart,
                'GroupsList' => $groupsList,
                'modulesList' => $modulesList,
                'class_rooms' => $classRooms,
                'seances_type' => $seancesType,
                'AllSeances' => $allSeances,
                'emploiID' => $emploiID
            ]);
        } catch (\Exception $e) {
            // Handle any exceptions
            return response()->json(['message' => 'Error occurred while processing request.', 'status' => 500, 'error' => $e->getMessage()]);
        }
    }

    

    

   

    
    public function settings()
    {
        // Retrieve the authenticated user
        $user = Auth::user();
        $DemandesList = RequestEmploi::where('user_id', $user->id)->count();
        $seancesList = sission::where('user_id', $user->id)->count();

        // Pass user data to the view
        return view('formateurDashboard.settings.settingsFormateur', [
            'user' => $user,
            'DemandesList' => $DemandesList,
            'seancesList' => $seancesList,
        ]);
    }
    
    public function updateSettings(Request $request)
{
    try {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'email' => 'nullable|email|unique:users,email,' . auth()->id(),
            'image' => 'nullable|image',
            'domaine' => 'nullable|string|max:255',
        ], [
            'email.unique' => 'The email address is already in use.',
            'email.email' => 'Please provide a valid email address.',
        ]);

        // Retrieve the authenticated user's ID
        $user_id = auth()->id();

        // Retrieve user record
        $user = User::find($user_id);

        // Update user data based on validated fields
        if (isset($validatedData['email'])) {
            $user->email = $validatedData['email'];
        }

        if ($request->hasFile('image')) {
            // Get the uploaded image file
            $image = $request->file('image');
            // Generate a unique name for the file
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            // Move the file to the storage folder
            $image->move(public_path('uploads'), $imageName);
            // Update the user's image field
            $user->image = $imageName;
        }

        if (isset($validatedData['domaine'])) {
            $user->domaine = $validatedData['domaine'];
        }

        // Save the updated user data
        $user->save();

        // Redirect back with success message
        return redirect()->back()->with('success', 'Settings updated successfully!');
    } catch (\Exception $e) {
        // Handle validation errors
        return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
    }
}
public function updatePassword(Request $request)
{
    // Validate form fields
    $request->validate([
        'current_password' => 'required',
        'new_password' => 'required|min:6|different:current_password',
        'confirm_new_password' => 'required|min:6|same:new_password',
    ]);

    // Retrieve the authenticated user
    $user = auth()->user();

    // Check if the current password is correct
    if ($request->current_password != $user->passwordClone) {
        // Return an error if the current password is incorrect
        return back()->withErrors(['current_password' => 'The current password is incorrect.'])->withInput();
    }

    // Update the user's password
    $user->passwordClone = $request->new_password;
    $user->save();

    // Redirect with a success message
    return redirect()->back()->with('success', 'Password updated successfully.');
}





    public function MarkAsread()
    {
        $user = User::find(auth()->user()->id);
        foreach ($user->unreadNotifications as $notification) {
            $notification->markAsRead();
        }
        return redirect()->back();
    }

    public function Clear()
    {
        $user = User::find(auth()->user()->id);
        foreach ($user->Notifications as $notification) {
            $notification->delete();
        }
        return redirect()->back();
    }

    
}
