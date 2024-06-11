<?php

namespace App\Http\Controllers;

use App\Models\StandardCategory;
use App\Models\StandardCriteria;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class StandardCategoryController extends Controller
{
    public function category(Request $request) {
        $data = StandardCategory::all();
        return view('standard_category.category', compact('data'));
    }

    public function category_add(Request $request) {
        if ($request->isMethod('POST')) {
            $this->validate($request, [ 
                'id'=> ['required', 'string', 'max:191', Rule::unique('standard_categories')],
                'title'=> ['required', 'string', 'max:191'],
            ]);
            StandardCategory::insert(request()->except(['_token']));
            return redirect()->route('standard_category.category');
        }
        return view('standard_category.category_add');
    }
}
