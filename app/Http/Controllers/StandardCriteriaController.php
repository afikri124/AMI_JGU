<?php

namespace App\Http\Controllers;

use App\Models\AuditStatus;
use App\Models\Indicator;
use App\Models\StandardCategory;
use App\Models\StandardCriteria;
use App\Models\SubIndicator;
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
                'audit_status_id' => '10',
            ]);

            if ($data) {
                return redirect()->route('standard_criteria.criteria')->with('msg', 'Data ('.$request->title.') berhasil di tambahkan');
            }
        }
        $category = StandardCategory::all();
        $data = StandardCriteria::all();
        $status = AuditStatus::get();
        return view('standard_criteria.criteria', compact('data', 'category', 'status'));
    }

    public function data(Request $request)
    {
        $data = StandardCriteria::
        with([
        'category' => function ($query) {
            $query->select('id','title','description');
        },
        'status' => function ($query) {
            $query->select('id','title', 'color');
        }])->
        select('*')->orderBy("id");
        return DataTables::of($data)
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('select_category'))) {
                    $instance->whereHas('category', function ($q) use ($request) {
                        $q->where('standard_categories_id', $request->get('select_category'));
                    });
                }
            })->make(true);
    }

    // logic untuk edit
    public function criteria_edit($id){
    // Find the existing StandardCriteria by ID
    $data = StandardCriteria::findOrFail($id);
    $status = AuditStatus::whereIn('id', [10, 11])->get(); 
    //dd($data);

    // Return the edit view with the current criteria data
    return view('standard_criteria.criteria_edit', compact('data', 'status'));
}

    public function criteria_update(Request $request, $id){
        $request->validate([
            'title'    => 'string', 'max:191',
            'audit_status_id' => 'string'
        ]);

        $data = StandardCriteria::findOrFail($id);
        $data->update([
            'audit_status_id'=> $request->audit_status_id,
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

    public function indicator(){
        $criteria = StandardCriteria::all();
        $data = Indicator::all();
        return view('standard_criteria.indicator.index', compact('data', 'criteria'));
    }

    public function create(Request $request){
    if ($request->isMethod('POST')) {
        // Validate the request data
        $validatedData = $request->validate([
            'standard_criterias_id' => ['required'],
            'numForms' => ['required', 'integer', 'min:1'],
            'indicators' => ['required', 'array', 'min:1'],
            'indicators.*.name' => ['required', 'string'],
        ]);

        // Retrieve the specific Standard Criteria by ID
        $criteria = StandardCriteria::find($validatedData['standard_criterias_id']);

        if (!$criteria) {
            return redirect()->back()->with('error', 'Standard Criteria not found.');
        }

        // Create the indicators
        foreach ($validatedData['indicators'] as $indicatorData) {
            Indicator::create([
                'name' => $indicatorData['name'],
                'standard_criterias_id' => $validatedData['standard_criterias_id'],
            ]);
        }

        return redirect()->route('standard_criteria.indicator')->with('msg', 'Indicators added successfully.');
    }

    // Retrieve all Standard Criteria for the dropdown
    $allCriteria = StandardCriteria::all();
    $criterias = StandardCriteria::orderBy('title')->get();

    return view('standard_criteria.indicator.create', compact('allCriteria','criterias'));
}

    public function show($id){
    $criteria = StandardCriteria::find($id);

    if (!$criteria) {
        return redirect()->back()->with('error', 'Standard Criteria not found.');
    }

    return view('standard_criteria.indicator.show', compact('criteria'));
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
        'standard_criterias_id' => ['required', 'string'],
        'name' => ['required','string','max:512'],
    ]);

    // Find the indicator data
    $data = Indicator::findOrFail($id);

    $data->update([
        'standard_criterias_id'=> $request->standard_criterias_id,
        'name'=> $request->name,
    ]);

    // Redirect back with a success message
    return redirect()->route('standard_criteria.indicator')->with('msg', 'Indicator updated successfully.');
}

    public function delete_indikator(Request $request){
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
                    $q->where('standard_criterias_id', $request->get('select_criteria'));
                });
            }
        })->make(true);
}

    //sub indicator
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
            'standard_criterias_id' => ['required', 'uuid'],
            'numForms' => ['required', 'integer', 'min:1'],
            'indicators' => ['required', 'array', 'min:1'],
            'indicators.*.name' => ['required', 'string'],
        ]);

        // Retrieve the specific Standard Criteria by ID
        $criteria = StandardCriteria::find($validatedData['standard_criterias_id']);

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

    $indicator_id = $request->indicator_id;
    
    //Create the Sub_indicators
    foreach ($request->sub_indicators as $sub_indicatorData) {
        SubIndicator::create([
            'name' => $sub_indicatorData['name'],
            'indicator_id' => $indicator_id,
        ]);
    }

    return redirect()->route('standard_criteria.sub_indicator')->with('msg', 'Sub Indicators added successfully.');
}


    public function show_sub($id){
        $criteria = StandardCriteria::find($id);
        $indicator = Indicator::orderBy('name')->get();

        if (!$criteria) {
            return redirect()->back()->with('error', 'Standard Criteria not found.');
        }

        return view('standard_criteria.sub_indicator.show', compact('criteria', 'indicator'));
    }

    public function data_sub(Request $request){
        $data = SubIndicator::
        with(['indicator' => function ($query) {
            $query->select('id','name');
        }])->
        select('*')->orderBy("id");
        return DataTables::of($data)
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('Select_2'))) {
                    $instance->whereHas('status', function ($q) use ($request) {
                        $q->where('status_id', $request->get('Select_2'));
                    });
                }
            })->make(true);
    }
}
