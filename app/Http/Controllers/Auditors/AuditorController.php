<?php

namespace App\Http\Controllers\Auditors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Auditors\Auditor;
use App\Models\General\Faculty;
use App\Models\General\Department;
use App\Models\General\Employee;
use App\Models\General\Period;
use App\Models\Implementation\DocumentImplementation;
use App\Models\Implementation\FileDocumentImplementation;
use App\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use File;
use Redirect;

class AuditorController extends Controller
{
    public function index(Request $request)
    {
        $datas = Auditor::leftJoin('faculties','faculties.id','=','auditors.id_faculty')
            ->leftJoin('departments','departments.id','=','auditors.id_department')
            ->leftJoin('employees','employees.id','=','auditors.id_employee')
            ->select('auditors.id AS id','auditors.id_employee','auditors.nidn','employees.name AS auditor_name','auditors.sk_sertifikat_auditor','faculties.faculty_name','departments.department_name')
            ->get();

        if($request->ajax()){
            return datatables()->of($datas)
            ->addColumn('view_document', function($data){
                return '<a href="'.asset('dokumen-uploads/sk-dan-sertifikat/'.$data->id_employee.'/'.$data->sk_sertifikat_auditor.'').'" target="_blank" data-toggle="tooltip" data-id="'.$data->id.'" data-toggle="tooltip" data-placement="bottom" title="Open document" data-original-title="Open" class="view btn btn-outline-primary btn-xs"><i class="bx bx-show"></i></a>';
            })->addColumn('action', function($data){
                $button = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$data->id.'" data-toggle="tooltip" data-placement="bottom" title="Edit" data-original-title="Edit" class="edit btn btn-success btn-xs edit-post"><i class="bx bx-edit"></i></a>';
                $button .= '&nbsp;&nbsp;';
                $button .= '<button type="button" name="delete" id="'.$data->id.'" data-toggle="tooltip" data-placement="bottom" title="Delete" class="delete btn btn-danger btn-xs"><i class="bx bx-trash"></i></button>';
                return $button;
            })
            ->rawColumns(['action','view_document'])
            ->addIndexColumn(true)
            ->make(true);
        }
        $getFaculty = Faculty::select('faculties.id','faculties.faculty_name')->get();
        $getEmployee = Employee::select('employees.id','employees.name')->get();
        $getPeriod = Period::select('title','id','is_active')->get();
        return view('auditors.auditor.index', compact('getFaculty','getEmployee','getPeriod'));
    }

    public function prodi(Request $request)
    {
        $data['department'] = Department::where("id_faculty", $request->id_faculty)->get(["department_name","id"]);
        return response()->json($data);

    }

    public function store(Request $request)
    {
        $request->validate([
            'id_periode' => 'required',
            'auditor_name' => 'required',
            'id_faculty' => 'required',
            'id_department' => 'required',
            'file' => 'mimes:pdf|max:2000',
        ],[
            'id_periode.required' => 'Anda belum memilih periode',
            'auditor_name.required' => 'Anda belum memilih nama auditor',
            'id_faculty.required' => 'Anda belum memilih nama fakultas',
            'id_department.required' => 'Anda belum memilih nama prodi',
            'file.mimes' => 'Format berkas harus .pdf',
            'file.max' => 'Ukuran file lebih dari 2MB'
        ]);

        if($files = $request->file('file')) {
            $berkas = $files->getClientOriginalName();
            $path = public_path().'/dokumen-uploads/sk-dan-sertifikat/'.$request->auditor_name;

            // if(File::exists($path)){
            //     $remove = Auditor::where([['id','=',$request->id],['nidn','=',$request->nidn]])->first();
            //     File::deleteDirectory($path);
            //     Auditor::where([['id','=',$request->id],['nidn','=',$request->nidn]])->delete();
            // } 
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

        # get employee datas to store into user table
        $query = Employee::select('nidn','name','email')->where('id',$request->auditor_name)->get();
        if($query->count() > 0){
            foreach($query as $data){
                $empNIDN = $data->nidn;
                $empName = $data->name;
                $empEmail = $data->email;
            }
        } else {
            $empNIDN = '';
            $empName = 'No name';
            $empEmail = 'temporary@gmail.com';
        }

        $post = Auditor::updateOrCreate(['id' => $request->id],
                [
                    'id_periode'          => $request->id_periode,
                    'nidn'          => $empNIDN,
                    'id_employee'  => $request->auditor_name,
                    'id_faculty'          => $request->id_faculty,
                    'id_department'    => $request->id_department,
                    'sk_sertifikat_auditor' => $berkas,
                ]);                 

                # Create new account as auditor
                $post = User::updateOrCreate(['id' => $request->id],
                [
                    'id_employee' => $request->auditor_name,
                    'name' => $empName,
                    'email' => $empEmail,
                    'password' => Hash::make('123456'),
                    'role_id' => 2,
                ]);

                # Then insert all document implementation according to the id department
                $docs = DocumentImplementation::select('id','doc_name')->get();
                foreach($docs as $result){
                    $blankInsert[] = [
                        'fdi_name' => $result->doc_name,
                        'id_document_implementation' => $result->id,
                        'id_category' => 1,
                        'id_department' => $request->id_department,
                        'validate' => 0,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]; 
                }
                $post = FileDocumentImplementation::insert($blankInsert);

        return response()->json($post);
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = Auditor::where($where)->first();
     
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = Auditor::where('id',$id)->delete();     
        return response()->json($post);
    }
}
