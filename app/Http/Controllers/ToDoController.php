<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Redirect, Response, DB, Hash;
use App\Todo;
use App\User;
use Auth;

class ToDoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $id = auth()->user()->id;
        $query = DB::table('todos')->where('todos.user_id', $id)->orderBy('todos.updated_at','desc')->get();

        // Search for a status
        $status = $request->filters['status'];
        if(!empty($status) && ucwords($status) !== 'Semua'){
            $query = $query->where('status', $status);
        }

        if(request()->ajax()) {
            return Datatables::of($query)->addColumn('action', function($get){
                return "
                <center>
                <button title=\"Edit kegiatan\" data-id=\"$get->id\" class=\"btn btn-sm btn-edit btn-primary btn-update\"><i class=\"fa fa-edit\"></i> </button>
                </center>
                ";
            })
            ->addIndexColumn()->make(true);
        }
        return view('todos.index');
    }

    public function index_all(Request $request)
    {
        $user = User::all();
        $query = DB::table('todos')->join('users', 'todos.user_id', '=', 'users.id')->select('todos.*', 'users.name')->orderBy('todos.updated_at','desc')->get();

        $filter_user = $request->filters['user_id'];
        if(!empty($filter_user) && ucwords($filter_user) !== 'Semua'){
            $query = $query->where('user_id', $filter_user);
        }
        // Search for a status
        $status = $request->filters['status'];
        if(!empty($status) && ucwords($status) !== 'Semua'){
            $query = $query->where('status', $status);
        }

        if(request()->ajax()) {
            return Datatables::of($query)->addIndexColumn()->make(true);
        }
        return view('todos.index@all', compact('user'));
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

        $id = $request->id;
        $attributes = ['activity' => $request->activity, 'income' => $request->income, 'outcome' => $request->outcome, 'activity_detail' => $request->activity_detail,'status' => $request->status,'user_id' => $request->user_id];
        $post   =   Todo::updateOrCreate(['id' => $id], $attributes);
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
        $update  = Todo::find($id);
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
