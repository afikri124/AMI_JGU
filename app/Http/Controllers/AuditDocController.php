<?php

namespace App\Http\Controllers;

use App\Models\AuditPlan;
use App\Models\AuditStatus;
use App\Models\Department;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\User;
use App\Models\Location;
use Illuminate\Contracts\Encryption\DecryptException;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;


class AuditDocController extends Controller{
    public function index(Request $request){
        if ($request->isMethod('POST')) {
            $this->validate($request, [
            'audit_plan_id'    => ['required'],
            'doc_path'    => ['required'],
            'date'    => ['required'],
            'audit_doc_list_name_id'    => ['required'],
            'audit_doc_status_id'   => ['required'],
            'remark_by_auditor'    => ['required'],
            'remark_by_lecture'    => ['required'],
            'link'    => ['required'],
        ]);
        $fileName = "";
            if(isset($request->doc_path)){
                $ext = $request->doc_path->extension();
                $name = str_replace(' ', '_', $request->doc_path->getClientOriginalName());
                $fileName = Auth::user()->id.'_'.$name; 
                $folderName =  "storage/FILE/".Carbon::now()->format('Y/m');
                $path = public_path()."/".$folderName;
                if (!File::exists($path)) {
                    File::makeDirectory($path, 0755, true); //create folder
                }
                $upload = $request->doc_path->move($path, $fileName); //upload image to folder
                if($upload){
                    $fileName=$folderName."/".$fileName;
                } else {
                    $fileName = "";
                }
            }
            
        $data = AuditPlan::create([
            'audit_plan_id'=> $request->audit_plan_id,
            'doc_path'=> $request->doc_path,
            'date'=> $request->date,
            'audit_doc_list_name_id'=> $request->audit_doc_list_name_id,
            'audit_doc_status_id'=> $request->audit_doc_status_id,
            'remark_by_auditor'=> $request->remark_by_auditor,
            'remark_by_lecture'=> $request->remark_by_lecture,
            'link'=> $request->link,
        ]);
        if($data){
            return redirect()->route('audit_doc.index');
            }
        }
        $data = AuditPlan::all();
        $locations = Location::all();
        $users = User::all();
        return view("audit_doc.index",compact("data", "locations", "users"));
    }

    public function edit($id){
        try {
            $o_id = Crypt::decrypt($id);
        } catch (DecryptException $e) {
            return redirect()->route('audit_doc.index');
        }
        $data = AuditPlan::findOrFail($id);
        $auditStatus = AuditStatus::all();
        $locations = Location::all();
        $users = User::with(['roles' => function ($query) {
            $query->select( 'id','name' );
        }])->where('name',"!=",'admin')->orderBy('name')->get();
        $departments = Department::all();
        return view('audit_plan.edit_doc', compact('data', 'auditStatus', 'locations', 'users', 'departments'));
    }

        public function update(Request $request, $id){
        $request->validate([
            'audit_plan_id'    => 'required',
            'doc_path'    => 'required',
            'date'    => 'required',
            'audit_doc_list_name_id'    => 'required',
            'audit_doc_status_id'   => 'required',
            'remark_by_auditor'    => 'required',
            'remark_by_lecture'    => 'required',
            'link'    => 'required',
        ]);

        $data = AuditPlan::findOrFail($id);
        $fileName = $data->doc_path;
        if(isset($request->doc_path)){
            $name = str_replace(' ', '_', $request->doc_path->getClientOriginalName());
            $fileName = Auth::user()->id.'_'.$name; 
            $folderName =  "storage/FILE/".Carbon::now()->format('Y/m');
            $path = public_path()."/".$folderName;
            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true); //create folder
            }
            $upload = $request->doc_path->move($path, $fileName); //upload image to folder
            if($upload){
                $fileName=$folderName."/".$fileName;
                if($data->doc_path != null){
                    File::delete(public_path()."/".$data->doc_path);
                }
            } else {
                $fileName = $data->file_path;
            }
        }
        $data->update([
            'audit_plan_id'=> $request->audit_plan_id,
            'doc_path'=> $request->doc_path,
            'date'=> $request->date,
            'audit_doc_list_name_id'=> $request->audit_doc_list_name_id,
            'audit_doc_status_id'=> $request->audit_doc_status_id,
            'remark_by_auditor'=> $request->remark_by_auditor,
            'remark_by_lecture'=> $request->remark_by_lecture,
            'link'=> $request->link,
        ]);
        return redirect()->route('audit_doc.index')->with('Success', 'Audit Plan berhasil diperbarui.');
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
            }])->with(['auditStatus' => function ($query) {
                $query->select('id','title');
            }])->with(['auditor' => function ($query) {
                $query->select('id','name');
            }])->select('*')->orderBy("id");
            return DataTables::of($data)
                    ->filter(function ($instance) use ($request) {
                        if (!empty($request->get('auditor_id'))) {
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
        $data = AuditPlan::with('users')->with('auditStatus')->with('locations')->get()->map(function ($data) {
            return [
                'audit_plan_id'=> $data->audit_plan_id,
                'doc_path'=> $data->doc_path,
                'date'=> $data->date,
                'audit_doc_list_name_id'=> $data->audit_doc_list_name_id,
                'audit_doc_status_id'=> $data->audit_doc_status_id,
                'remark_by_auditor'=> $data->remark_by_auditor,
                'remark_by_lecture'=> $data->remark_by_lecture,
                'link'=> $data->link,
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
