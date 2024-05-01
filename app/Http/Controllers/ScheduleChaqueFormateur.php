<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\formateur;

class ScheduleChaqueFormateur extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('adminDashboard.Main.EmpmloiChaqueFormateur');
    }





    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function SessionsForEashFormateur($id)
    {
        $establishment_id = session()->get('establishment_id');
        $sissions = DB::table('sissions')
        ->select('sissions.*', 'modules.module_name', 'groups.group_name','class_rooms.class_name')
        ->join('modules', 'modules.id', '=', 'sissions.module_id')
        ->join('groups', 'groups.id', '=', 'sissions.group_id')
        ->join('class_rooms', 'class_rooms.id', '=', 'sissions.class_room_id')
        ->where('sissions.establishment_id', $establishment_id)
        ->where('sissions.user_id',$id)
        ->where('sissions.main_emploi_id', session()->get('id_main_emploi'))
        ->get();
        // dd($sissions);
        return response()->json($sissions);
    }

  

}
