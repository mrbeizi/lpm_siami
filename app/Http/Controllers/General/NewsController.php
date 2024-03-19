<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\General\News;
use App\Models\Lpm\UserRole;
use Illuminate\Support\Facades\Storage;
use File;
use Redirect;
use Auth;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $datas = News::all();

        if($request->ajax()){
            return datatables()->of($datas)
            ->addColumn('action', function($data){
                $button = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$data->id.'" data-toggle="tooltip" data-placement="bottom" title="Edit" data-original-title="Edit" class="edit btn btn-success btn-xs edit-post"><i class="bx bx-xs bx-edit"></i></a>';
                $button .= '&nbsp;&nbsp;';
                $button .= '<button type="button" name="delete" id="'.$data->id.'" data-toggle="tooltip" data-placement="bottom" title="Delete" class="delete btn btn-danger btn-xs"><i class="bx bx-xs bx-trash"></i></button>';

                return $button;
            })
            ->rawColumns(['action'])
            ->addIndexColumn(true)
            ->make(true);
        }
        $getRole = UserRole::all();
        return view('general.news.index', compact('getRole'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_periode' => 'required',
            'title' => 'required',
            'publish_date' => 'required',
            'end_date' => 'required',
        ],[
            'id_periode.required' => 'Anda belum memilih periode',
            'title.required' => 'Anda belum menginputkan judul',
            'publish_date.required' => 'Anda belum menentukan tanggal terbit',
            'end_date.required' => 'Anda belum menentukan tanggal akhir'
        ]);


        $post = News::updateOrCreate(['id' => $request->id],
                [
                    'id_periode' => $request->id_periode,
                    'title' => $request->title,
                    'publish_date'  => $request->publish_date,
                    'end_date'  => $request->end_date,
                    'attachment' => $request->attachment,
                    'role_id'    => implode(',', (array) $request['role_id']),
                    'added_by' => Auth::user()->id,
                ]); 

        return response()->json($post);
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = News::where($where)->first();
     
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = News::where('id',$id)->delete();     
        return response()->json($post);
    }
}
