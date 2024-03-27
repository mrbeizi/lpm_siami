<?php

namespace App\Http\Controllers\LPM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\General\Standard;

class DocumentSpmiController extends Controller
{
    public function index(Request $request)
    {
        $datas = Standard::leftJoin('standard_periods','standard_periods.id','=','standards.id_standard_period')
            ->select('standards.id AS id','standards.name','standards.parent_id')
            ->where([['standards.parent_id', '=', 0],['standard_periods.is_active',1]])
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
        $standards = Standard::where([['parent_id', '=', 0]])->get();
        $allStandards = Standard::select('id','name','parent_id')->get();
        return view('lpm.doc-spmi.index', compact('standards','allStandards'));
    }
}
