<?php

namespace App\Http\Controllers;

use App\Models\QuestionCategory;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class QuestionCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function question(Request $request) {
        $data = QuestionCategory::all();
        return view('question_category.index', compact('data'));
    }

    public function question_add(Request $request) {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'id'=> ['required', 'string', 'max:191'],
                // Rule::unique('criteria_question')],
                'title'=> ['required', 'string', 'max:191'],
            ]);
            QuestionCategory::insert(request()->except(['_token']));
            return redirect()->route('question_category.index');
        }
        return view('question_category.add_qst');
    }

    public function data(Request $request){
        $data = QuestionCategory::select('*')->orderBy("id");
            return DataTables::of($data);
    }

    // public function category_edit($id, Request $request) {
    //     if ($request->isMethod('post')) {
    //         $this->validate($request, [
    //             'id'=> ['required', 'string', 'max:191'],
    //             // Rule::unique('criteria_question')->ignore($id, 'id')],
    //             'title'=> ['required', 'string', 'max:191'],
    //         ]);
    //         $data = QuestionCategory::find($id)->update([
    //             'id' => $request->id,
    //             'title' => $request->title,
    //             'status' => $request->status,
    //             'description' => $request->description,
    //             'is_required' => ($request->is_required == null ? 0:$request->is_required ),
    //         ]);
    //         return redirect()->route('settings.question');

    //     }
    //     $data = QuestionCategory::find($id);
    //     if($data == null){
    //         abort(403, "Cannot access to restricted page");
    //     }
    //     return view('settings.question_edit', compact('data'));
    // }

    public function delete(Request $request){
        $data = QuestionCategory::find($request->id);
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

}
