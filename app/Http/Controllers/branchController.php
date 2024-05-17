<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\branch;
use Illuminate\support\str;

class branchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $establishment_id = session()->get('establishment_id');
        $branches = branch::where('establishment_id' , $establishment_id)->get();
        return view('adminDashboard.branches.AddBranch' , ['branches' =>$branches]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
{
    try {
        $request->validate([
            'id' => 'required|string',
            'name' => 'required',
        ]);

        // Get establishment ID from session
        $establishment_id = session()->get('establishment_id');

        // Check if a branch with the same id already exists
        $existingBranch = branch::where('id', $request->id)->first();

        if ($existingBranch) {
            return redirect()->route('addbranch')->withErrors(['error' => "Un Filière avec le même code existe déjà."]);
        }

        // Create branch record
        $branch = branch::create([
            'id' => $establishment_id.$request->id,
            'name' => $request->name,
            'establishment_id' => $establishment_id,
        ]);

        if ($branch) {
            return redirect()->route('addbranch')->with('success', "Vous avez ajouté une nouvelle filière.");
        } else {
            return redirect()->route('addbranch')->withErrors(['error' => "Une erreur s'est produite lors de l'ajout de la filière."]);
        }
    } catch (\Exception $e) {
        return redirect()->route('addbranch')->withErrors(['error' => "Une erreur s'est produite lors de l'ajout de la filière."]);
    }
}



    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateView(Request $request)
    {

        $branche = branch::find($request->id);
        return view('adminDashboard.branches.updateBranch',['branche' => $branche]);
    }
    public function  delateBranch($id)
        {
        branch::destroy($id);
        return redirect()->route('addbranch')->with('success' , "Vous avez supprimé la filière.");
        }

        public function updateBarnch(Request $request ,$id){
            // $str= Str::random(6);
            $establishment_id = session()->get('establishment_id');
            branch::where('id', $id)->update([
                'id' => $establishment_id.$request->id,
                'name' => $request->name
            ]);
           return redirect()->route('addbranch')->with('success', "Vous avez mis à jour la filière.") ;
        }


}
