<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\General\StandardPeriod;

class StandardPeriodController extends Controller
{
    public function index(Request $request)
    {
        $datas = StandardPeriod::where('is_archive',0)->get();
        if($request->ajax()){
            return datatables()->of($datas)
            ->addColumn('setting', function($data){
                return '<a href="'.Route('setting.std',['id' => $data->id]).'" name="setting" class="dropdown-shortcuts-add text-body setting" data-id="'.$data->id.'" data-bs-toggle="tooltip" data-bs-placement="bottom" title="Manage Standard"><span class="badge bg-label-primary"><i class="bx bx-xs bx-cog bx-spin-hover"></i> '.'| '.$data->title.'</span></a>';
            })->addColumn('action', function($data){                
                $button = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$data->id.'" data-toggle="tooltip" data-placement="bottom" title="Edit" data-original-title="Edit" class="edit btn btn-success btn-xs edit-post"><i class="bx bx-xs bx-edit"></i></a>';
                $button .= '&nbsp;&nbsp;';
                $button .= '<button type="button" name="delete" id="'.$data->id.'" data-toggle="tooltip" data-placement="bottom" title="Delete" class="delete btn btn-danger btn-xs"><i class="bx bx-xs bx-trash"></i></button>';
                $button .= '&nbsp;&nbsp;';
                $button .= '<a href="javascript:void(0)" name="archive-std" data-toggle="tooltip" data-placement="bottom" title="Archive" onclick="archiveStd('.$data->id.','.$data->is_archive.')" data-id="'.$data->id.'" data-placement="bottom" data-original-title="archivestd" class="archivestd btn btn-warning btn-xs archive-post"><i class="bx bx-xs bx-archive"></i></a>';              
                return $button;
            })->addColumn('state', function($data){
                return '<div class="custom-control">
                <label class="switch switch-primary" for="'.$data->id.'">
                <input type="checkbox" class="switch-input" onclick="PeriodeStatus('.$data->id.','.$data->is_active.')" name="period-status" id="'.$data->id.'" '.(($data->is_active=='1')?'checked':"").'>
                <span class="switch-toggle-slider"><span class="switch-on"><i class="bx bx-check"></i></span><span class="switch-off"><i class="bx bx-x"></i></span></span></label></div>';
            })
            ->rawColumns(['setting','action','state'])
            ->addIndexColumn(true)
            ->make(true);
        }
        return view('general.standard-period.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
        ],[
            'title.required' => 'Anda belum menginputkan judul standard periode',
        ]);

        $checkState = StandardPeriod::where('is_active','=',1)->get();
        $isActive = $request->input('is_active');
        if($checkState->count() > 0){
            foreach($checkState as $data){
                if($isActive == null) {
                    $isActive = 0;
                } else {
                    $data->update(['is_active' => 0]);
                    $isActive = 1;
                }
            }
        } else {
            $isActive = 1;
        }   

        $post = StandardPeriod::updateOrCreate(['id' => $request->id],
                [
                    'title' => $request->title,
                    'is_active'  => $isActive,
                    'is_archive'  => 0,
                ]); 

        return response()->json($post);
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = StandardPeriod::where($where)->first();
     
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = StandardPeriod::where('id',$id)->delete();     
        return response()->json($post);
    }

    public function switchPeriode(Request $request)
    {
        $checkState = StandardPeriod::where('is_active','=',1)->get();
        $req    = $request->is_active == '1' ? 0 : 1;
        foreach($checkState as $data){
            if($req == '1'){
                $data->update(['is_active' => 0]);
                $req = 1;
            } else {
                $data->update(['is_active' => 1]);
                $req = 0;
            }
        }

        $post = StandardPeriod::updateOrCreate(['id' => $request->id],['is_active' => $req]); 
        return response()->json($post);
    }

    public function archiveStd(Request $request)
    {
        $req    = $request->is_archive == '1' ? 0 : 1;
        $post   = StandardPeriod::updateOrCreate(['id' => $request->id],['is_archive' => $req, 'archived_at' => now()]); 
        return response()->json($post);
    }
}
