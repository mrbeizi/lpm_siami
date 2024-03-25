<?php

namespace App\Http\Controllers\Faculty;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\General\Announcement;
use App\Models\General\News;

class DashboardController extends Controller
{
    public function index()
    {
        $getAnnouncement = Announcement::select('id','title','publish_date','attachment','updated_at')->orderBy('id','DESC')->get();
        $getNews = News::select('id','title','publish_date','attachment','updated_at')->orderBy('id','DESC')->get();
        return view('faculty.dashboard', compact('getAnnouncement','getNews'));
    }
}
