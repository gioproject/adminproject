<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Http\Controllers\admin\UsersController;
use App\Http\Controllers\admin\RolesController;
use App\Http\Controllers\admin\PermissionsController;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use App\Models\User;

use Illuminate\Support\Facades\Validator;

use DataTables;
use DB;
use Auth;
class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $roles = Role::all();

        if ($request->ajax()) {
            $data = User::all();
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('action', function($data){
                    // $edit = '';
                    // $delete = '';
    
                    // if(Auth::user()->hasPermissionTo('admin-edit'))
                    // {
                        $btn = '<button type="button" value="'.$data->id.'" id="'.$data->id.'" class="assign_role_permission btn btn-success btn-sm"> <i class="bi bi-pencil-square"></i></button>';
                    // }
    
                    // if(Auth::user()->hasPermissionTo('admin-edit'))
                    // {
                        $btn .= ' | <button type="button" value="'.$data->id.'" id="'.$data->id.'" class="btn_delete btn btn-danger btn-sm"> <i class="bi bi-trash"></i></button>';
                 
                    // }
    
                    return $btn;
                    
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.users.index', compact('roles'));
    }

    public function assign_role_permission($id){


        $user = User::find($id);

        if($user){
            return response()->json([
                'status'=>200,
                'user'=>$user,
            ]);
        }

    }

    

    public function assign_roles_to_user(Request $request){

        $id = $request->user_id;

        $user = User::find($id);

        //  $role->syncPermissions([$request->permission]);


        $user->assignRole([$request->role_name]);

        return response()->json([

            'message'=>'Permission Save !',
            'user'=>$user,
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
        //
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
    public function destroy($id)
    {
        //
    }
}
