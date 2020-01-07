<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Todo;
use App\User;
use DB;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $awal = date('Y-m-d', mktime(0,0,0, date('m'), 1, date('Y')));
        $akhir = date('Y-m-d');

        $tanggal = $awal;
        $data_tanggal = array();
        $data_pendapatan = array();
        $data_pengeluaran = array();

        while(strtotime($tanggal) <= strtotime($akhir)){ 
            $data_tanggal[] = (int)substr($tanggal,8,2);
            $id = auth()->user()->id;
            $income = DB::table('todos')->where('todos.user_id', $id)->where('created_at', 'LIKE', "$tanggal%")->sum('income');
            $outcome = DB::table('todos')->where('todos.user_id', $id)->where('created_at', 'LIKE', "$tanggal%")->sum('outcome');
            $data_pendapatan[] = (int) $income;
            $data_pengeluaran[] = (int) $outcome;

            $tanggal = date('Y-m-d', strtotime("+1 day", strtotime($tanggal)));
        }

        return view('home',compact('awal','akhir','data_tanggal','data_pendapatan','data_pengeluaran'));
    }
}
