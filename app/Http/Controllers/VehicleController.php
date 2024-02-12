<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Controllers\VehicleController;
use App\Models\Vehicle;
use App\Models\Driver;
use Illuminate\Support\Facades\Validator;
use DataTables;

class VehicleController extends Controller
{
    public function add_vehicle(){


        $data = Driver::all();
        
        return view('add_vehicle', compact('data'));

    }

    public function index(Request $request)
    {

        if ($request->ajax()) {
            $data = Vehicle::all();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function($data){
                 
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('vehicle_list');
    }

    public function edit($id){

        $vehicle = Vehicle::find($id);
        
        if($vehicle){
            return response()->json([
                'status'=>200,
                'vehicle'=>$vehicle,
            ]);
        }
    }
    
    public function manage_vehicle_list(Request $request){

        $dataa = Driver::all();

        if ($request->ajax()) {
            $data = Vehicle::all();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function($data){

                        $btn = '<button type="button" value="'.$data->id.'" id="'.$data->id.'" class="edit_vehicle btn btn-primary btn-sm"> <i class="bi bi-pencil-square bi-pencil-square"></i> </button>';
                        $btn .= ' <button type="button" value="'.$data->id.'" id="'.$data->id.'" class="delete_vehicle btn btn-danger btn-sm"> <i class="bi bi-trash-fill"></i></button>';
                        return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('manage_vehicle_list', compact('dataa'));
    }

    public function store_vehicle(Request $request){

    
        $data = $request->validate([

            'vehicle_name'=>'required',
            'vehicle_registration_number'=>'required',
            'vehicle_number_of_seats'=>'required',
            'driver_name'=>'required',
            'vehicle_category'=>'required',
            'photo'=>'required',
          
        ]);
        
        $stat = "Available";
        
        $vehicle = new Vehicle;
        $vehicle->vehicle_name = $request->vehicle_name;
        $vehicle->vehicle_registration_number = $request->vehicle_registration_number;
        $vehicle->vehicle_number_of_seats = $request->vehicle_number_of_seats;
        $vehicle->driver_name = $request->driver_name;
        $vehicle->vehicle_category = $request->vehicle_category;
        $vehicle->status = $stat;

        if($request->hasfile('photo'))
        {
            $file = $request->file('photo');
            $extention = $file->getClientOriginalExtension();
            $filename = time().'.'.$extention;
            $file->move('assets/img/', $filename);
            $vehicle->photo = $filename;
        }

        $vehicle->save();

        $status = "";
        $message = "";

        if($vehicle){
            $status = "success";
            $message ="Data have been successfully inserted.";
        }else{
            $status = "fail";
            $message = "something went wrong.";
        }

        return back()->with($status, $message);

      

    }
  
}
