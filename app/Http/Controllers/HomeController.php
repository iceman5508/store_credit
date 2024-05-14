<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        if(!empty(Auth::user()->store_id)){
            return view('dashboard.index');
        }
        return redirect('dashboard/addStore');

    }


    public function preLogout(){
        Auth::user()->store_id = 0;
        Auth::user()->save();
        return redirect()->route('logout');
    }
}
