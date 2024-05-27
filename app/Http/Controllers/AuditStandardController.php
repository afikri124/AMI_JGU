<?php

namespace App\Http\Controllers;

use App\Models\AuditStandard;
use Illuminate\Http\Request;
use App\Http\Requests\StoreAuditStandardRequest;
use App\Http\Requests\UpdateAuditStandardRequest;

class AuditStandardController extends Controller
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
            $data = AuditStandard::create([
                'id'=> $request->id,
                'title'=> $request->title,
                'description' => $request->description,
            ]);
            if($data){
                return redirect()->route('standard_audit.index')->with('message','Data Auditee ('.$request->user_id.') pada tanggal '.$request->date.' BERHASIL ditambahkan!!');
                }
        }
        $data = AuditStandard::all();
        return view('standard_audit.index');
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
    public function show(AuditStandard $auditStandard)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AuditStandard $auditStandard)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAuditStandardRequest $request, AuditStandard $auditStandard)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AuditStandard $auditStandard)
    {
        //
    }
}
