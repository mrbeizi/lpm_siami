<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\General\Period;
use App\Models\General\Standard;
use Carbon\Carbon;

class PeriodController extends Controller
{
    public function index(Request $request)
    {
        $datas = Period::orderBy('id','DESC')->get();

        if($request->ajax()){
            return datatables()->of($datas)
            ->addColumn('action', function($data){
                $button = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$data->id.'" data-toggle="tooltip" data-placement="bottom" title="Edit" data-original-title="Edit" class="edit btn btn-success btn-xs edit-post"><i class="bx bx-xs bx-edit"></i></a>';
                $button .= '&nbsp;&nbsp;';
                $button .= '<button type="button" name="delete" id="'.$data->id.'" data-toggle="tooltip" data-placement="bottom" title="Delete" class="delete btn btn-danger btn-xs"><i class="bx bx-xs bx-trash"></i></button>';

                return $button;
            })->addColumn('state', function($data){
                return '<div class="custom-control">
                <label class="switch switch-primary" for="'.$data->id.'">
                <input type="checkbox" class="switch-input" onclick="PeriodeStatus('.$data->id.','.$data->is_active.')" name="period-status" id="'.$data->id.'" '.(($data->is_active=='1')?'checked':"").'>
                <span class="switch-toggle-slider"><span class="switch-on"><i class="bx bx-check"></i></span><span class="switch-off"><i class="bx bx-x"></i></span></span></label></div>';
            })->addColumn('interval', function($data){
                $interval = Carbon::parse($data->start_date)->diffInDays(Carbon::parse($data->end_date));
                return $interval;
            })
            ->rawColumns(['action','state','interval'])
            ->addIndexColumn(true)
            ->make(true);
        }

        $datas = Standard::where('parent_id', '=', 0)->get();
        $tree='<ul id="browser" class="filetree">';
        foreach ($datas as $standard) {
             $tree .='<li class="tree-view closed"<a class="tree-name">'.$standard->name.'</a>';
             if(count($standard->childs)) {
                $tree .=$this->childView($standard);
            }
        }
        $tree .='<ul>';

        return view('general.period.index', compact('tree'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required',
            'start_date' => 'required',
        ],[
            'title.required' => 'Anda belum menginputkan judul periode',
            'start_date.required' => 'Anda belum memilih tanggal mulai',
        ]);

        $checkState = Period::where('is_active','=',1)->get();
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

        $post = Period::updateOrCreate(['id' => $request->id],
                [
                    'title' => $request->title,
                    'start_date'  => $request->start_date,
                    'end_date'  => $request->end_date,
                    'is_active'  => $isActive,
                ]); 

        return response()->json($post);
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = Period::where($where)->first();
     
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = Period::where('id',$id)->delete();     
        return response()->json($post);
    }

    public function switchPeriode(Request $request)
    {
        $checkState = Period::where('is_active','=',1)->get();
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

        $post = Period::updateOrCreate(['id' => $request->id],['is_active' => $req]); 
        return response()->json($post);
    }

    public function switchPeriodeMain(Request $request)
    {
        $datas = Period::select('is_active')->where('id',$request->id)->get();
        if($datas->count() > 0){
            foreach($datas as $data){
                if($data->is_active == '1'){
                    $data->update(['is_active' => 0]);
                    $req = 1;
                } else {
                    $data->update(['is_active' => 1]);
                    $req = 0;
                }
            }
        }
        $post = Period::updateOrCreate(['id' => $request->id],['is_active' => $req]); 
        return response()->json($post);
    }

    public function standardTreeView()
    {
        $datas = Standard::where('parent_id', '=', 0)->get();
        $tree='<ul id="browser" class="filetree"><li class="tree-view"></li>';
        foreach ($datas as $standard) {
             $tree .='<li class="tree-view closed"<a class="tree-name">'.$standard->name.'</a>';
             if(count($standard->childs)) {
                $tree .=$this->childView($standard);
            }
        }
        $tree .='<ul>';
        // return $tree;
        return view('general.period.index',compact('tree'));
    }

    public function childView($standard){                 
        $html ='<ul>';
        foreach ($standard->childs as $arr) {
            if(count($arr->childs)){
                $html .='<li class="tree-view closed"><a class="tree-name">'.$arr->name.'</a>';                  
                $html .= $this->childView($arr);
                }else{
                    $html .='<li class="tree-view"><a class="tree-name">'.$arr->name.'</a>';                                 
                    $html .="</li>";
                }
                               
        }
        
        $html .="</ul>";
        return $html;
    }    
}
