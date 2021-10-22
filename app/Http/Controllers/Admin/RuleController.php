<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rule;
use Illuminate\Http\Request;

class RuleController extends Controller
{
    public function index ()
    {
        $rules = Rule::get();
        //return $rules;

        return view('admin.rules.index' , compact('rules'));
    }
    protected function create ()
    {
        return view('admin.rules.create');
    }
    protected function store (Request $q)
    {
        Rule::create (
            [
                'name' => $q->name,
                'permissions' => json_encode( $q->permissions),
            ]);
       return redirect()->route('admin.rules')->with(['success' => 'تم ألاضافة بنجاح']);
    }
    protected function edit ( $id)
    {
        $rule = Rule::find($id);
        //return $rules;

        return view('admin.rules.edit' , compact('rule'));
    }
    protected function update ( Request $q)
    {
        return $q;
        $rule = Rule::find($id);
        //return $rules;

        return view('admin.rules.edit' , compact('rule'));
    }
}
