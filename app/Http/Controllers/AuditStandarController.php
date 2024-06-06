<?php

namespace App\Http\Controllers;

use App\Models\AuditStandar;
use App\Http\Requests\StoreAuditStandarRequest;
use App\Http\Requests\UpdateAuditStandarRequest;
use Illuminate\Http\Request;


class AuditStandarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request){
        {
        $data = AuditStandar::all();
        return view('standar.index', compact('data'));
    }
}

    /**
     * Show the form for creating a new resource.
     */
    public function standar_add(Request $request) {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'id'=> ['required', 'string', 'max:191'],
                'title'=> ['required', 'string', 'max:191'],
            ]);
            AuditStandar::insert(request()->except(['_token']));
            return redirect()->route('standar.index');
        }
        return view('standar.add_standar');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAuditStandarRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(AuditStandar $auditStandar)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AuditStandar $auditStandar)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAuditStandarRequest $request, AuditStandar $auditStandar)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AuditStandar $auditStandar)
    {
        //
    }
}
