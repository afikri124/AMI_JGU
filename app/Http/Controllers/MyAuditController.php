<?php

namespace App\Http\Controllers;

use App\Models\AuditPlan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;


class MyAuditController extends Controller{
    public function index(Request $request){
        $data = AuditPlan::all();
        return view('my_audit.index', compact('data'));
    }

    public function add($id)
    {
        $data = AuditPlan::findOrFail($id);
        return view('my_audit.add', compact('data'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'doc_path' => 'mimes:pdf|max:10000|',
        ]);
        $fileName = null;
        if ($request->hasFile('doc_path')) {
            $ext = $request->doc_path->extension();
            $name = str_replace(' ', '_', $request->doc_path->getClientOriginalName());
            $fileName = Auth::user()->id . '_' . $name;
            $folderName = "storage/FILE/" . Carbon::now()->format('Y/m');
            $path = public_path() . "/" . $folderName;
            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true); //create folder
            }
            $upload = $request->doc_path->move($path, $fileName); //upload file to folder
            if ($upload) {
                $fileName = $folderName . "/" . $fileName;
            } else {
                $fileName = null;
            }
        }
        //document upload
        $data = AuditPlan::findOrFail($id);
        $data->update([
        'doc_path'          => $fileName,
        'audit_status_id'   => '10',
    ]);
        return redirect()->route('my_audit.index')->with('msg', 'Thank you for uploading the document ');
    }

    public function show($id)
    {
        $data = AuditPlan::findOrFail($id);
        return view('my_audit.show', compact('data'));
    }

    public function delete(Request $request){
        $data = AuditPlan::find($request->id);
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
        $data = AuditPlan::
        with(['auditee' => function ($query) {
                $query->select('id','name', 'no_phone');
            },
            'auditstatus' => function ($query) {
                $query->select('id', 'title', 'color');
            },
            'auditorId' => function ($query) {
                $query->select('id', 'name', 'no_phone');
            },
            ])->leftJoin('locations', 'locations.id' , '=', 'location_id')
            ->select('audit_plans.*',
            'locations.title as location'
            )
            // ->where('auditee_id', Auth::user()->id)
            ->orderBy("id");
            return DataTables::of($data)
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('auditee_id'))) {
                    $instance->where("auditee_id", $request->get('auditee_id'));
                }
                if (!empty($request->get('search'))) {
                    $search = $request->get('search');
                    $instance->where('auditee_id', 'LIKE', "%$search%");
                }
                if (!empty($request->get('search'))) {
                    $instance->where(function($w) use($request){
                        $search = $request->get('search');
                            $w->orWhere('date_start', 'LIKE', "%$search%")
                            ->orWhere('date_end', 'LIKE', "%$search%");
                    });
                }
            })->make(true);
    }

//Json
    public function getData(){
        $data = AuditPlan::with('users')->with('auditstatus')->with('locations')->get()->map(function ($data) {
            return [
                'auditee_id' => $data->auditee_id,
                'date_start' => $data->date_start,
                'date_end' => $data->date_end,
                'audit_status_id' => '1',
                'location_id' => $data->location_id,
                'auditor_id' => $data->auditor_id,
                'department_id' => $data->department_id,
                'doc_path' => $data->doc_path,
                'link' => $data->link,
                'created_at' => $data->created_at,
                'updated_at' => $data->updated_at,
            ];
        });
        return response()->json($data);
        }

    public function datatables(){
        $audit_plan = AuditPlan::select('*');
        return DataTables::of($audit_plan)->make(true);
    }
}
