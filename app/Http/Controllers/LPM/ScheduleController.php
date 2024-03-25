<?php

namespace App\Http\Controllers\LPM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lpm\Schedule;
use App\Models\Lpm\Auditee;
use App\Models\Auditors\Auditor;
use App\Models\General\Employee;
use Carbon\Carbon;

class ScheduleController extends Controller
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
                if($data->start_date == '' and $data->end_date == '' and $data->auditor_chief == '' and $data->auditor_member == ''){
                    $button = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$data->id.'" data-toggle="tooltip" data-placement="bottom" title="Adjust Schedule" data-original-title="Adjust Schedule" class="adjust btn btn-warning btn-xs adjust-post"><i class="bx bx-xs bx-body"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$data->id_schedule.'" data-toggle="tooltip" data-placement="bottom" title="Edit Schedule" data-original-title="Edit Schedule" class="edit btn btn-success btn-xs edit-post disabled"><i class="bx bx-xs bx-edit"></i></a>';
                    return $button;
                } else {
                    $button = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$data->id.'" data-toggle="tooltip" data-placement="bottom" title="Adjust Schedule" data-original-title="Adjust Schedule" class="adjust btn btn-warning btn-xs adjust-post disabled"><i class="bx bx-xs bx-body"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$data->id_schedule.'" data-auditee="'.$data->id.'" data-toggle="tooltip" data-placement="bottom" title="Edit Schedule" data-original-title="Edit Schedule" class="edit btn btn-success btn-xs edit-post"><i class="bx bx-xs bx-edit"></i></a>';
                    return $button;
                }
            })->addColumn('interval', function($data){
                $interval = Carbon::parse($data->start_date)->diffInDays(Carbon::parse($data->end_date));
                return $interval;
            })
            ->rawColumns(['action','interval'])
            ->addIndexColumn(true)
            ->make(true);
        }
        $getEmployee = Employee::select('employees.id','employees.name')->get();        
        return view('lpm.schedule.index',['getEmployee' => $getEmployee]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'start_date' => 'required',
        ],[
            'start_date.required' => 'Anda belum memilih tanggal mulai',
        ]);

        $post = Schedule::updateOrCreate(['id' => $request->id],
                [
                    'id_auditee'  => $request->idAuditee,
                    'start_date'  => $request->start_date,
                    'end_date'  => $request->end_date,
                    'auditor_chief'  => $request->auditor_chief,
                    'auditor_member'  => $request->auditor_member,
                ]); 

        return response()->json($post);
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = Schedule::where($where)->first();
     
        return response()->json($post);
    }

    public function getIdAuditee(Request $request)
    {
        $dataAuditee = Auditee::leftJoin('faculties','faculties.id','=','auditees.id_faculty')
            ->leftJoin('departments','departments.id','=','auditees.id_department')
            ->leftJoin('employees AS d','d.id','=','auditees.dekan')
            ->leftJoin('employees AS sd','sd.id','=','auditees.sekretaris_dekan')
            ->leftJoin('employees AS ko','ko.id','=','auditees.ko_prodi')
            ->select('auditees.id AS id','faculties.faculty_name','departments.department_name','d.name AS dekan','sd.name AS sekretaris_dekan','ko.name AS ko_prodi')
            ->where('auditees.id',$request->id)
            ->get();

            if($dataAuditee->count() > 0){
                foreach($dataAuditee as $item){
                    $content = '<table class="table table-borderless table-sm">
                        <tbody>
                            <tr><td>Auditee</td><td>:</td><td>'.$item->faculty_name.' - '.$item->department_name.'</td></tr>
                            <tr><td>Dekan</td><td>:</td><td>'.$item->dekan.'</td></tr>
                            <tr><td>Sekretaris Dekan</td><td>:</td><td>'.$item->sekretaris_dekan.'</td></tr>
                            <tr><td>Koordinator Prodi</td><td>:</td><td>'.$item->ko_prodi.'</td></tr>
                        </tbody>
                    </table>';
                }
            } else {
                $content = '<table class="table table-borderless table-sm">
                        <tbody>
                            <tr><td>Auditee</td><td>:</td><td>No data available</td></tr>
                            <tr><td>Dekan</td><td>:</td><td>No data available</td></tr>
                            <tr><td>Sekretaris Dekan</td><td>:</td><td>No data available</td></tr>
                            <tr><td>Koordinator Prodi</td><td>:</td><td>No data available</td></tr>
                        </tbody>
                    </table>';
            }

        return response()->json(['data' => $content]);
    }
}
