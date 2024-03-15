<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Lpm\UserRole;
use App\User;

class UserController extends Controller
{
    public function index(Request $request)
    {
        $datas = User::leftJoin('user_roles','user_roles.id','=','users.role_id')
            ->select('users.id AS id','users.name','users.email','user_roles.role_name')
            ->orderBy('users.id','ASC')
            ->get();

        if($request->ajax()){
            return datatables()->of($datas)
            ->addColumn('action', function($data){
                if($data->role_name == 'LPM'){
                    $button = '<i class="bx bx-lock bx-tada"></i>';
                } else {
                    $button = '<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.$data->id.'" data-toggle="tooltip" data-placement="bottom" title="Edit" data-original-title="Edit" class="edit btn btn-success btn-xs edit-post"><i class="bx bx-xs bx-edit"></i></a>';
                    $button .= '&nbsp;&nbsp;';
                    $button .= '<button type="button" name="delete" id="'.$data->id.'" data-toggle="tooltip" data-placement="bottom" title="Delete" class="delete btn btn-danger btn-xs"><i class="bx bx-xs bx-trash"></i></button>';
                }
                return $button;
            })
            ->rawColumns(['action'])
            ->addIndexColumn(true)
            ->make(true);
        }
        $getRole = UserRole::all();
        return view('general.users.index', compact('getRole'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required',
            'password' => 'required',
            'role_id' => 'required',
        ],[
            'username.required' => 'Anda belum menginputkan nama',
            'email.required' => 'Anda belum menginputkan email',
            'password.required' => 'Anda belum menginputkan password',
            'role_id.required' => 'Anda belum memilih role',
        ]);

        $post = User::updateOrCreate(['id' => $request->id],
                [
                    'name'      => $request->username,
                    'email'     => $request->email,
                    'password'  => Hash::make($request['password']),
                    'role_id'   => $request->role_id,
                ]); 

        return response()->json($post);
    }

    public function edit($id)
    {
        $where = array('id' => $id);
        $post  = User::where($where)->first();
     
        return response()->json($post);
    }

    public function destroy($id)
    {
        $post = User::where('id',$id)->delete();     
        return response()->json($post);
    }
}
