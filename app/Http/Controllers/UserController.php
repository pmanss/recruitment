<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\DataTables;
use Redirect, Response, DB, Hash;
use App\User;
use App\Role;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

    	if(request()->ajax()) {
    		return Datatables::of(User::query())->addColumn('action', function($get){
    			$json = $get->toJson();
    			return "
    			<center>
    			<button title=\"Edit user $get->name\" data-id=\"$get->id\" class=\"btn btn-sm btn-edit btn-primary btn-update\"><i class=\"fa fa-edit\"></i> </button>
    			<button title=\"Hapus user $get->name\" type=\"submit\" id=\"destroy\" data-id=\"$get->id\" data-name=\"$get->name\" class=\"btn btn-sm btn-edit btn-danger btn-destroy\"><i class=\"fa fa-trash\"></i> </button>
    			</center>
    			";
    		})
    		->addIndexColumn()->make(true);
    	}
    	$roles = Role::all();
    	return view('users.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
    	$roles = Role::pluck('name','name')->all();
    	return view('users.create',compact('roles'));
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
    		'email'=> 'required',
    	];
    	if(!$request->id){
    		$validate['password'] = 'required|same:confirm-password';
    	}
    	$validated = $request->validate($validate);
    	$id = $request->id;
    	$attributes = ['name' => $request->name, 'email' => $request->email,'role' => $request->roles];
    	if($request->password){
    		$attributes['password']=bcrypt($request->password);
    	}
    	$post   =   User::updateOrCreate(['id' => $id], $attributes);
    	$post->syncRoles($request->roles);
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
    	
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
    	$update  = User::find($id);
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
    	$destroy = User::where('id',$id)->delete();
    	return Response::json($destroy);
    }
}
