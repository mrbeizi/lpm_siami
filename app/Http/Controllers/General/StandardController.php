<?php

namespace App\Http\Controllers\General;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\General\Standard;

class StandardController extends Controller
{
    public function manageStandard()
    {
        $standards = Standard::where('parent_id', '=', 0)->get();
        $allStandards = Standard::pluck('name','id')->all();
        return view('general.standard.standardTreeview',compact('standards','allStandards'));
    }

    public function addStandard(Request $request)
    {
        $this->validate($request, [
        		'name' => 'required',
        	]);
        $input = $request->all();
        $input['parent_id'] = empty($input['parent_id']) ? 0 : $input['parent_id'];
        $post = Standard::create($input);
        return response()->json($post);
    }
}
