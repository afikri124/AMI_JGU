<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use Symfony\Component\Console\Question\Question;
use App\Models\Question;

class QuestionController extends Controller
{
    public function question(Request $request) {
        return view('question.index');
    }


    public function data(Request $request) {
        if ($request->isMethod('post')) {
            $this->validate($request, [ 
                'id'=> ['required'],
                'title'=> ['required', 'string', 'max:191'],
            ]);
            Question::insert(request()->except(['_token']));
            return redirect()->route('question.index');
        } 
        return view('question.add_qst');
    }
}
