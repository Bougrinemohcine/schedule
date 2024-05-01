<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\EmploiStrictureModel;

class EmploiStricture  extends Controller
{
    public function index()
    {
        return view('adminDashboard.setting.EmploiStricture');
    }
// get data
public function getdata(){

    $checkValues = EmploiStrictureModel::where('user_id', Auth::user()->id)->get();
    return response()->json($checkValues);
}


    public function create(Request $request)
    {
        try {
            $userId = Auth::id();
            $isExiste = EmploiStrictureModel::where('user_id', $userId)->first();
            if ($isExiste) {
                $isExiste->update([
                    'groupe' => $request->input('groupe'),
                    'formateur' => $request->input('formateur'),
                    'toutFormateur' => $request->input('toutFormateur'),
                    'toueGroupe' => $request->input('toueGroupe'),
                ])->where('user_id', $userId);
            }
            return response()->json('Settings updated successfully');
        } catch (\Exception $e) {
            return response()->json($e->getMessage());
        }
    }

}
