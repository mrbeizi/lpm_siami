<?php

namespace App\Http\Controllers\LPM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lpm\Auditee;
use App\Models\General\Employee;
use Carbon\Carbon;
use PDF;

class AssignmentLetterController extends Controller
{
    public function index(Request $request)
    {
        $datas = Auditee::leftJoin('schedules','schedules.id_auditee','=','auditees.id')
            ->leftJoin('faculties','faculties.id','=','auditees.id_faculty')
            ->leftJoin('departments','departments.id','=','auditees.id_department')
            ->leftJoin('employees AS auditor_chief','auditor_chief.id','=','schedules.auditor_chief')
            ->leftJoin('employees AS auditor_member','auditor_member.id','=','schedules.auditor_member')
            ->leftJoin('periods','periods.id','=','auditees.id_periode')
            ->select('auditees.id AS id','schedules.id AS id_schedule','faculties.faculty_name','departments.department_name','schedules.start_date','schedules.end_date','auditor_chief.name AS auditor_chief','auditor_member.name AS auditor_member')
            ->where('periods.is_active',1)
            ->orderBy('auditees.id','ASC')
            ->get();

        if($request->ajax()){
            return datatables()->of($datas)
            ->addColumn('action', function($data){
               return '<a href="'.Route('download-assignment-letter',['id' => $data->id]).'" data-toggle="tooltip" target="_blank" data-id="'.$data->id.'" data-toggle="tooltip" data-placement="bottom" title="Print Assignment Letter" data-original-title="Print Assignment Letter" class="print btn btn-primary btn-xs print-post"><i class="bx bx-xs bx-printer"></i></a>';
            })->addColumn('interval', function($data){
                $interval = Carbon::parse($data->start_date)->diffInDays(Carbon::parse($data->end_date));
                return $interval;
            })
            ->rawColumns(['action','interval'])
            ->addIndexColumn(true)
            ->make(true);
        }
        $getEmployee = Employee::select('employees.id','employees.name')->get();

        return view('lpm.assignment-letter.index', ['getEmployee' => $getEmployee]);
    }

    public function downloadAssignmentLetter($id)
    {
        $datas = Auditee::leftJoin('schedules','schedules.id_auditee','=','auditees.id')
            ->leftJoin('faculties','faculties.id','=','auditees.id_faculty')
            ->leftJoin('departments','departments.id','=','auditees.id_department')
            ->leftJoin('employees AS auditor_chief','auditor_chief.id','=','schedules.auditor_chief')
            ->leftJoin('employees AS auditor_member','auditor_member.id','=','schedules.auditor_member')
            ->leftJoin('periods','periods.id','=','auditees.id_periode')
            ->select('auditees.id AS id','schedules.id AS id_schedule','faculties.faculty_name','departments.department_name','schedules.start_date','schedules.end_date','auditor_chief.name AS auditor_chief','auditor_member.name AS auditor_member')
            ->where('periods.is_active',1)
            ->orderBy('auditees.id','ASC')
            ->get();

        $fileName = 'surat_tugas_auditor_'.date(now()).'.pdf';
        $pdf = PDF::loadview('lpm.assignment-letter.pdf-letter',compact('datas'));

        $pdf->setPaper('P');
        $pdf->output();
        $canvas = $pdf->getDomPDF()->getCanvas();

        return $pdf->stream($fileName);
    }
}
