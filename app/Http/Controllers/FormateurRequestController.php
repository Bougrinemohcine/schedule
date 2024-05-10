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

    public function submitAllData(Request $request)
    {
        try {
            $data = $request->all();
            $selectedData = $data['selectedData'];
            $mainEmploiId = $data['mainEmploiId'];
            $user_id = Auth::id();
            $requestEmploiId = RequestEmploi::where('user_id', $user_id)->where('main_emploi_id', $mainEmploiId)->value('id');
            $establishment = session()->get('establishment_id');
            if (!$requestEmploiId) {
                return response()->json(['msg' => 'Tu dois créer une demande d\'emploi pour cet emploi d\'abord.', 'status' => 599]);
            } else {
                foreach ($selectedData as $item) {
                    // Check if seanceId is set
                    if (isset($item['seanceId'])) {
                        // Delete the existing session with seanceId
                        Sission::where('id', $item['seanceId'])->delete();
                    }

                    // Create a new session
                    $sission = new sission([
                        'day' => $item['day'],
                        'day_part' => $item['dayPart'],
                        'sission_type' => $item['type'],
                        'group_id' => $item['group'],
                        'module_id' => $item['module'],
                        'class_room_id' => $item['class'],
                        'establishment_id' => $establishment,
                        'dure_sission' => $item['seancePart'],
                        'user_id' => $user_id,
                        'main_emploi_id' => $mainEmploiId,
                        "demand_emploi_id" => $requestEmploiId,
                        'message' => $item['message'],
                        'status_sission' => "Pending",
                    ]);

                    $sission->save();
                    // Notify admin about the new request emploi
                    $MainUser = User::where('role', 'admin')->first();
                    $comment = $item['message'];
                    $type = 'seance';
                    $FormateurRequest = Auth::user()->user_name;
                    Notification::send($MainUser, new RequestEmploiNotification($type, $sission->id, $FormateurRequest, $mainEmploiId, $comment, $sission->status_sission));
                    Log::info('Sission created:', ['data' => $item]);
                }
                return response()->json(['sucess' => 'Toutes les données ont été soumises avec succès.', 'status' => 200]);
            }
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error occurred while processing request.', 'status' => 500, 'error' => $e->getMessage()]);
        }
    }


    public function updateSession(Request $request)
    {
        try {
            // Récupérer les données de la requête
            $data = $request->all();

            // Implémenter la logique de mise à jour de la séance

            return response()->json(['success' => 'Séance mise à jour avec succès.', 'status' => 200]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Une erreur est survenue lors de la mise à jour de la séance.', 'status' => 500]);
        }
    }

    public function deleteSession(Request $request)
    {
        // Validate the request
        $request->validate([
            'seanceId' => 'required', // Adjust validation rules as needed
        ]);

        // Retrieve the seanceId from the request
        $seanceId = $request->input('seanceId');

        // Find the record in the database based on the seanceId
        $record = sission::find($seanceId);

        // Check if the record exists
        if (!$record) {
            // If the record does not exist, return an error response
            return response()->json(['message' => 'Record not found.'], 404);
        }

        // Perform any additional authorization checks if necessary
        // For example, you might check if the user has permission to delete this record

        // Delete the record from the database
        $record->delete();

        // Redirect the user back to the previous page
        return back();
    }


    public function createRequestEmploi(Request $request)
    {
        try {
            // Validate the incoming request data
            $validatedData = $request->validate([
                'mainEmploiId' => 'required|integer',
                'comment' => 'nullable|string',
            ]);

            // Retrieve the validated employment ID and comment from the request data
            $mainEmploiId = $validatedData['mainEmploiId'];
            $comment = $validatedData['comment'];

            // Get the authenticated user's ID
            $user_id = Auth::id();

            // Check if a request already exists for the user and employment ID
            $existingRequest = RequestEmploi::where('user_id', $user_id)
                ->where('main_emploi_id', $mainEmploiId)
                ->first();
            $requestExists = $existingRequest ? true : false;

            if ($existingRequest) {
                // If a request already exists, update it
                $existingRequest->update([
                    'date_request' => now(),
                    'comment' => $comment,
                ]);
                // Notify admin about the new request emploi
                $MainUser = User::where('role', 'admin')->first();
                $FormateurRequest = Auth::user()->user_name;
                $type = 'emploi';

                Notification::send($MainUser, new RequestEmploiNotification($type, $existingRequest->id, $FormateurRequest, $mainEmploiId, $comment, ''));
                return response()->json(['message' => 'Request emploi updated successfully.', 'status' => 400, 'requestExists' => $requestExists]);
            } else {
                // If no request exists, create a new one
                $requestEmploi = new RequestEmploi([
                    'date_request' => now(),
                    'comment' => $comment,
                    'user_id' => $user_id,
                    'main_emploi_id' => $mainEmploiId,
                ]);
                $requestEmploi->save();

                // Notify admin about the new request emploi
                $MainUser = User::where('role', 'admin')->first();
                $FormateurRequest = Auth::user()->user_name;
                $type = 'emploi';

                Notification::send($MainUser, new RequestEmploiNotification($type, $requestEmploi->id, $FormateurRequest, $mainEmploiId, $comment, ''));

                return response()->json(['message' => 'Request emploi created successfully.', 'status' => 300, 'requestExists' => $requestExists]);
            }
        } catch (\Exception $e) {
            // Return error response in case of any exceptions
            return response()->json(['message' => 'Error creating or updating request emploi.', 'status' => 500, 'error' => $e->getMessage()]);
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
    // public function updateSettings(Request $request)
    // {
    //     // Validate the incoming request data
    //     $validatedData = $request->validate([
    //         'email' => 'nullable|email',
    //         'image' => 'nullable|image',
    //         'domaine' => 'nullable|string|max:255',
    //     ]);

    //     try {
    //         // Retrieve the authenticated user's ID
    //         $user_id = auth()->id();

    //         // Extract validated data
    //         $requestData = $request->all();
    //         $email = $validatedData['email'];
    //         $image = $validatedData['image'];
    //         $domaine = $validatedData['domaine'];

    //         // Update the authenticated user's data
    //         User::where('id', $user_id)->update([
    //             'email' => $email,
    //             'image' => $image,
    //             'domaine' => $domaine,
    //         ]);

    //         // Redirect back with success message
    //         return redirect()->back()->with('success', 'Settings updated successfully!');
    //     } catch (\Exception $e) {
    //         // Handle any exceptions
    //         return redirect()->back()->with('error', 'Error updating settings: ' . $e->getMessage());
    //     }
    // }
    public function updateSettings(Request $request)
{
    try {
        // Validate the incoming request data
        $validatedData = $request->validate([
            'email' => 'nullable|email',
            'image' => 'nullable|image',
            'domaine' => 'nullable|string|max:255',
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
        // Handle any exceptions
        return redirect()->back()->with('error', 'Error updating settings: ' . $e->getMessage());
    }
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

    public function handleEmploiChange(Request $request)
    {
        try {
            // Retrieve main emploi ID from the request data
            $main_emploi_id = $request->input('main_emploi_id');

            // Retrieve the authenticated user's ID
            $user_id = Auth::id();

            // Fetch all seances related to the user and main emploi
            $allSeances = Sission::where('user_id', $user_id)
                ->where('main_emploi_id', $main_emploi_id)
                ->get();

            return response()->json(['seances' => $allSeances, 'status' => 200]);
        } catch (\Exception $e) {
            // Handle any exceptions
            return response()->json(['message' => 'Error occurred while processing request.', 'status' => 500, 'error' => $e->getMessage()]);
        }
    }
}
