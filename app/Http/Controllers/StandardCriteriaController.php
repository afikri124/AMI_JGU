<?php

namespace App\Http\Controllers;

use App\Models\StandardCategory;
use Illuminate\Http\Request;

class StandardCriteriaController extends Controller
{
    public function criteria(Request $request) {
        $category = StandardCategory::get();
        return view('standard_criteria.criteria', compact('category'));
    }
}
