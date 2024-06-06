<?php

namespace App\Http\Controllers;

use App\Models\AuditPlan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Location;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;


class AuditDocController extends Controller{
    public function index(Request $request){
        $data = AuditPlan::all();
        $locations = Location::orderBy('title')->get();
        return view('audit_doc.index', compact('data', 'locations'));
    }

    public function add(Request $request){
        if ($request->isMethod('POST')) {
            $this->validate($request, [
            'doc_path'  => 'required','mime s:jpg,jpeg,png,pdf','max:5120',
            'link'      => 'required',
        ]);

        $fileName = "";
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
                    $fileName = "";
                }
            }
            //document upload
            $data = AuditPlan::create([
            'doc_path'          => $fileName,
            'link'              => $request->link,
        ]);
        //dd($request);
        if($data){
            return redirect()->route('audit_doc.index')->with('Success', 'Document Anda berhasil di Upload');
        }
    }
}

    public function delete(Request $request){
        $data = AuditPlan::find($request->id);
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
        $data = AuditPlan::
        with(['lecture' => function ($query) {
                $query->select('id','name');
            },
            'auditstatus' => function ($query) {
                $query->select('id', 'title', 'color');
            },
            'location' => function ($query) {
                $query->select('id', 'title');
            }
            ])->select('*')->orderBy("id");
            return DataTables::of($data)
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('lecture_id'))) {
                    $instance->where("lecture_id", $request->get('lecture_id'));
                }
                if (!empty($request->get('search'))) {
                    $search = $request->get('search');
                    $instance->where('lecture_id', 'LIKE', "%$search%");
                }
            })->make(true);
    }

//Json
public function getData(){
    $data = AuditPlan::with('users')->with('auditstatus')->with('locations')->get()->map(function ($data) {
        return [
            'lecture_id' => $data->lecture_id,
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
