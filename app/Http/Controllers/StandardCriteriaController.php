<?php

namespace App\Http\Controllers;

use App\Models\StandardCategory;
use App\Models\StandardCriteria;
use Illuminate\Http\Request;

class StandardCriteriaController extends Controller
{
    public function criteria(Request $request) {
        $category = StandardCategory::get();
        return view('standard_criteria.criteria', compact('category'));
    }

    public function criteria_add(Request $request) {
        if ($request->isMethod('post')) {
            $this->validate($request, [ 
                'standard_categories_id'=> ['required'],
                'title'=> ['required', 'string', 'max:191'],
                'weight'=> ['required', 'numeric'],
            ]);
            StandardCriteria::insert(request()->except(['_token']));
            return redirect()->route('standard_criteria.criteria');
        } 
        $category = StandardCategory::get();
        return view('standard_criteria.criteria_add', compact('category'));
    }
}
