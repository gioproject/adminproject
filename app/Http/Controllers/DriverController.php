<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\DriverController;
use App\Models\Driver;
use Illuminate\Support\Facades\Validator;
use DataTables;


class DriverController extends Controller
{
    public function index(Request $request)
    {
       

        if ($request->ajax()) {
            $data = Driver::all();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function($data){
                 
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('driver_list');
    }

    public function add_driver(){

        return view('add_driver');

    }

    public function store_driver(Request $request){
        
        $data = $request->validate([

            'name'=>'required',
            'contact'=>'required',
            'address'=>'required',
            'email'=>'required|email',
        ]);
      
    
        $driver = new Driver;
        $driver->name = $request->name;
        $driver->contact = $request->contact;
        $driver->address = $request->address;
        $driver->email = $request->email;
        $driver->save();


        $status = "";
        $message = "";

        if($driver){
            $status = "success";
            $message ="Data have been successfully inserted.";
        }else{
            $status = "fail";
            $message = "something went wrong.";
        }
        return back()->with($status, $message);

    }



    public function store(Request $request){

        $validator = Validator::make($request->all(), [

            'name'=>'required',
            'contact'=>'required',
            'address'=>'required',
            'email'=>'required|email',
        
        ]);

         if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
         }
 
          
         $driver = new Driver;
         $driver->name = $request->input('name');
         $driver->contact = $request->input('contact');
         $driver->address = $request->input('address');
         $driver->email = $request->input('email');
         $driver->save();

         return response()->json([
             'status'=>200,
             'message'=>'Driver Added Successfully !',
         ]);
        
    }

    public function manage_driver_list(Request $request){


        if ($request->ajax()) {
            $data = Driver::all();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function($data){

                        $btn = '<button type="button" value="'.$data->id.'" id="'.$data->id.'" class="edit_driver btn btn-primary btn-sm"> <i class="bi bi-pencil-square bi-pencil-square"></i> </button>';
                        $btn .= ' <button type="button" value="'.$data->id.'" id="'.$data->id.'" class="delete_driver btn btn-danger btn-sm"> <i class="bi bi-trash-fill"></i></button>';
                        return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('manage_driver_list');
    }

    public function edit($id){

        $driver = Driver::find($id);
        
        if($driver){
            return response()->json([
                'status'=>200,
                'driver'=>$driver,
            ]);
        }

    }

    public function update(Request $request, $id){
        
        $validator = Validator::make($request->all(), [

            'name'=>'required',
            'contact'=>'required',
            'address'=>'required',
            'email'=>'required|email',

           
        ]);
    
         if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
         }
         else{
            $driver = Driver::find($id);
            
            if($driver){
                $driver->name = $request->input('name');
                $driver->contact = $request->input('contact');
                $driver->address = $request->input('address');
                $driver->email = $request->input('email');
                $driver->update();
    
                return response()->json([
                    'status'=>200,
                    'message'=>'Driver updated Successfully !',
                ]);
    
            }else{
                return response()->json([
                    'status'=>404,
                    'message'=>'Driver Not Found !',
                ]);
            }
           
         }
    }

    public function delete($id){

            $driver = Driver::find($id);
            $driver->delete();

    }
}
