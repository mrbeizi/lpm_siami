<?php

namespace App\Http\Controllers\Auditors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Implementation\DocumentImplementation;
use App\Models\Implementation\FileDocumentImplementation;
use App\Models\General\Faculty;
use App\Models\Auditors\Auditor;
use Illuminate\Support\Facades\Storage;
use Auth;
use DB;
use File;
use Redirect;

class DashboardDocsController extends Controller
{
    public function index(Request $request)
    {

        $search = Auditor::leftJoin('users','users.id_employee','=','auditors.id_employee')
            ->leftJoin('employees','employees.id','=','auditors.id_employee')
            ->leftJoin('faculties','faculties.id','=','auditors.id_faculty')
            ->leftJoin('departments','departments.id','=','auditors.id_department')
            ->select('auditors.id AS id','auditors.id_department','faculties.faculty_name','departments.department_name')
            ->where('users.id_employee',Auth::user()->id_employee)
            ->get();
        if($search->count() > 0){
            foreach($search as $s){
                $check = $s->id_department;
            }
        }
        if($check == $request->id_department){
            if($request->id_department == '') {
                $datas = DocumentImplementation::leftJoin('file_document_implementations AS fdi','fdi.id_document_implementation','=','document_implementations.id')
                    ->leftJoin('periods','periods.id','=','document_implementations.id_period')
                    ->where('fdi.id_department',0)
                    ->orderBy('document_implementations.id','ASC')
                    ->get();
            } else {
                $datas = DocumentImplementation::leftJoin('periods','periods.id','=','document_implementations.id_period')
                    ->leftJoin('file_document_implementations AS fdi','fdi.id_document_implementation','=','document_implementations.id')
                    ->select('document_implementations.id AS id','document_implementations.doc_name','fdi.id AS id_fdi','fdi.fdi_name','fdi.uploaded_file','fdi.validate','fdi.id_department')
                    ->where([['document_implementations.is_archive',0],['periods.is_active',1],['fdi.id_department',$request->id_department]])
                    ->orderBy('document_implementations.id','ASC')
                    ->get();
            }
        } else {
            $datas = DocumentImplementation::leftJoin('file_document_implementations AS fdi','fdi.id_document_implementation','=','document_implementations.id')
                ->leftJoin('periods','periods.id','=','document_implementations.id_period')
                ->where('fdi.id_department',0)
                ->orderBy('document_implementations.id','ASC')
                ->get();
        }

        if($request->ajax()){
            return datatables()->of($datas)
            ->addColumn('action', function($data){
                if($data->id == 1 || $data->id == 3){
                    $button = '<a href="'.asset('dokumen-uploads/doc-implementasi/'.$data->uploaded_file.'').'" target="_blank" name="see-file" data-toggle="tooltip" data-placement="bottom" title="See document" data-id="'.$data->id.'" data-placement="bottom" data-original-title="seedocs" class="seedocs btn btn-warning btn-xs show-post"><i class="bx bx-xs bx-show-alt"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="'.asset('dokumen-uploads/doc-implementasi/'.$data->uploaded_file.'').'" target="_blank" data-toggle="tooltip" data-id="'.$data->id.'" data-toggle="tooltip" data-placement="bottom" title="Download" data-original-title="Download" class="download btn btn-info btn-xs download-post"><i class="bx bx-xs bx-download"></i></a>';
                    return $button;
                }elseif($data->id == 2){
                    $button = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$data->id.'" data-iddocs="'.$data->id_docim.'" data-toggle="tooltip" data-placement="bottom" title="Upload" data-original-title="Upload" class="upload btn btn-primary btn-xs"><i class="bx bx-xs bx-upload"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="'.asset('dokumen-uploads/doc-implementasi/'.$data->uploaded_file.'').'" target="_blank" name="see-file" data-toggle="tooltip" data-placement="bottom" title="See document" data-id="'.$data->id.'" data-placement="bottom" data-original-title="seedocs" class="seedocs btn btn-warning btn-xs show-post"><i class="bx bx-xs bx-show-alt"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$data->id.'" data-toggle="tooltip" data-placement="bottom" title="Edit" data-original-title="Edit" class="edit btn btn-success btn-xs edit-post"><i class="bx bx-xs bx-edit"></i></a>';
                    return $button;
                }elseif($data->id == 4){
                    $button = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$data->id.'" data-toggle="tooltip" data-placement="bottom" title="Edit" data-original-title="Edit" class="edit btn btn-primary btn-xs edit-post"><i class="bx bx-xs bx-list-check"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="'.asset('dokumen-uploads/doc-implementasi/'.$data->uploaded_file.'').'" target="_blank" name="see-file" data-toggle="tooltip" data-placement="bottom" title="See document" data-id="'.$data->id.'" data-placement="bottom" data-original-title="seedocs" class="seedocs btn btn-warning btn-xs show-post"><i class="bx bx-xs bx-show-alt"></i></a>';
                    return $button;
                } elseif($data->id == 8) {
                    $button = '<a href="'.asset('dokumen-uploads/doc-implementasi/'.$data->uploaded_file.'').'" target="_blank" name="see-file" data-toggle="tooltip" data-placement="bottom" title="See document" data-id="'.$data->id.'" data-placement="bottom" data-original-title="seedocs" class="seedocs btn btn-warning btn-xs show-post"><i class="bx bx-xs bx-show-alt"></i></a>';
                    return $button;
                } else {
                    $button = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$data->id.'" data-iddocs="'.$data->id_docim.'" data-toggle="tooltip" data-placement="bottom" title="Upload" data-original-title="Upload" class="upload btn btn-primary btn-xs"><i class="bx bx-xs bx-upload"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="'.asset('dokumen-uploads/doc-implementasi/'.$data->uploaded_file.'').'" target="_blank" name="see-file" data-toggle="tooltip" data-placement="bottom" title="See document" data-id="'.$data->id.'" data-placement="bottom" data-original-title="seedocs" class="seedocs btn btn-warning btn-xs show-post"><i class="bx bx-xs bx-show-alt"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$data->id.'" data-toggle="tooltip" data-placement="bottom" title="Edit" data-original-title="Edit" class="edit btn btn-success btn-xs edit-post"><i class="bx bx-xs bx-edit"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="'.$data->id.'" data-toggle="tooltip" data-placement="bottom" title="Delete" class="delete btn btn-danger btn-xs"><i class="bx bx-xs bx-trash"></i></button>';
                    return $button;
                }
            })->addColumn('state', function($data){
                $states = $this->getState($data->id);
                if($states != 'x'){
                    if($states['validate'] == 1){
                        return '<span class="badge bg-label-success me-1">Uploaded</span>';
                    }elseif($states['validate'] == 2){
                        return '<span class="badge bg-label-warning me-1">Pending</span>';
                    }else{
                        return '<span class="badge bg-label-danger me-1">No data</span>';
                    }
                }else{
                    return '<span class="badge bg-label-danger me-1">No data</span>';
                }
            })
            ->rawColumns(['action','state'])
            ->addIndexColumn(true)
            ->make(true);
        }
        $getFaculty = Faculty::select('faculty_name','id')->get();
        return view('auditors.dashboard-docs.index', compact('getFaculty','search'));
    }

    public function faculties($id)
    {
        $datas = Faculty::leftJoin('departments','departments.id_faculty','=','faculties.id')
            ->where('departments.id_faculty',$id)
            ->pluck('departments.department_name','departments.id');
        return json_encode($datas);
    }

    protected function getState($idFile)
    {
        $datas = FileDocumentImplementation::select('validate')->where('id',$idFile)->first();
        if($datas){
            return $datas;
        }else{
            return 'x';
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'mimes:pdf|max:2000',
        ],[
            'file.mimes' => 'Format berkas harus .pdf',
            'file.max' => 'Ukuran file lebih dari 2MB'
        ]);

        if($files = $request->file('file')) {
            $berkas = $files->getClientOriginalName();
            $path = public_path().'/dokumen-uploads/doc-implementasi/';

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

        $post = FileDocumentImplementation::where('id',$request->id)->update(
                [
                    'uploaded_file' => $berkas,
                    'link'    => $request->link,
                    'validate'    => 1,
                ]); 

        return response()->json($post);
    }
}
