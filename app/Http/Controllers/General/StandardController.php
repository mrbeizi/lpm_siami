<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\General\Standard;

class StandardController extends Controller
{
    public function manageStandard($id)
    {
        $standards = Standard::where([['parent_id', '=', 0],['id_standard_period',$id]])->get();
        // $allStandards = Standard::pluck('name','id')->all();
        $allStandards = Standard::select('id','name','parent_id')->where('id_standard_period',$id)->get();
        return view('general.standard.standardTreeview',['standards' => $standards,'allStandards' => $allStandards,'idStd' => $id]);
    }

    public function addStandard(Request $request)
    {
        $this->validate($request, [
        		'name' => 'required',
        	]);
        // $input = $request->all();
        // $input['parent_id'] = empty($input['parent_id']) ? 0 : $input['parent_id'];
        // $post = Standard::create($input);

        if(empty($request->parent_id)){
            $parent_id = 0;
        } else {
            $parent_id = $request->parent_id;
        }

        $post = Standard::updateOrCreate(['id' => $request->id],
                [
                    'name' => $request->name,
                    'parent_id'  => $parent_id,
                    'id_standard_period'  => $request->idStd,
                ]); 
        return response()->json($post);
    }

    public function indexStandard(Request $request)
    {
        $datas = Standard::where('id_standard_period',$request->idStd)->get();
        if($request->ajax()){
            return datatables()->of($datas)
            ->addColumn('action', function($data){
                return '<button type="button" name="delete" id="'.$data->id.'" data-toggle="tooltip" data-placement="bottom" title="Delete" class="delete btn btn-danger btn-xs"><i class="bx bx-xs bx-trash"></i></button>';
            })
            ->rawColumns(['action'])
            ->addIndexColumn(true)
            ->make(true);
        }
        return view('general.standard.standardTreeview', compact('datas'));
    }

    public function deleteStandard(Request $request)
    {
        $post = Standard::where('id',$request->id)->delete();     
        return response()->json($post);
    }
}
