<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\General\Announcement;
use App\Models\Lpm\UserRole;
use Illuminate\Support\Facades\Storage;
use File;
use Redirect;
use Auth;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $datas = Announcement::all();

        if($request->ajax()){
            return datatables()->of($datas)
            ->addColumn('action', function($data){
                $button = '<a href="'.asset('dokumen-uploads/'.$data->id.'/announcement/'.$data->id.'/'.$data->attachment.'').'" target="_blank" data-toggle="tooltip" data-id="'.$data->id.'" data-toggle="tooltip" data-placement="bottom" title="Open document" data-original-title="Open" class="view btn btn-primary btn-xs"><i class="bx bx-xs bx-show"></i></a>';
                $button .= '&nbsp;&nbsp;';
                $button .= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$data->id.'" data-toggle="tooltip" data-placement="bottom" title="Edit" data-original-title="Edit" class="edit btn btn-success btn-xs edit-post"><i class="bx bx-xs bx-edit"></i></a>';
                $button .= '&nbsp;&nbsp;';
                $button .= '<button type="button" name="delete" id="'.$data->id.'" data-toggle="tooltip" data-placement="bottom" title="Delete" class="delete btn btn-danger btn-xs"><i class="bx bx-xs bx-trash"></i></button>';

                return $button;
            })
            ->rawColumns(['action'])
            ->addIndexColumn(true)
            ->make(true);
        }
        $getRole = UserRole::all();
        return view('general.announcement.index', compact('getRole'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_periode' => 'required',
            'title' => 'required',
            'publish_date' => 'required',
            'end_date' => 'required',
            'file' => 'mimes:pdf|max:4000',
        ],[
            'id_periode.required' => 'Anda belum memilih periode',
            'title.required' => 'Anda belum menginputkan judul',
            'publish_date.required' => 'Anda belum menentukan tanggal terbit',
            'end_date.required' => 'Anda belum menentukan tanggal akhir',
            'file.mimes' => 'Format berkas harus .pdf',
            'file.max' => 'Ukuran file lebih dari 4MB'
        ]);

        if($files = $request->file('file')) {
            $berkas = $files->getClientOriginalName();
            $path = public_path().'/dokumen-uploads/'.$request->id.'/announcement/'.$request->id;

            if(File::exists($path)){
                $remove = Announcement::where([['id','=',$request->id]])->first();
                File::deleteDirectory($path);
                Announcement::where([['id','=',$request->id]])->delete();
            } 
            if(empty($errors)==true){
                if(!File::isDirectory($path)){
                    Storage::makeDirectory($path);
                }
                if(File::isDirectory("$path/".$berkas)==false){
                    $files->move("$path/",$berkas);
                } else { 
                    return Redirect::back()->with('error', 'Terjadi Kesalahan');
                }
            }else{
                print_r($errors);
            }
        }

        $post = Announcement::updateOrCreate(['id' => $request->id],
                [
                    'id_periode' => $request->id_periode,
                    'title' => $request->title,
                    'publish_date'  => $request->publish_date,
                    'end_date'  => $request->end_date,
                    'content'    => $request->content,
                    'attachment' => $berkas,
                    'role_id'    => implode(',', (array) $request['role_id']),
                    'added_by' => Auth::user()->id,
                ]); 

        return response()->json($post);
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = Announcement::where($where)->first();
     
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = Announcement::where('id',$id)->delete();     
        return response()->json($post);
    }
}
