<?php

namespace App\Http\Controllers\LPM;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Lpm\UserRole;

class UserRoleController extends Controller
{
    public function index(Request $request)
    {
        $datas = UserRole::all();
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
        return view('lpm.user-role.index');
    }

    public function store(Request $request)
    {
        $request->validate([
            'role_name' => 'required|unique:user_roles',
        ],[
            'role_name.required' => 'Anda belum menginputkan nama role',
            'role_name.unique' => 'Nama role sudah ada',
        ]);

        $post = UserRole::updateOrCreate(['id' => $request->id],
                [
                    'role_name'          => $request->role_name,
                ]); 

        return response()->json($post);
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = UserRole::where($where)->first();
     
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = UserRole::where('id',$id)->delete();     
        return response()->json($post);
    }
}
