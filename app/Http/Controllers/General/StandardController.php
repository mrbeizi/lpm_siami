<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\General\Standard;

class StandardController extends Controller
{
    public function manageStandard($id)
    {
        $standards = Standard::where('parent_id', '=', 0)->get();
        $allStandards = Standard::pluck('name','id')->all();
        return view('general.standard.standardTreeview',['standards' => $standards,'allStandards' => $allStandards,'idStd' => $id]);
    }

    public function addStandard(Request $request)
    {
        $this->validate($request, [
        		'name' => 'required',
        	]);
        // $input = $request->all();
        // $input['parent_id'] = empty($input['parent_id']) ? 0 : $input['parent_id'];
        // $post = Standard::create($input);

        if(empty($request->parent_id)){
            $parent_id = 0;
        } else {
            $parent_id = $request->parent_id;
        }

        $post = Standard::updateOrCreate(['id' => $request->id],
                [
                    'name' => $request->name,
                    'parent_id'  => $parent_id,
                    'id_standard_period'  => $request->idStd,
                ]); 
        return response()->json($post);
    }
}
