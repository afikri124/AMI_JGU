<?php

namespace App\Http\Controllers;

use App\Models\AuditStatus;
use App\Models\StandardCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables as DataTablesDataTables;
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
                'description'=> $request->description,
                'is_required' => $is_required,
            ]);
            return redirect()->route('standard_category.category')->with('msg', 'Data('.$request->description.') added successfully');
        }
        return view('standard_category.category_add');
    }

    public function category_edit($id){
        $data = StandardCategory::findOrFail($id);
        //dd($data);
        return view('standard_category.category_edit', compact('data'));
    }

    public function category_update(Request $request, $id){
        $is_required = $request->has('is_required') ? $request->is_required : false;
        $request->validate([
            'description'    => 'string', 'max:191',
            'is_required' => 'boolean',
            'status' => 'boolean'
        ]);

        $data = StandardCategory::findOrFail($id);
        $data->update([
            'status'=> $request->status,
            'description'=> $request->description,
            'is_required'=> $is_required,
        ]);
        return redirect()->route('standard_category.category')->with('msg', 'Standard Category updated successfully.');
    }

    public function delete(Request $request){
        $data = StandardCategory::find($request->id);
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

    public function data(Request $request){
        $data = StandardCategory::select('*');
        
            return Datatables::of($data)
                    ->filter(function ($instance) use ($request) {
                        if (!empty($request->get('status'))) {
                            $bools = $request->get('status') === 'true'? true : false;
                            $instance->where('status', $bools);
                            }
                        if (!empty($request->get('search'))) {
                                $instance->where(function($w) use($request){
                                $search = $request->get('search');
                                    $w->orWhere('id', 'LIKE', "%$search%", 'i')
                                    ->orWhere('title', 'LIKE', "%$search%")
                                    ->orWhere('description', 'LIKE', "%$search%");
                            });
                        }
            })
                    ->make(true);
    }
}
