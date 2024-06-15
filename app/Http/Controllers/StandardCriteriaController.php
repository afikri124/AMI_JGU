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
    public function criteria(Request $request)
    {
        if ($request->isMethod('POST')) {
            $this->validate($request, [
                'standard_categories_id' => ['required'],
                'title' => ['required', 'string'],
            ]);

            $data = StandardCriteria::create([
                'standard_categories_id' => $request->standard_categories_id,
                'title' => $request->title,
            ]);

            if ($data) {
                return redirect()->route('standard_criteria.criteria');
            }
        }

        $category = StandardCategory::orderBy('description')->get();
        $data = StandardCriteria::all();

        return view('standard_criteria.criteria', compact('data', 'category'));
    }

    public function data(Request $request)
    {
        $data = StandardCriteria::with(['category' => function ($query) {
            $query->select('id', 'description');
        }])->select('*')->orderBy("id");

        return DataTables::of($data)
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('Select_2'))) {
                    $instance->whereHas('status', function ($q) use ($request) {
                        $q->where('status_id', $request->get('Select_2'));
                    });
                }
            })->make(true);
    }

    public function indicator()
    {
        $category = StandardCategory::orderBy('description')->get();
        $data = StandardCriteria::all();

        return view('standard_criteria.indicator.index', compact('data', 'category'));
    }

    public function create()
    {
        $data = StandardCriteria::all();
        return view('standard_criteria.indicator.create', compact('data'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'standard_criterias_id' => 'required|uuid|exists:standard_criterias,id',
            'numForms' => 'required|integer|min:1',
            'indicators' => 'required|array|min:1',
            'indicators.*.name' => 'required|string',
            'indicators.*.sub_indicator' => 'required|string',
            'indicators.*.review_document' => 'required|string',
        ]);



        $standard_criterias_id = $request->standard_criterias_id;


        foreach ($request->indicators as $indicatorData) {


            Indicator::create([
                'standard_criterias_id' => $standard_criterias_id,
                'name' => $indicatorData['name'],
                'sub_indicator' => $indicatorData['sub_indicator'],
                'review_document' => $indicatorData['review_document'],
            ]);
        }


        return redirect()->route('standard_criteria.indicator')->with('msg', 'Indicators added successfully.');
    }
}
