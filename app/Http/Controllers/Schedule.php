<?php
namespace App\Http\Controllers;

use App\Models\class_room;
use App\Models\formateur_has_group;
use Illuminate\Http\Request;
use App\Models\main_emploi;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\group;
use App\Models\module_has_formateur;
use App\Models\sission;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Notification;
use App\Notifications\RequestEmploiNotification;
class Schedule extends Controller
{
    public function index(){
        return  view('adminDashboard.Main.main');
    }



    public function AddAutherEmploi()
    {
        Session::put('id_main_emploi', null); // Replace $newValue with the new value you want to store
        Session::put('datestart', null); // Replace $newDateValue with the new date value you want to store

        return redirect()->route('dashboardAdmin')->with('success', "Maintenant, vous pouvez créer un autre emploi du temps.");
    }

    public function deleteAllSessions(){
        DB::table('sissions')->where('establishment_id', session()->get('establishment_id'))
        ->where('main_emploi_id',  session()->get('id_main_emploi'))->delete();
        DB::table('main_emploi')->where('establishment_id', session()->get('establishment_id'))
        ->where('id',  session()->get('id_main_emploi'))->delete();

        Session::forget('id_main_emploi');
        Session::forget('datestart');
        return redirect()->route('dashboardAdmin')->withErrors(['error' => "Vous avez supprimé l'emploi du template."]);

    }

    public function createNewSchedule(Request $request)
    {
        $request->validate([
            'dateStart' => 'required|date',
        ]);

        $dateStart = $request->dateStart;
        $initialDate = Carbon::parse($dateStart);
        $numberOfDaysToAdd = 7;
        $modifiedDate = $initialDate->addDays($numberOfDaysToAdd);
        $dateEnd =  $modifiedDate->format('Y-m-d');
        $establishment_id = session()->get('establishment_id');

        try {
            $main_emploi = main_emploi::create([
                'datestart' => $dateStart,
                'dateend' => $dateEnd,
                'establishment_id' => $establishment_id,
            ]);
            $type = 'createEmplois';
            $mainUsers = User::where('role', 'formateur')->get();
            Notification::send($mainUsers, new RequestEmploiNotification($type,'', Auth::user()->user_name,'','',''));


            if ($main_emploi) {
                session(['id_main_emploi' => $main_emploi->id, 'datestart' => $main_emploi->datestart]);

                if (!empty($request->selectedValue)) {
                    $sessions = DB::table('sissions')
                        ->select('sissions.*', 'modules.module_name', 'groups.group_name', 'users.*', 'class_rooms.class_name')
                        ->leftJoin('modules', 'modules.id', '=', 'sissions.module_id')
                        ->join('groups', 'groups.id', '=', 'sissions.group_id')
                        ->join('users', 'users.id', '=', 'sissions.user_id')
                        ->join('class_rooms', 'class_rooms.id', '=', 'sissions.class_room_id')
                        ->where('sissions.establishment_id', $establishment_id)
                        ->where('sissions.main_emploi_id',  $request->selectedValue)
                        ->get();


                    foreach ($sessions as $session) {
                        Sission::create([
                            'day' => $session->day,
                            'day_part' => $session->day_part,
                            'dure_sission' => $session->dure_sission,
                            'module_id' => $session->module_id,
                            'group_id' => $session->group_id,
                            'establishment_id' => $session->establishment_id,
                            'user_id' => $session->user_id,
                            'class_room_id' => $session->class_room_id,
                            'validate_date' => null,
                            'main_emploi_id' => session()->get('id_main_emploi'),
                            'demand_emploi_id' => null,
                            'message' => null,
                            'sission_type' => $session->sission_type,
                            'status_sission' => 'Accepted',
                        ]);
                    }


                    return redirect()->route('dashboardAdmin')->with('success', "Commencez à créer l'emploi du temps maintenant.");
                }

                return redirect()->route('dashboardAdmin')->with('error', "Il faut sélectionner la date du début !");
            }
        } catch (\Exception $e) {
            session()->forget('id_main_emploi');
            session()->forget('datestart');

            return redirect()->route('dashboardAdmin')->with('error', $e->getMessage());
        }
    }



    // return all emploi  created
    public function toutlesEmploi(){
        return view('adminDashboard.Main.toutEmplois');
    }

    // return all demandes
    public function AllRequest(){
        return view('adminDashboard.Main.AllRequest');

    }

    public function FormateurRequest(){
        return view('formateurDashboard.FormateurRequest.Request');

    }
    public function ForamteurCalendar(){
        return view('formateurDashboard.FormateurCalendar.calendar');
    }

}
