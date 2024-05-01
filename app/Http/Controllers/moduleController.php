<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\module;
use Illuminate\Support\Facades\Validator;

class moduleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $establishment  = session()->get('establishment_id');
        $modules = module::all()->where('establishment_id', $establishment );
        // dd($modules);
        return view('adminDashboard.addmodule.add_module' ,['modules'=>$modules]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $valid = Validator::make($request->all(), [
            'id'=> 'required|unique:modules',
        ]);

        if ($valid->fails()) {
            return redirect()->back()->withErrors($valid)->withInput();
        }

        $establishment = session()->get('establishment_id');

        try {
            module::create([
                'id' => $establishment.$request->id,
                'module_name' =>  $establishment.$request->id,
                'establishment_id' => $establishment
            ]);

            return redirect()->back()->with(['success' => 'You created a new module']);
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withErrors(['error' => $e->errorInfo[2]]);
        }
    }



    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function display_update_page($id)
    {
        $module = module::find($id);
        return view('adminDashboard.addmodule.update_module',['module'=>$module]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request , $id)
    {
        $module = module::find($id);
        $module->module_name = $request->module_name ;
        $module->save();
        if($module){
            return redirect()->route('addModule')->with(['success'=>'you modefid module  successfuly']);
        }

    }


    public function destroy($id)
    {
        $modul = module::where('id',$id)->delete();
        if($modul){
            return redirect()->route('addModule')->with(['success'=>'you are delate module successfuly']);
        }

    }

}
