<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\General\Department;
use App\Models\General\Faculty;

class DepartmentController extends Controller
{
    public function index(Request $request)
    {
        $datas = Department::leftJoin('faculties','faculties.id','=','departments.id_faculty')
            ->select('departments.id AS id','departments.department_name','faculties.faculty_name')
            ->orderBy('departments.id','DESC')
            ->get();

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
        $getFaculty = Faculty::select('faculties.id','faculties.faculty_name')->get();
        return view('general.department.index', compact('getFaculty'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'department_name' => 'required',
            'id_faculty' => 'required',
            'id_periode' => 'required',
        ],[
            'department_name.required' => 'Anda belum menginput nama prodi',
            'id_faculty.required' => 'Anda belum memilih fakultas',
            'id_periode.required' => 'Anda belum memilih periode',
        ]);

        $post = Department::updateOrCreate(['id' => $request->id],
                [
                    'department_name'   => $request->department_name,
                    'id_faculty'   => $request->id_faculty,
                    'id_periode'     => $request->id_periode,
                ]); 

        return response()->json($post);
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = Department::where($where)->first();
     
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = Department::where('id',$id)->delete();     
        return response()->json($post);
    }
}
