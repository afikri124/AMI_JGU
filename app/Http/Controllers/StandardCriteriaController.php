<?php

namespace App\Http\Controllers;

use App\Models\StandardCategory;
use App\Models\StandardCriteria;
use Illuminate\Http\Request;

class StandardCriteriaController extends Controller
{
    public function criteria(Request $request) {
        $data = StandardCategory::all();
        return view('standard_criteria.criteria', compact('data'));
    }

    public function criteria_add(Request $request) {
        if ($request->isMethod('POST')) {
            $this->validate($request, [ 
                'standard_categories_id'=> ['required'],
                'title'=> ['required', 'string', 'max:191'],
                'weight'=> ['required', 'numeric'],
            ]);
            StandardCriteria::created([
                'standard_categories_id' => $request->standard_categories_id,
                'title' => $request->title,
                'weight' => $request->weight,
                'status_id'=> '10',
            ]);
            return redirect()->route('standard_criteria.criteria');
        } 
        $data = StandardCategory::all();
        return view('standard_criteria.criteria_add',  compact('data'));
    }
}
