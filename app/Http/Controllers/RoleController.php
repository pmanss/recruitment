<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Yajra\DataTables\DataTables;
use Redirect, Response, DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct()
    {
    	$this->middleware('permission:role-list|role-create|role-edit|role-delete', ['only' => ['index','store']]);
    	$this->middleware('permission:role-create', ['only' => ['create','store']]);
    	$this->middleware('permission:role-edit', ['only' => ['edit','update']]);
    	$this->middleware('permission:role-delete', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
    	if(request()->ajax()) {
    		return Datatables::of(Role::query())
    		->addColumn('action', function($get){
    			$json = $get->toJson();
    			return "
    			<center>
    			<button title=\"Edit user $get->name\" data-id=\"$get->id\" class=\"btn btn-sm btn-edit btn-primary btn-update\"><i class=\"fa fa-edit\"></i> </button>

    			<button title=\"Hapus user $get->name\" type=\"submit\" id=\"destroy\" data-id=\"$get->id\" data-name=\"$get->name\" class=\"btn btn-sm btn-edit btn-danger btn-destroy\"><i class=\"fa fa-trash\"></i> </button>
    			</center>
    			";
    		})
    		->rawColumns(['action'])
    		->addIndexColumn()->make(true);
    	}
    	$permission = Permission::get();
    	return view('roles.index', compact('permission'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
    	$validate = [
    		'name' => 'required',
    		'permission' => 'required',
    	];

    	$validated = $request->validate($validate);
    	$id = $request->id;
    	$attributes = ['name' => $request->name];

    	$post   =   Role::updateOrCreate(['id' => $id], $attributes);
    	$post->syncPermissions($request->input('permission'));
    	return Response::json($post);
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
    	$role = Role::find($id);
    	$rolePermissions = Permission::join("role_has_permissions","role_has_permissions.permission_id","=","permissions.id")
    	->where("role_has_permissions.role_id",$id)
    	->get();

    	return view('roles.show',compact('role','rolePermissions'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	$update  = Role::find($id);
    	return Response::json($update);
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
    public function destroy($id)
    {
    	$destroy = Role::where('id',$id)->delete();
    	return Response::json($destroy);
    }
}
