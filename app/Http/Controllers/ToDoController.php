<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Redirect, Response, DB, Hash;
use App\Todo;

class ToDoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(request()->ajax()) {
            return Datatables::of(Todo::query())->addColumn('action', function($get){
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
        return view('todos.index');
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
