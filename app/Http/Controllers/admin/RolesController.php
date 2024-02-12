<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\admin\IndexController;
use App\Http\Controllers\admin\RolesController;
use App\Http\Controllers\admin\PermissionsController;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

use Illuminate\Support\Facades\Validator;

use DataTables;
use DB;
use Auth;

class RolesController extends Controller
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
            $data = Role::all();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function($data){
                    // $edit = '';
                    // $delete = '';
    
                    // if(Auth::user()->hasPermissionTo('admin-edit'))
                    // {
                        $btn = '<button type="button" value="'.$data->id.'" id="'.$data->id.'" class="edit_role btn btn-success btn-sm"> <i class="bi bi-pencil-square"></i></button>';
                    // }
    
                    // if(Auth::user()->hasPermissionTo('admin-edit'))
                    // {
                        $btn .= ' | <button type="button" value="'.$data->id.'" id="'.$data->id.'" class="delete_role btn btn-danger btn-sm"> <i class="bi bi-trash"></i></button>';
                 
                    // }
    
                    return $btn;
                    
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.roles.index', compact('permissions'));
    }

  public function get_permission_list(Request $request){

    if ($request->ajax()) {
        $data = Permission::all();
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('action', function($data){
                $check = '<input type="checkbox" name="permission_id" value="'.$data->id.'" id="check-permission-id" class="permission_id"/>';
                return $check;
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    return view('admin.roles.index');

  }


    public function givePermission(Request $request){


       $id = $request->role_id;

       $role = Role::find($id);
        
        // if($role->hasPermissionTo($request->permission)){
            
        //     return response()->json([
        //         'message'=>'Permission exists !',
        //     ]);
        // }
       

        $role->syncPermissions([$request->permission]);
        
         return response()->json([

         'message'=>'Permission Save !',
         'role'=>$role,
         ]);

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
        $validator = Validator::make($request->all(), [

            'name'=>'required|unique:roles,name',
        
        ]);

         if($validator->fails()){
            return response()->json([
                'status'=>400,
                'errors'=>$validator->messages(),
            ]);
         }
 
            $roles = new Role;
            $roles->name = $request->input('name');
            $roles->save();

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

        $role = Role::find($id);

        $permission = Permission::get();
        $rolePermissions = DB::table("role_has_permissions")->where("role_has_permissions.role_id",$id)
        ->pluck('role_has_permissions.permission_id')
        ->all();


        if($role){
            return response()->json([
                'status'=>200,
                'role'=>$role,
                'rolePermissions' => $rolePermissions,
                'permission' => $permission,
            ]);
        }

      
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
        
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $role = Role::find($id);
        $role->delete();

        return response()->json([
            'status'=>404,
            'message'=>'Role Deleted Successfully !',
        ]);


    
    }
}
