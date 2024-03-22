<?php

namespace App\Http\Controllers\ImplementationDocs;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Implementation\DocumentImplementation;
use App\Models\General\Faculty;
use DB;

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
                $button = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$data->id.'" data-toggle="tooltip" data-placement="bottom" title="Upload" data-original-title="Upload" class="upload btn btn-primary btn-xs upload-post"><i class="bx bx-xs bx-upload"></i></a>';
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
        return view('implementation.dashboard-docs.index', compact('getFaculty'));
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
        $post  = DB::table('file_document_implementations')->where($where)->first();
     
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = DB::table('file_document_implementations')->where('id',$id)->delete();     
        return response()->json($post);
    }
}
