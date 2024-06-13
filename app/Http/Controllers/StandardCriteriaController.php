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
        $data = StandardCriteria::all();
        return view('standard_criteria.criteria', compact('data'));
    }

    public function criteria_add(Request $request) {
        if ($request->isMethod('POST')) {
            $this->validate($request, [ 
                'standard_id'=> ['string'],
                'indicator_id'=> ['string'],
                'standard_category_id' => ['string']
            ]);
            $data = StandardCriteria::create([
                'standard_id' => $request->standard_id,
                'indicator_id' => $request->indicator_id,
                'sub_indicator_id' => $request->sub_indicator_id,
                'standard_category_id' => $request->standard_category_id,
                'audit_status_id' => $request->audit_status_id,
                'remark' => $request->remark,
                'required' => $request->required,
            ]);
            if($data){
                return redirect()->route('standard_criteria.criteria');
            }
        } 
        $category = StandardCategory::orderBy('description')->get();
        $standard = Standard::orderBy('name')->get();
        $indicator = Indicator::orderBy('name')->get();
        $data = StandardCriteria::all();
        return view('standard_criteria.criteria_add',  compact('data', 'standard', 'indicator', 'category'));
    }

    public function data(Request $request){
        $data = StandardCriteria::
        with(['standard' => function ($query) {
            $query->select('id','name');
        }])->with(['indicator' => function ($query) {
            $query->select('id','name');
        }])->with(['category' => function ($query) {
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
