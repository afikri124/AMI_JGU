<?php

namespace App\Http\Controllers;

use App\Models\QuestionCategory;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class QuestionCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function question(Request $request) {
        return view('question_category.index');
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

    // public function category_delete(Request $request) {
    //     $check = Observation_Category::where('questionqategory_id',$request->id)->first();
    //     if($check){
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Not Allowed! Category Already used.'
    //         ]);
    //     }
    //     $data = QuestionCategory::find($request->id);
    //     if($data){
    //         Log::warning(Auth::user()->username." deleted Category #".$data->id.", title : ".$data->title);
    //         $data->delete();
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Record deleted successfully!'
    //         ]);
    //     } else {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Failed to delete!'
    //         ]);
    //     }
    // }
}