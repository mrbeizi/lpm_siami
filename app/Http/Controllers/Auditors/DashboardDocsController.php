<?php

namespace App\Http\Controllers\Auditors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Implementation\DocumentImplementation;
use App\Models\Implementation\FileDocumentImplementation;
use App\Models\General\Faculty;
use Illuminate\Support\Facades\Storage;
use DB;
use File;
use Redirect;

class DashboardDocsController extends Controller
{
    public function index(Request $request)
    {
        if($request->id_department == '') {
            $datas = DocumentImplementation::leftJoin('file_document_implementations AS fdi','fdi.id_document_implementation','=','document_implementations.id')
                ->where('fdi.id_department',0)
                ->orderBy('document_implementations.id','ASC')
                ->get();
        } else {
            $datas = DocumentImplementation::leftJoin('file_document_implementations AS fdi','fdi.id_document_implementation','=','document_implementations.id')
                ->select('fdi.id AS id','fdi.*','document_implementations.id AS id_docim','document_implementations.doc_name')
                ->where('fdi.id_department',$request->id_department)
                ->orderBy('document_implementations.id','ASC')
                ->get();
        }

        if($request->ajax()){
            return datatables()->of($datas)
            ->addColumn('action', function($data){
                $button = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$data->id.'" data-iddocs="'.$data->id_docim.'" data-toggle="tooltip" data-placement="bottom" title="Upload" data-original-title="Upload" class="upload btn btn-primary btn-xs"><i class="bx bx-xs bx-upload"></i></a>';
                $button .= '&nbsp;&nbsp;';
                $button .= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$data->id.'" data-toggle="tooltip" data-placement="bottom" title="Download" data-original-title="Download" class="download btn btn-info btn-xs download-post"><i class="bx bx-xs bx-download"></i></a>';
                $button .= '&nbsp;&nbsp;';
                $button .= '<a href="javascript:void(0)" name="see-file" data-toggle="tooltip" data-placement="bottom" title="See document" data-id="'.$data->id.'" data-placement="bottom" data-original-title="seedocs" class="seedocs btn btn-warning btn-xs show-post"><i class="bx bx-xs bx-show-alt"></i></a>';
                $button .= '&nbsp;&nbsp;';
                $button .= '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$data->id.'" data-toggle="tooltip" data-placement="bottom" title="Edit" data-original-title="Edit" class="edit btn btn-success btn-xs edit-post"><i class="bx bx-xs bx-edit"></i></a>';
                $button .= '&nbsp;&nbsp;';
                $button .= '<button type="button" name="delete" id="'.$data->id.'" data-toggle="tooltip" data-placement="bottom" title="Delete" class="delete btn btn-danger btn-xs"><i class="bx bx-xs bx-trash"></i></button>';
                return $button;
            })
            ->rawColumns(['action'])
            ->addIndexColumn(true)
            ->make(true);
        }
        $getFaculty = Faculty::select('faculty_name','id')->get();
        return view('auditors.dashboard-docs.index', compact('getFaculty'));
    }

    public function faculties($id)
    {
        $datas = Faculty::leftJoin('departments','departments.id_faculty','=','faculties.id')
            ->where('departments.id_faculty',$id)
            ->pluck('departments.department_name','departments.id');
        return json_encode($datas);
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = FileDocumentImplementation::where($where)->first();
     
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = FileDocumentImplementation::where('id',$id)->delete();     
        return response()->json($post);
    }

    public function store(Request $request)
    {
        $request->validate([
            'fdi_name' => 'required',
            'id_category' => 'required',
            'file' => 'mimes:pdf|max:2000',
        ],[
            'fdi_name.required' => 'Anda belum menginputkan nama file',
            'id_category.required' => 'Anda belum memilih kategori',
            'file.mimes' => 'Format berkas harus .pdf',
            'file.max' => 'Ukuran file lebih dari 2MB'
        ]);

        if($files = $request->file('file')) {
            $berkas = $files->getClientOriginalName();
            $path = public_path().'/dokumen-uploads/doc-implementasi/';

            if(File::exists($path)){
                $remove = Auditor::where([['id','=',$request->id],['nidn','=',$request->nidn]])->first();
                File::deleteDirectory($path);
                Auditor::where([['id','=',$request->id],['nidn','=',$request->nidn]])->delete();
            } 
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

        $post = FileDocumentImplementation::updateOrCreate(['id' => $request->id],
                [
                    'fdi_name'          => $request->fdi_name,
                    'id_document_implementation'          => $nidn,
                    'id_category'  => $request->id_category,
                    'id_auditor'    => $request->id_auditor,
                    'uploaded_file' => $berkas,
                    'link'    => $request->link,
                    'validate'    => 1,
                ]); 

        return response()->json($post);
    }
}
