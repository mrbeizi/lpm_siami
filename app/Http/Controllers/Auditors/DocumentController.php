<?php

namespace App\Http\Controllers\Auditors;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Implementation\DocumentImplementation;

class DocumentController extends Controller
{
    public function index(Request $request)
    {
        $datas = DocumentImplementation::where('is_archive',0)->get();
        if($request->ajax()){
            return datatables()->of($datas)
            ->addColumn('action', function($data){
                $button = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$data->id.'" data-toggle="tooltip" data-placement="bottom" title="Edit" data-original-title="Edit" class="edit btn btn-success btn-xs edit-post"><i class="bx bx-xs bx-edit"></i></a>';
                $button .= '&nbsp;&nbsp;';
                $button .= '<button type="button" name="delete" id="'.$data->id.'" data-toggle="tooltip" data-placement="bottom" title="Delete" class="delete btn btn-danger btn-xs"><i class="bx bx-xs bx-trash"></i></button>';
                $button .= '&nbsp;&nbsp;';
                $button .= '<a href="javascript:void(0)" name="archive-doc" data-toggle="tooltip" data-placement="bottom" title="Archive" onclick="archiveDoc('.$data->id.','.$data->is_archive.')" data-id="'.$data->id.'" data-placement="bottom" data-original-title="archivestd" class="archivedoc btn btn-warning btn-xs archive-post"><i class="bx bx-xs bx-archive"></i></a>';
                return $button;
            })
            ->rawColumns(['action'])
            ->addIndexColumn(true)
            ->make(true);
        }
        return view('auditors.document.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'doc_name' => 'required',
            'id_period' => 'required',
        ],[
            'doc_name.required' => 'Anda belum menginputkan nama dokumen',
            'id_period.required' => 'Anda belum memilih periode',
        ]);

        $post = DocumentImplementation::updateOrCreate(['id' => $request->id],
                [
                    'doc_name' => $request->doc_name,
                    'id_period'  => $request->id_period,
                ]); 

        return response()->json($post);
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = DocumentImplementation::where($where)->first();
     
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = DocumentImplementation::where('id',$id)->delete();     
        return response()->json($post);
    }

    public function archiveDoc(Request $request)
    {
        $req    = $request->is_archive == '1' ? 0 : 1;
        $post   = DocumentImplementation::updateOrCreate(['id' => $request->id],['is_archive' => $req, 'archived_at' => now()]); 
        return response()->json($post);
    }
}
