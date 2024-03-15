<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\General\Employee;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        $datas = Employee::all();
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
        return view('general.employee.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ],[
            'name.required' => 'Anda belum menginputkan nama pegawai',
        ]);

        $post = Employee::updateOrCreate(['id' => $request->id],
                [
                    'nip'     => $request->nip,
                    'nidn'     => $request->nidn,
                    'name'   => $request->name,
                    'email'   => $request->email,
                    'phone_number'   => $request->phone_number,
                ]); 

        return response()->json($post);
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = Employee::where($where)->first();
     
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = Employee::where('id',$id)->delete();     
        return response()->json($post);
    }
}
