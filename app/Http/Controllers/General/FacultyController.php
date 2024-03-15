<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\General\Faculty;

class FacultyController extends Controller
{
    public function index(Request $request)
    {
        $datas = Faculty::all();

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
        return view('general.faculty.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'faculty_name' => 'required',
            'id_periode' => 'required',
        ],[
            'faculty_name.required' => 'Anda belum menginputkan nama fakultas',
            'id_periode.required' => 'Anda belum memilih periode',
        ]);

        $post = Faculty::updateOrCreate(['id' => $request->id],
                [
                    'faculty_name'   => $request->faculty_name,
                    'id_periode'     => $request->id_periode,
                ]); 

        return response()->json($post);
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = Faculty::where($where)->first();
     
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = Faculty::where('id',$id)->delete();     
        return response()->json($post);
    }
}
