<?php

namespace App\Http\Controllers\LPM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lpm\Auditee;
use App\Models\General\Faculty;
use App\Models\General\Department;

class AuditeeController extends Controller
{
    public function index(Request $request)
    {
        $datas = Auditee::leftJoin('faculties','faculties.id','=','auditees.id_faculty')
            ->leftJoin('departments','departments.id','=','auditees.id_department')
            ->select('auditees.id AS id','auditees.dekan','auditees.sekretaris_dekan','auditees.ko_prodi','faculties.faculty_name','departments.department_name')
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
        return view('lpm.auditee.index', compact('getFaculty'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_periode' => 'required',
            'id_faculty' => 'required',
            'id_department' => 'required',
            'dekan' => 'required',
            'sekretaris_dekan' => 'required',
            'ko_prodi' => 'required',
        ],[
            'id_periode.required' => 'Anda belum memilih periode',
            'id_faculty.required' => 'Anda belum menginputkan nama fakultas',
            'id_department.required' => 'Anda belum menginputkan nama prodi',
            'dekan.required' => 'Anda belum menginputkan nama dekan',
            'dekan.required' => 'Anda belum menginputkan nama dekan',
            'sekretaris_dekan.required' => 'Anda belum menginputkan nama sekretaris dekan',
            'ko_prodi.required' => 'Anda belum menginputkan nama koprodi',
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
