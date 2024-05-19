<?php

namespace App\Http\Controllers;

use App\Models\NotificationAudit;
use App\Http\Requests\StoreNotificationAuditRequest;
use App\Http\Requests\UpdateNotificationAuditRequest;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class NotificationAuditController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request){
        if ($request->isMethod('POST')){ $this->validate($request, [
            'date'    => ['required'],
            'program'    => ['required'],
            'auditor_id'    => ['required'],
        ]);
        $new = NotificationAudit::create([
            'date'=> $request->date,
            'program'=> $request->program,
            'auditor_id'=> $request->auditor_id,
        ]);
        if($new){
            return redirect()->route('notification.index');
        }
    }
        $data = NotificationAudit::all();
        return view("notification.index",compact("data"));
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
    public function store(StoreNotificationAuditRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(NotificationAudit $notificationAudit)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(NotificationAudit $notificationAudit)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateNotificationAuditRequest $request, NotificationAudit $notificationAudit)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(NotificationAudit $notificationAudit)
    {
        //
    }
}
