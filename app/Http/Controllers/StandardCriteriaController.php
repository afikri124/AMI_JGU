<?php

namespace App\Http\Controllers;

use App\Models\Indicator;
use App\Models\Standard;
use App\Models\StandardCategory;
use App\Models\StandardCriteria;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StandardCriteriaController extends Controller
{
    public function criteria(Request $request) {
        if ($request->isMethod('POST')) {
            $this->validate($request, [ 
                'standard_categories_id'=> ['required','string'],
                'title'=> ['required','string'],
            ]);
            $data = StandardCriteria::create([
                'standard_categories_id' => $request->standard_categories_id,
                'title' => $request->title,
            ]);
            if($data){
                return redirect()->route('standard_criteria.criteria');
            }
        } 
        $category = StandardCategory::orderBy('description')->get();
        $data = StandardCriteria::all();
        return view('standard_criteria.criteria',  compact('data','category'));
    }

    public function data(Request $request){
        $data = StandardCriteria::
        with(['category' => function ($query) {
            $query->select('id','description');
        }])->select('*')->orderBy("id");
            return DataTables::of($data)
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('Select_2'))) {
                    $instance->whereHas('status', function($q) use($request){
                        $q->where('status_id', $request->get('Select_2'));
                    });
                }
            })->make(true);
    }
}
