<?php

namespace App\Http\Controllers\LPM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lpm\Auditee;

class AuditeeController extends Controller
{
    public function index(Request $request)
    {
        $datas = Auditee::all();

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
        return view('lpm.auditee.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_periode' => 'required',
            'fakultas' => 'required',
            'prodi' => 'required',
            'dekan' => 'required',
            'sekretaris_dekan' => 'required',
            'ko_prodi' => 'required',
        ],[
            'id_periode.required' => 'Anda belum memilih periode',
            'fakultas.required' => 'Anda belum menginputkan nama fakultas',
            'prodi.required' => 'Anda belum menginputkan nama prodi',
            'dekan.required' => 'Anda belum menginputkan nama dekan',
            'dekan.required' => 'Anda belum menginputkan nama dekan',
            'sekretaris_dekan.required' => 'Anda belum menginputkan nama sekretaris dekan',
            'ko_prodi.required' => 'Anda belum menginputkan nama koprodi',
        ]);

        $post = Auditee::updateOrCreate(['id' => $request->id],
                [
                    'fakultas'          => $request->fakultas,
                    'prodi'          => $request->prodi,
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
}
