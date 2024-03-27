<?php

namespace App\Http\Controllers\LPM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lpm\Auditee;
use App\Models\General\Faculty;
use App\Models\General\Department;
use App\Models\General\Period;
use App\Models\General\Employee;

class AuditeeController extends Controller
{
    public function index(Request $request)
    {
        $datas = Auditee::leftJoin('faculties','faculties.id','=','auditees.id_faculty')
            ->leftJoin('departments','departments.id','=','auditees.id_department')
            ->leftJoin('employees AS d','d.id','=','auditees.dekan')
            ->leftJoin('employees AS sd','sd.id','=','auditees.sekretaris_dekan')
            ->leftJoin('employees AS ko','ko.id','=','auditees.ko_prodi')
            ->select('auditees.id AS id','faculties.faculty_name','departments.department_name','d.name AS dekan','sd.name AS sekretaris_dekan','ko.name AS ko_prodi')
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
        $getPeriod = Period::select('title','id','is_active')->get();
        $getEmployee = Employee::select('id','name')->get();
        return view('lpm.auditee.index', compact('getFaculty','getPeriod','getEmployee'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_periode' => 'required',
            'id_faculty' => 'required',
            'id_department' => 'required',
            'dekan' => 'required',
        ],[
            'id_periode.required' => 'Anda belum memilih periode',
            'id_faculty.required' => 'Anda belum memilih nama fakultas',
            'id_department.required' => 'Anda belum memilih nama prodi',
            'dekan.required' => 'Anda belum memilih nama dekan',
        ]);

        $post = Auditee::updateOrCreate(['id' => $request->id],
                [
                    'id_faculty'          => $request->id_faculty,
                    'id_department'    => $request->id_department,
                    'dekan'          => $request->dekan,
                    'sekretaris_dekan'  => $request->sekretaris_dekan,
                    'ko_prodi'          => $request->ko_prodi,
                    'id_periode'          => $request->id_periode,
                ]); 

        return response()->json($post);
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = Auditee::where($where)->first();
     
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = Auditee::where('id',$id)->delete();     
        return response()->json($post);
    }

    public function prodi(Request $request)
    {
        $data['department'] = Department::where("id_faculty", $request->id_faculty)->get(["department_name","id"]);
        return response()->json($data);

    }
}
