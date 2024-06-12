<?php

namespace App\Http\Controllers;

use App\Models\AuditStatus;
use App\Models\StandardCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Yajra\DataTables\Facades\DataTables;

class StandardCategoryController extends Controller
{
    public function category(Request $request) {
        $data = StandardCategory::all();
        return view('standard_category.category', compact('data'));
    }

    public function category_add(Request $request) {
        if ($request->isMethod('POST')) {
            $is_required = $request->has('is_required') ? $request->is_required : false;
            $this->validate($request, [
                'id'=> ['required', 'string', 'max:191', Rule::unique('standard_categories')],
                'title'=> ['required', 'string', 'max:191'],
                'description'=> ['required', 'string', 'max:191'],
                'is_required'=> ['boolean'],
            ]);
            StandardCategory::create([
                'id'=> $request->id,
                'title'=> $request->title,
                'status_id'=> '10',
                'description'=> $request->description,
                'is_required' => $is_required,
            ]);
            return redirect()->route('standard_category.category');
        }
        return view('standard_category.category_add');
    }

    public function category_edit(Request $request, $id){
        $data = StandardCategory::find($id);
        $status = AuditStatus::orderBy('title')->get();
        return view('standard_category.category_edit', compact('data', 'status'));
    }

    public function data(Request $request){
        $data = StandardCategory::
        with(['status' => function ($query) {
            $query->select('id','title','color');
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
