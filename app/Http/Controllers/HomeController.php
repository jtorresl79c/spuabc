<?php

namespace App\Http\Controllers;

use App\Almacenes;
use Illuminate\Http\Request;

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
        $Alm = Almacenes::all();
        return view('home')->with('Alm',$Alm);
    }
}
