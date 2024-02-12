<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\admin\IndexController;
use App\Http\Controllers\admin\RolesController;
use App\Http\Controllers\admin\PermissionsController;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Validator;
use DataTables;


class PermissionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $permissions = Permission::all();

        if ($request->ajax()) {
            $data = Permission::all();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function($data){
                    $btn = '<button type="button" value="'.$data->id.'" id="'.$data->id.'" class="edit_permission btn btn-primary btn-sm"> <i class="bi bi-pencil-square"></i> Edit</button>';
                    $btn .= ' | <button type="button" value="'.$data->id.'" id="'.$data->id.'" class="delete_permission btn btn-danger btn-sm"> <i class="bi bi-backspace-reverse-fill"></i> Delete</button>';
                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $id = 1;
      
        $role_admin = Role::find($id);

        $validator = Validator::make($request->all(), [

            'name'=>'required|unique:permissions,name',
        
        ]);

         if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
         }
 
            $permissions = new Permission;
            $permissions->name = $request->input('name');
            $permissions->save();

            
            $permissions_name = Permission::all();

            $role_admin->syncPermissions([$permissions_name]);


            return response()->json([
                'status'=>200,
                'message'=>'Role Added Successfully !',
            ]);
          
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $role = Permission::find($id);
        $role->delete();

        return response()->json([
            'status'=>404,
            'message'=>'Permission Deleted Successfully !',
        ]);


    
    }
}
