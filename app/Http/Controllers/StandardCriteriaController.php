<?php

namespace App\Http\Controllers;

use App\Models\Indicator;
use App\Models\StandardCategory;
use App\Models\StandardCriteria;
use App\Models\SubIndicator;
use App\Models\ReviewDocs;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class StandardCriteriaController extends Controller
{
    // CRITERIA
    public function criteria(Request $request)
    {
        if ($request->isMethod('POST')) {
            $this->validate($request, [
                'standard_category_id' => ['required'],
                'title' => ['required', 'string'],
            ]);

            $data = StandardCriteria::create([
                'standard_category_id' => $request->standard_category_id,
                'title' => $request->title,
            ]);

            if ($data) {
                return redirect()->route('standard_criteria.criteria')->with('msg', 'Data ('.$request->title.') berhasil ditambahkan');
            }
        }

        $category = StandardCategory::all();
        $data = StandardCriteria::all();
        return view('standard_criteria.criteria', compact('data', 'category'));
    }

    public function criteria_edit($id){
    // Find the existing StandardCriteria by ID
    $data = StandardCriteria::findOrFail($id);
    // Return the edit view with the current criteria data
    return view('standard_criteria.criteria_edit', compact('data'));
}

    public function criteria_update(Request $request, $id){
        $request->validate([
            'title'    => 'string', 'max:191',
            'status' => 'string'
        ]);

        $data = StandardCriteria::findOrFail($id);
        $data->update([
            'status'=> $request->status,
            'title'=> $request->title,
        ]);
        return redirect()->route('standard_criteria.criteria')->with('msg', 'Standard Criteria berhasil diperbarui.');
    }

    public function delete(Request $request){
        $data = StandardCriteria::find($request->id);
        if($data){
            $data->delete();
            return response()->json([
                'success' => true,
                'message' => 'Berhasil dihapus!'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal dihapus!'
            ]);
        }
    }

    public function data(Request $request)
    {
        $data = StandardCriteria::
        with([
        'category' => function ($query) {
            $query->select('id','title','description');
        }])->
        select('*')->orderBy("id");
        return DataTables::of($data)
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('select_category'))) {
                    $instance->whereHas('category', function ($q) use ($request) {
                        $q->where('standard_category_id', $request->get('select_category'));
                    });
                }
                if (!empty($request->get('status'))) {
                    $bools = $request->get('status') === 'true'? true: false;
                    $instance->where('status', $bools);
                }
                if (!empty($request->get('search'))) {
                    $instance->where(function($w) use($request){
                        $search = $request->get('search');
                            $w->orWhere('title', 'LIKE', "%$search%");
                    });
                }
            })->make(true);
    }







    //INDICATOR
    public function indicator(){
        $data = Indicator::all();
        $criteria = StandardCriteria::all();
        return view('standard_criteria.indicator.index', compact('data', 'criteria'));
    }

    public function create(Request $request){
    if ($request->isMethod('POST')) {
        // Validate the request data
        $validatedData = $request->validate([
            'standard_criteria_id' => ['required'],
            'numForms' => ['required', 'integer', 'min:1'],
            'indicators' => ['required', 'array', 'min:1'],
            'indicators.*.name' => ['required', 'string'],
        ]);

        // Retrieve the specific Standard Criteria by ID
        $criteria = StandardCriteria::find($validatedData['standard_criteria_id']);

        if (!$criteria) {
            return redirect()->back()->with('error', 'Standard Criteria not found.');
        }

        // Create the indicators
        foreach ($validatedData['indicators'] as $indicatorData) {
            Indicator::create([
                'name' => $indicatorData['name'],
                'standard_criteria_id' => $validatedData['standard_criteria_id'],
            ]);
        }

        return redirect()->route('standard_criteria.indicator')->with('msg', 'Indicators added successfully.');
    }

    // Retrieve all Standard Criteria for the dropdown
    $allCriteria = StandardCriteria::all();
    $criterias = StandardCriteria::orderBy('title')->get();

    return view('standard_criteria.indicator.create', compact('allCriteria','criterias'));
}

    public function edit($id){
        $data = Indicator::find($id);

        // Fetch all criteria
        $criteria = StandardCriteria::all();
        return view('standard_criteria.indicator.edit', compact('data', 'criteria'));
    }

    public function update_indicator(Request $request, $id){
    // Validate the request
    $request->validate([
        'standard_criteria_id' => ['required', 'string'],
        'name' => ['required','string','max:512'],
    ]);

    // Find the indicator data
    $data = Indicator::findOrFail($id);

    $data->update([
        'standard_criteria_id'=> $request->standard_criteria_id,
        'name'=> $request->name,
    ]);

    // Redirect back with a success message
    return redirect()->route('standard_criteria.indicator')->with('msg', 'Indicator updated successfully.');
}

    public function delete_indicator(Request $request){
        $data = Indicator::find($request->id);
        if($data){
            $data->delete();
            return response()->json([
                'success' => true,
                'message' => 'Berhasil dihapus!'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal dihapus!'
            ]);
        }
    }

    // function untuk menampilakan data indicator
    public function data_indicator(Request $request){
    $data = Indicator::with([
        'criteria' => function ($query) {
            $query->select('id', 'title');
        }
    ])->select('*')->orderBy("id");

    return DataTables::of($data)
        ->filter(function ($instance) use ($request) {
            if (!empty($request->get('select_criteria'))) {
                $instance->whereHas('criteria', function ($q) use ($request) {
                    $q->where('standard_criteria_id', $request->get('select_criteria'));
                });
            }
            if (!empty($request->get('search'))) {
                $instance->where(function($w) use($request){
                    $search = $request->get('search');
                        $w->orWhere('name', 'LIKE', "%$search%");
                });
            }
        })->make(true);
}






    //SUB INDICATOR
    public function sub_indicator(){
        $data = SubIndicator::all();
        $indicator = Indicator::orderBy('name')->get();
        return view('standard_criteria.sub_indicator.index', compact('data', 'indicator'));
    }

    // perubahan logic add sub_indicator
    public function create_sub(Request $request){
    if ($request->isMethod('POST')) {
        // Validate the request data
        $validatedData = $request->validate([
            'standard_criteria_id' => ['required', 'uuid'],
            'numForms' => ['required', 'integer', 'min:1'],
            'indicators' => ['required', 'array', 'min:1'],
            'indicators.*.name' => ['required', 'string'],
        ]);

        // Retrieve the specific Standard Criteria by ID
        $criteria = StandardCriteria::find($validatedData['standard_criteria_id']);

        if (!$criteria) {
            return redirect()->back()->with('error', 'Standard Criteria not found.');
        }

        return redirect()->route('standard_criteria.sub_indicator')->with('msg', 'Indicators added successfully.');
    }

    // Retrieve all Standard Criteria and Indicator for the dropdown
    $allCriteria = StandardCriteria::all();
    $criterias = StandardCriteria::orderBy('title')->get();
    $indicators = Indicator::orderBy('name')->get();

    return view('standard_criteria.sub_indicator.create', compact('allCriteria', 'criterias','indicators'));
}

    public function store_sub(Request $request){
    $validatedData = $request->validate([
        'indicator_id' => 'required|exists:indicators,id',
        'numForms' => 'required|integer|min:1',
        'sub_indicators' => 'required|array|min:1',
        'sub_indicators.*.name' => 'required|string',
    ]);

    foreach ($request->sub_indicators as $sub_indicatorData) {
        SubIndicator::create([
            'name' => $sub_indicatorData['name'],
            'indicator_id' => $validatedData['indicator_id'],
        ]);
    }

    return redirect()->route('standard_criteria.sub_indicator')->with('msg', 'Sub Indicators added successfully.');
}

        public function edit_sub($id){
            $data = SubIndicator::findOrFail($id);

            // Fetch all criteria
            $criteria = StandardCriteria::all();
            return view('standard_criteria.sub_indicator.edit', compact('data', 'criteria'));
        }

        public function update_sub(Request $request, $id){
        // Validate the request
        $request->validate([
            'indicator_id' => ['required', 'string'],
            'name' => ['required','string','max:512'],
        ]);

        // Find the indicator data
        $data = SubIndicator::findOrFail($id);

        $data->update([
            'indicator_id'=> $request->indicator_id,
            'name'=> $request->name,
        ]);

        // Redirect back with a success message
        return redirect()->route('standard_criteria.sub_indicator')->with('msg', 'Sub Indicator updated successfully.');
        }

        public function delete_sub(Request $request){
            $data = SubIndicator::find($request->id);
            if($data){
                $data->delete();
                return response()->json([
                    'success' => true,
                    'message' => 'Berhasil dihapus! ✅'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal dihapus! ❌'
                ]);
            }
        }

    public function data_sub(Request $request){
        $data = SubIndicator::
        with(['indicator' => function ($query) {
            $query->select('id','name');
        }])->
        select('*')->orderBy("id");
        return DataTables::of($data)
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('select_indicator'))) {
                    $instance->whereHas('indicator', function ($q) use ($request) {
                        $q->where('indicator_id', $request->get('select_indicator'));
                    });
                }
                if (!empty($request->get('search'))) {
                    $instance->where(function($w) use($request){
                        $search = $request->get('search');
                            $w->orWhere('name', 'LIKE', "%$search%");
                    });
                }
            })->make(true);
    }




    // REVIEW DOCUMENT
    public function review_docs(){
        $data = ReviewDocs::all();
        $indicator = Indicator::orderBy('name')->get();
        return view('standard_criteria.review_docs.index',compact('data', 'indicator'));
    }

    public function create_docs(Request $request){
        if ($request->isMethod('POST')) {
            // Validate the request data
            $validatedData = $request->validate([
                'standard_criteria_id' => ['required', 'uuid'],
                'numForms' => ['required', 'integer', 'min:1'],
                'indicators' => ['required', 'array', 'min:1'],
                'indicators.*.name' => ['required', 'string'],
            ]);

            // Retrieve the specific Standard Criteria by ID
            $criteria = StandardCriteria::find($validatedData['standard_criteria_id']);

            if (!$criteria) {
                return redirect()->back()->with('error', 'Standard Criteria not found.');
            }

            return redirect()->route('standard_criteria.review_docs')->with('msg', 'Review Docs added successfully.');
        }

        // Retrieve all Standard Criteria and Indicator for the dropdown
        $allCriteria = StandardCriteria::all();
        $criterias = StandardCriteria::orderBy('title')->get();
        $indicators = Indicator::orderBy('name')->get();

        return view('standard_criteria.review_docs.create', compact('allCriteria', 'criterias','indicators'));
    }

        public function store_docs(Request $request){
        $validatedData = $request->validate([
            'indicator_id' => 'required|exists:indicators,id',
            'numForms' => 'required|integer|min:1',
            'review_docs' => 'required|array|min:1',
            'review_docs.*.name' => 'required|string',
        ]);

        $indicator_id = $request->indicator_id;

        //Create the Sub_indicators
        foreach ($request->review_docs as $reviewDocsData) {
            ReviewDocs::create([
                'name' => $reviewDocsData['name'],
                'indicator_id' => $indicator_id,
            ]);
        }

        return redirect()->route('standard_criteria.review_docs')->with('msg', 'Review Document added successfully.');
    }


    // Edit docs Document
    public function edit_docs($id){
        $data = ReviewDocs::findOrFail($id);

       // Fetch all criteria
        $criteria = StandardCriteria::all();
        return view('standard_criteria.review_docs.edit', compact('data', 'criteria'));
    }

    public function update_docs(Request $request, $id){
    // Validate the request
    $request->validate([
        'indicator_id' => ['required', 'string'],
        'name' => ['required','string','max:512'],
    ]);

    // Find the Sub_Indicator data
    $data = ReviewDocs::findOrFail($id);

    $data->update([
        'indicator_id'=> $request->indicator_id,
        'name'=> $request->name,
    ]);

    // Redirect back with a success message
    return redirect()->route('standard_criteria.review_docs')->with('msg', 'Review Document updated successfully.');
    }

    // Delete docs Document
    public function delete_docs(Request $request){
        $data = ReviewDocs::find($request->id);
        if($data){
            $data->delete();
            return response()->json([
                'status' => true,
                'message' => 'Berhasil dihapus ✅'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Gagal dihapus ❌'
            ]);
        }
    }

    // Retrieve and filter data for Dist Document
    public function data_docs(Request $request){
        $data = ReviewDocs::
        with(['indicator' => function ($query) {
            $query->select('id','name');
        }])->
        select('*')->orderBy("id");
        return DataTables::of($data)
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('select_indicator'))) {
                    $instance->whereHas('indicator', function ($q) use ($request) {
                        $q->where('indicator_id', $request->get('select_indicator'));
                    });
                }
                if (!empty($request->get('search'))) {
                    $instance->where(function($w) use($request){
                        $search = $request->get('search');
                            $w->orWhere('name', 'LIKE', "%$search%");
                    });
                }
            })->make(true);
    }
}

