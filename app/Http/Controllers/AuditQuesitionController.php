<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAuditStandardRequest;
use App\Http\Requests\UpdateAuditStandardRequest;
use App\Models\AuditQuesition;
use Illuminate\Http\Request;

class AuditQuesitionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request) {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'id'=> ['required', 'string', 'max:191'],
                'title'=> ['required', 'string', 'max:191'],
                'description'=> ['required', 'string', 'max:191'],
            ]);
            $data = AuditQuesition::create([
                'id'=> $request->id,
                'title'=> $request->title,
                'description' => $request->description,
            ]);
            if($data){
                return redirect()->route('`audit_quesition`.index')->with('message','Data Auditee ('.$request->user_id.') pada tanggal '.$request->date.' BERHASIL ditambahkan!!');
                }
        }
        $data = AuditQuesition::all();
        return view('audit_quesition.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAuditStandardRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(AuditQuesition $auditQuesition)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AuditQuesition $auditQuesition)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAuditStandardRequest $request, AuditQuesition $auditQuesition)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AuditQuesition $auditQuesition)
    {
        //
    }
}
