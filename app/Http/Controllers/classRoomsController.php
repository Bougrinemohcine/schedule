<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use App\Models\class_room;
use App\Models\class_room_type;
use App\Models\class_has_type;
use Illuminate\Support\Facades\DB;


class classRoomsController extends Controller
{
    public function index(){

        $class_rooms = class_room::all()->where('id_establishment',session()->get('establishment_id'));

        return view('adminDashboard.addClasses.add_classe_room',['classes'=>$class_rooms]);
    }
    // insert   class name
    public function insert(Request $request) {
        $validator = $request->validate([
            'class_name' => ['required'],

        ]);
        // Retrieve establishment_id from the session
        $establishment_id = session()->get('establishment_id');
        // Create a new class_room instance and fill it with validated data
        try {
            $class_room = class_room::create([
                'class_name' => $validator['class_name'],
                'id_establishment' => $establishment_id
            ]);
            return redirect()->back()->with('success', 'Class room added successfully');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withErrors(['insertion_error' => $e->errorInfo[2]])->withInput();
        }
    }



    //insert date into db
    public function insert_class_type(Request $request){
        try{
            $class_type = class_room_type::create([
                'class_room_types'=>$request->add_class_type,
                'establishment_id'=> session()->get('establishment_id')
            ]);
            return redirect()->back();
        } catch(\Illuminate\Database\QueryException $e){
            return  redirect()->back()->withErrors(['insertion_error'=>$e->errorInfo[2]]);
        }



    }
    //  show  class room in UI
    public function show_add_class_type(){
        $class_type = class_room_type::all()->where('establishment_id',session()->get('establishment_id'));
        return view('adminDashboard.addClasses.class_types',['classTypes'=>$class_type]);
    }

    // Delet type
    public function Delete_Types_Of_Class(Request $request){
        $deleted = class_room_type::destroy($request->id);
        if($deleted){
             return redirect()->back()->with('delated seccesfuly');
        }
    }
    //  Delet  class room
    public function Delete_Class(Request $request){
        $deleted = class_room::destroy($request->id);
        if($deleted){
             return redirect()->back()->with('delated seccesfuly');
        }
    }

    // determine type class room UI
    public function indexOfDetermineTypeOfclass(){
        $class_type = class_room_type::all()->where('establishment_id',session()->get('establishment_id'));
        $class_rooms = class_room::all()->where('id_establishment',session()->get('establishment_id'));

        $results = DB::table('class_room_types')
        ->join('classes_has_types' ,'classes_has_types.class_room_types_id','=','class_room_types.id')
        ->join('class_rooms','class_rooms.id','=','classes_has_types.class_rooms_id')
        ->select('classes_has_types.id','class_rooms.class_name','class_room_types.class_room_types')
        ->where('classes_has_types.establishment_id',session()->get('establishment_id'))
        ->get();

        $data = [];
        $classes =[] ;
            foreach($results as $item){
            if(!in_array($item->class_name,$classes)){
            array_push($classes,$item->class_name);
            };
            };
            foreach ($classes as $class) {
            $types = [];
            foreach ($results as $item) {
                if ($class === $item->class_name) {
                  array_push($types, $item->class_room_types);
                 }
              }
                 $data[$class] = $types;
            }

        return view('adminDashboard.addClasses.Determane_Class_Type',['classes'=>$class_rooms,"types"=>$class_type,'classes_with_types'=>$data]);
    }

    //insert classes with  this types
    public function insertClassWithTtypes(Request $request)
{
    $request->validate([
        'classes' => 'required|array',
        'types' => 'required|array',
    ]);

    $classes = $request->classes;
    $types = $request->types;

    foreach ($classes as $class) {
        foreach ($types as $type) {
            // Check if the combination already exists
            $exists = class_has_type::where('class_rooms_id', $class)
                                    ->where('class_room_types_id', $type)
                                    ->exists();

            if (!$exists) {
                class_has_type::create([
                    'establishment_id' => session()->get('establishment_id'),
                    'class_rooms_id' => $class,
                    'class_room_types_id' => $type,
                ]);

            }else{
                return redirect()->back()->withErrors(['errors'=>'Class and types  already added']);
            }
        }
    }
    return redirect()->back()->with('success', 'Class and types added successfully');
}

// delate classes  with hes types
public function deleteClassWithTypes(Request $request) {
    $id = session()->get('establishment_id');
    $className = $request->classNAme;
    $results = DB::select('SELECT id FROM class_rooms WHERE class_name = ? AND id_establishment = ?', [$className, $id]);

    if (empty($results)) {
        return redirect()->back()->withErrors(['error' => 'Class not found']);
    }
    $id_classname = $results[0]->id;
    class_has_type::where('class_rooms_id', $id_classname)
                  ->where('establishment_id', $id)
                  ->delete();

     return redirect()->back()->with(['success' => 'Class and types deleted successfully']);
}

public  function EditClass($id){
    $class = class_room::find($id);
   return view('adminDashboard.addClasses.update_class_room ',['class'=>$class]);
}

public function updateClass(Request $request){
    $class = class_room::find($request->class_id);
    $class->class_name =$request->class_name ;
    $class->save();
    return redirect()->route('add-class-rooms')->with(['success'=>' You Updated successfully']) ;
}
}
