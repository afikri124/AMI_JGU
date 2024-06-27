<?php

namespace App\Http\Controllers;

use App\Models\AuditStatus;
use App\Models\Indicator;
use App\Models\Standard;
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
        'indicator' => function ($query) {
            $query->select('id','name');
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

    public function indicator()
    {
        $category = StandardCategory::orderBy('description')->get();
        $data = StandardCriteria::all();
        $indicator = Indicator::all();
        return view('standard_criteria.indicator.index', compact('data', 'category', 'indicator'));
    }

    public function create($id)
    {
        // Retrieve the specific Standard Criteria by ID
        $criteria = StandardCriteria::find($id);

        if (!$criteria) {
            return redirect()->back()->with('error', 'Standard Criteria not found.');
        }

        // Retrieve all Standard Criteria for the dropdown
        $allCriteria = StandardCriteria::all();

        return view('standard_criteria.indicator.create', compact('criteria', 'allCriteria'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'standard_criterias_id' => 'required|uuid|exists:standard_criterias,id',
            'numForms' => 'required|integer|min:1',
            'indicators' => 'required|array|min:1',
            'indicators.*.name' => 'required|string',
        ]);

        $standard_criterias_id = $request->standard_criterias_id;

        foreach ($request->indicators as $indicatorData) {
            Indicator::create([
                'name' => $indicatorData['name'],
                'standard_criterias_id' => $standard_criterias_id,
            ]);
        }


        return redirect()->route('standard_criteria.indicator')->with('msg', 'Indicators added successfully.');
    }

    public function show($id){
    $criteria = StandardCriteria::find($id);

    if (!$criteria) {
        return redirect()->back()->with('error', 'Standard Criteria not found.');
    }

    return view('standard_criteria.indicator.show', compact('criteria'));
    }

    public function edit($id){
        $data = StandardCriteria::find($id);

        // Fetch all criteria
        $criteria = StandardCriteria::all();
        return view('standard_criteria.indicator.edit', compact('data', 'criteria'));
    }

    public function update(Request $request, $id){
    // Validate the request
    $request->validate([
        'indicator_id' => 'required',
    ]);

    // Find the indicator data
    $data = Indicator::find($id);

    // Update the indicator data
    $data->indicator_id = $request->indicator_id;
    $data->save();

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

    public function data_indicator($id)
    {
        $data = Indicator::where('standard_criterias_id', $id)->get();
        return DataTables::of($data)
            ->addColumn('action', function ($row) {
                return '<a class="text-warning" title="Edit" href="'.url('indicator/edit/'.$row->id).'"><i class="bx bx-pencil"></i></a>
                        <a class="text-primary" title="Delete" onclick="DeleteId('.$row->id.')"><i class="bx bx-trash"></i></a>';
            })
            ->rawColumns(['action'])
            ->make(true);
        }

    //sub indicator
    public function sub_indicator()
    {
        $criteria = StandardCriteria::orderBy('title')->get();
        $indicator = Indicator::orderBy('name')->get();
        return view('standard_criteria.sub_indicator.index', compact('criteria', 'indicator'));
    }

    public function create_sub($id)
    {
        // Retrieve the specific Standard Criteria by ID
        $criteria = StandardCriteria::findOrFail($id);
        $indicator = Indicator::where('standard_criterias_id', $id)->get();
        return view('standard_criteria.sub_indicator.create', compact('criteria', 'indicator'));
    }

    public function store_sub(Request $request){
        $validatedData = $request->validate([
            'indicator_id' => 'required|exists:indicators,id',
            'numForms' => 'required|integer|min:1',
            'sub_indicators' => 'required|array|min:1',
            'sub_indicators.*.name' => 'required|string',
        ]);

        $indicator_id = $request->indicator_id;

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

    public function data_sub(Request $request)
    {
        $data = SubIndicator::
        with(['indicator' => function ($query) {
            $query->select('id','name');
        },
        'criteria' => function ($query) {
            $query->select('id','title');
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
