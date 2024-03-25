<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\General\Announcement;
use App\Models\General\News;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:employee,web,auditor');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $getAnnouncement = Announcement::select('id','title','publish_date','attachment','updated_at')->orderBy('id','DESC')->get();
        $getNews = News::select('id','title','publish_date','attachment','updated_at')->orderBy('id','DESC')->get();
        return view('dashboard', compact('getAnnouncement','getNews'));
    }
}
