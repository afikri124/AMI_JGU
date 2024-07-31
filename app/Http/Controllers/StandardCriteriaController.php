<?php

namespace App\Http\Controllers;

use App\Models\Indicator;
use App\Models\StandardCategory;
use App\Models\StandardCriteria;
use App\Models\ReviewDocs;
use App\Models\StandardStatement;
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
                return redirect()->route('standard_criteria.criteria')->with('msg', 'Data ('.$request->title.') added successfully');
            }
        }

        $data = StandardCriteria::all();
        $category = StandardCategory::all();
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
        return redirect()->route('standard_criteria.criteria')->with('msg', 'Standard Criteria updated successfully.');
    }

    public function delete(Request $request){
        $data = StandardCriteria::find($request->id);
        if($data){
            $data->delete();
            return response()->json([
                'success' => true,
                'message' => 'Successfully deleted!'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete! Data not found'
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


    // Standard Statement
    public function standard_statement(){
        $data = StandardStatement::all();
        $criteria = StandardCriteria::all();
        return view('standard_criteria.standard_statement.index', compact('data', 'criteria'));
    }

    public function create(Request $request){
    if ($request->isMethod('POST')) {
        // Validate the request data
        $validatedData = $request->validate([
            'standard_criteria_id' => ['required'],
            'numForms' => ['required', 'integer', 'min:1'],
            'standard_statements' => ['required', 'array', 'min:1'],
            'standard_statements.*.name' => ['required', 'string'],
        ]);

        // Retrieve the specific Standard Criteria by ID
        $criteria = StandardCriteria::find($validatedData['standard_criteria_id']);

        if (!$criteria) {
            return redirect()->back()->with('error', 'Standard Criteria not found.');
        }

        // Create the standard_statements
        foreach ($validatedData['standard_statements'] as $standard_statementData) {
            StandardStatement::create([
                'name' => $standard_statementData['name'],
                'standard_criteria_id' => $validatedData['standard_criteria_id'],
            ]);
        }

        return redirect()->route('standard_criteria.standard_statement')->with('msg', 'Standard Statement added successfully.');
    }

    // Retrieve all Standard Criteria for the dropdown
    $allCriteria = StandardCriteria::all();
    $criterias = StandardCriteria::orderBy('title')->get();

    return view('standard_criteria.standard_statement.create', compact('allCriteria','criterias'));
}

    public function edit($id){
        $data = StandardStatement::findOrFail($id);

        // Fetch all criteria
        $criteria = StandardCriteria::all();
        return view('standard_criteria.standard_statement.edit', compact('data', 'criteria'));
    }

    public function update_standard_statement(Request $request, $id){
    // Validate the request
    $request->validate([
        'standard_criteria_id' => ['required', 'string'],
        'name' => ['required','string','max:512'],
    ]);

    // Find the standard_statement data
    $data = StandardStatement::findOrFail($id);

    $data->update([
        'standard_criteria_id'=> $request->standard_criteria_id,
        'name'=> $request->name,
    ]);

    // Redirect back with a success message
    return redirect()->route('standard_criteria.standard_statement')->with('msg', 'Standard Statement updated successfully.');
}

    public function delete_standard_statement(Request $request){
        $data = StandardStatement::find($request->id);
        if($data){
            $data->delete();
            return response()->json([
                'success' => true,
                'message' => 'Successfully deleted!'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete! Data not found'
            ]);
        }
    }

    // function untuk menampilakan data standard_statement
    public function data_standard_statement(Request $request){
    $data = StandardStatement::with([
        'criteria' => function ($query) {
            $query->select('id', 'title', 'standard_category_id')
                  ->with(['category' => function ($query) {
                      $query->select('id', 'title', 'description');
                  }]);
        }])->select('*')->orderBy("id");

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




    //INDICATOR
    public function indicator(){
        $data = Indicator::all();
        $criteria = StandardCriteria::all();
        $statement = StandardStatement::orderBy('name')->get();
        return view('standard_criteria.indicator.index', compact('data', 'criteria', 'statement'));
    }

    // public function getStandardCriteria()
    //     {
    //         $criteria = StandardCriteria::all(); // Mengambil semua data dari tabel 'standard_criteria'
    //         return view('standard_criteria.index', compact('criteria')); // Mengirim data ke view 'standard_criteria.index'
    //     }

    // public function getStandardStatements()
    //     {
    //         $statement = StandardStatement::orderBy('name')->get(); // Mengambil semua data dari tabel 'standard_statements' dan mengurutkannya berdasarkan kolom 'name'
    //         return view('standard_statements.index', compact('statement')); // Mengirim data ke view 'standard_statements.index'
    //     }

<<<<<<< HEAD
=======

>>>>>>> b516e20244afdf491467e8f0520000973c37586d
    // perubahan logic add indicator
    public function create_indicator(Request $request){
    if ($request->isMethod('POST')) {
        // Validate the request data
        $validatedData = $request->validate([
            'standard_criteria_id' => ['required'],
            'standard_statement_id' => ['required'],
            'numForms' => ['required', 'integer', 'min:1'],
            'indicators' => ['required', 'array', 'min:1'],
            'indicators.*.name' => ['required', 'string'],
        ]);

        // Retrieve the specific Standard Criteria by ID
        $criteria = StandardCriteria::find($validatedData['standard_criteria_id']);
        $statement = StandardStatement::find($validatedData['standard_statement_id']);

        if (!$statement) {
            return redirect()->back()->with('error', 'Standard Criteria not found.');
        }

        return redirect()->route('standard_criteria.indicator.index')->with('msg', 'Indicators added successfully.');
    }

    // Retrieve all Standard Criteria and Indicator for the dropdown
    $allCriteria = StandardCriteria::all();
    $criterias = StandardCriteria::orderBy('title')->get();
    $statement = StandardStatement::orderBy('name')->get();

    return view('standard_criteria.indicator.create', compact('allCriteria', 'criterias','statement'));
}

    public function store_indicator(Request $request){
    $validatedData = $request->validate([
        'standard_criteria_id' => ['required'],
        'standard_statement_id' => 'required|exists:standard_statements,id',
        'numForms' => 'required|integer|min:1',
        'indicators' => 'required|array|min:1',
        'indicators.*.name' => 'required|string',
    ]);

    foreach ($request->indicators as $indicatorData) {
        Indicator::create([
            'name' => $indicatorData['name'],
            'standard_criteria_id' => $validatedData['standard_criteria_id'],
            'standard_statement_id' => $validatedData['standard_statement_id'],
        ]);
    }

    return redirect()->route('standard_criteria.indicator.index')->with('msg', 'Indicators added successfully.');
}

        public function edit_indicator($id){
            $data = Indicator::findOrFail($id);
            $criteria = StandardCriteria::all();
            $statement = StandardStatement::orderBy('name')->get();
            return view('standard_criteria.indicator.edit', compact('data', 'criteria', 'statement'));
        }

        public function update_indicator(Request $request, $id){
        // Validate the request
        $request->validate([
            'standard_criteria_id' => ['required', 'string'],
            'standard_statement_id' => ['required', 'string'],
            'name' => ['required','string','max:512'],
        ]);

        // Find the indicator data
        $data = Indicator::findOrFail($id);

        $data->update([
            'standard_criteria_id'=> $request->standard_criteria_id,
            'standard_statement_id'=> $request->standard_statement_id,
            'name'=> $request->name,
        ]);

        // Redirect back with a success message
        return redirect()->route('standard_criteria.indicator.index')->with('msg', 'Indicator updated successfully.');
        }

        public function delete_indicator(Request $request){
            $data = Indicator::find($request->id);
            if($data){
                $data->delete();
                return response()->json([
                    'success' => true,
                    'message' => 'Successfully deleted!'
                ]);
            } else {
                return response()->json([
                    'success' => false,
                    'message' => 'Failed to delete! Data not found'
                ]);
            }
        }

    public function data_indicator(Request $request){
        $data = Indicator::
        with([
            'statement' => function ($query) {
            $query->select('id','name');
        },
            'criteria' => function ($query) {
            $query->select('id', 'title');
        }
        ])->select('*')->orderBy("id");
        return DataTables::of($data)
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('select_statement'))) {
                    $instance->whereHas('statement', function ($q) use ($request) {
                        $q->where('standard_statement_id', $request->get('select_statement'));
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
        $criteria = StandardCriteria::all();
        $statement = StandardStatement::orderBy('name')->get();
        return view('standard_criteria.review_docs.index',compact('data', 'criteria', 'statement'));
    }

    public function create_docs(Request $request){
        if ($request->isMethod('POST')) {
            // Validate the request data
            $validatedData = $request->validate([
                'standard_criteria_id' => ['required', 'uuid'],
                'standard_statement_id' => ['required'],
                'numForms' => ['required', 'integer', 'min:1'],
                'review_docs' => ['required', 'array', 'min:1'],
                'review_docs.*.name' => ['required', 'string'],
            ]);

            // Retrieve the specific Standard Criteria by ID
            $criteria = StandardCriteria::find($validatedData['standard_criteria_id']);
            $statement = StandardStatement::find($validatedData['standard_statement_id']);

            if (!$criteria) {
                return redirect()->back()->with('error', 'Standard Criteria not found.');
            }

            return redirect()->route('standard_criteria.review_docs')->with('msg', 'Review Docs added successfully.');
        }

        // Retrieve all Standard Criteria and Indicator for the dropdown
        $allCriteria = StandardCriteria::all();
        $criterias = StandardCriteria::orderBy('title')->get();
        $statement = StandardStatement::orderBy('name')->get();

        return view('standard_criteria.review_docs.create', compact('allCriteria', 'criterias','statement'));
    }

        public function store_docs(Request $request){
        $validatedData = $request->validate([
            'standard_criteria_id' => ['required'],
            'standard_statement_id' => 'required|exists:standard_statements,id',
            'numForms' => 'required|integer|min:1',
            'review_docs' => 'required|array|min:1',
            'review_docs.*.name' => 'required|string',
        ]);

        $standard_statement_id = $request->standard_statement_id;

        //Create the Sub_indicators
        foreach ($request->review_docs as $reviewDocsData) {
            ReviewDocs::create([
                'name' => $reviewDocsData['name'],
                'standard_criteria_id' => $validatedData['standard_criteria_id'],
                'standard_statement_id' => $validatedData['standard_statement_id'],
            ]);
        }

        return redirect()->route('standard_criteria.review_docs')->with('msg', 'Review Document added successfully.');
    }


    // Edit docs Document
    public function edit_docs($id){
        $data = ReviewDocs::findOrFail($id);
        $criteria = StandardCriteria::all();
       $statement = StandardStatement::orderBy('name')->get();
       return view('standard_criteria.review_docs.edit', compact('data', 'criteria', 'statement'));
    }

    public function update_docs(Request $request, $id)
{
    // Validasi permintaan
    $request->validate([
        'standard_criteria_id' => ['required', 'string'],
        'standard_statement_id' => ['required', 'exists:indicators,id'], // Pastikan standard_statement_id ada di tabel indicators
        'name' => ['required', 'string', 'max:512'],
    ]);

    // Temukan data ReviewDocs
    $data = ReviewDocs::findOrFail($id);

    // Pembaruan data
    $data->update([
        'standard_criteria_id'=> $request->standard_criteria_id,
        'standard_statement_id' => $request->standard_statement_id,
        'name' => $request->name,
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
                'success' => true,
                'message' => 'Successfully deleted!'
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete! Data not found'
            ]);
        }
    }

    // Retrieve and filter data for Dist Document
    public function data_docs(Request $request){
        $data = ReviewDocs::
        with([
            'statement' => function ($query) {
            $query->select('id','name');
        },
        'criteria' => function ($query) {
        $query->select('id', 'title');
        }
        ])->select('*')->orderBy("id");
        return DataTables::of($data)
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('select_statement'))) {
                    $instance->whereHas('statement', function ($q) use ($request) {
                        $q->where('standard_statement_id', $request->get('select_statement'));
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

    public function getStandardStatementId(Request $request)
    {
        $statement = StandardStatement::where('standard_criteria_id', $request->id)->get();
        return response()->json($statement);
    }
}

