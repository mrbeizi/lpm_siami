<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\General\Announcement;

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
        $datas = Announcement::select('id','title','publish_date','attachment','created_at')->orderBy('id','DESC')->get();
        return view('dashboard', compact('datas'));
    }
}
