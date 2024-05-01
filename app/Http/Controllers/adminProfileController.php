<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
class adminProfileController extends Controller
{
    public function index(){
        $establishment_id = session()->get('establishment_id');
        $admin = User::where(['establishment_id' => $establishment_id, 'role' => 'admin'])->first();

        $Obj = new  \stdClass();
        $Obj->id = $admin->id;
        $Obj->name = $admin->user_name;
        $Obj->email =$admin->email ;
        $Obj->password = $admin->password ;
        $Obj->id = $admin->id ;

        return view('adminDashboard.Profile.profile', compact('Obj'));
    }


    public function update(Request $request){
        $rules = [
            'user_name' => 'required',
            'email' => 'required|email',
        ];
        if(!empty($request->password)) {
            $rules['password'] = 'required|min:6';
        }
        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $updateData = [
            'user_name' => $request->user_name,
            'id' => $request->id,
            'email' => $request->email,
        ];

        if (!empty($request->password)) {
            $updateData['password'] = bcrypt($request->password);
        }
        User::where('id', Auth::user()->id)->update($updateData);
        return redirect()->route('showProfileAdmin')->with('success', 'Vous avez modifié vos informations avec succès.');
    }

}
