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
        $status = AuditStatus::get();
        return view('standard_category.category', compact('data', 'status'));
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
                'audit_status_id'=> '10',
                'description'=> $request->description,
                'is_required' => $is_required,
            ]);
            return redirect()->route('standard_category.category')->with('msg', 'Data ('.$request->description.') berhasil di tambahkan');
        }
        return view('standard_category.category_add');
    }

    public function category_edit($id){
        $data = StandardCategory::findOrFail($id);
        $status = AuditStatus::whereIn('id', [10, 11])->get(); 
        //dd($data);
        return view('standard_category.category_edit', compact('data', 'status'));
    }

    public function category_update(Request $request, $id){
        $is_required = $request->has('is_required') ? $request->is_required : false;
        $request->validate([
            'description'    => 'string', 'max:191',
            'is_required' => 'boolean',
            'audit_status_id' => 'string'
        ]);

        $data = StandardCategory::findOrFail($id);
        $data->update([
            'audit_status_id'=> $request->audit_status_id,
            'description'=> $request->description,
            'is_required'=> $is_required,
        ]);
        return redirect()->route('standard_category.category')->with('msg', 'Standard Category berhasil diperbarui.');
    }

    public function delete(Request $request){
        $data = StandardCategory::find($request->id);
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

    public function data(Request $request){
        $data = StandardCategory::
        with(['status' => function ($query) {
            $query->select('id','title','color');
        }])->select('*')->orderBy("id")->get();
            return DataTables::of($data)
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('Select_2'))) {
                    $instance->whereHas('status', function($q) use($request){
                        $q->where('audit_status_id', $request->get('Select_2'));
                    });
                }
            })->make(true);
    }
}
