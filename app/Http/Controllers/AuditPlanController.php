<?php

namespace App\Http\Controllers;

use App\Mail\sendEmail;
use App\Models\AuditPlan;
use App\Models\AuditStatus;
use App\Models\Department;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\User;
use App\Models\Location;
use App\Models\StandardCategory;
use App\Models\StandardCriteria;
use Illuminate\Support\Facades\Mail;

class AuditPlanController extends Controller{
    public function index(Request $request){
        $data = AuditPlan::all();
        $lecture = User::with(['roles' => function ($query) {
            $query->select( 'id','name' );
        }])
        ->whereHas('roles', function($q) use($request){
            $q->where('name', 'lecture');
        })
        ->orderBy('name')->get();
        return view('audit_plan.index', compact('data', 'lecture'));
    }

    // public function getStandardCategoriesById(Request $request)
    // {
    //     $category = StandardCategory::where('id', $request->id)->get();
    //     return response()->json($category);
    // }

    // public function getStandardCriteriasById(Request $request)
    // {
    //     $criterias = StandardCriteria::where('standard_categories_id', $request->id)->get();
    //     return response()->json($criterias);
    // }

    public function add(Request $request) {
        if ($request->isMethod('POST')) {
            $this->validate($request, [
                'lecture_id'            => ['required'],
                'date_start'            => ['required'],
                'date_end'              => ['required'],
                'email'                 => ['required'],
                'no_phone'              => ['required'],
                'location_id'           => ['required'],
                'auditor_id'            => ['required'],
                'standard_criterias_id' => ['required'],
                'standard_categories_id'=> ['required'],
                'link'                  => ['string'],
            ]);
            $data = AuditPlan::create([
                'lecture_id'                => $request->lecture_id,
                'date_start'                => $request->date_start,
                'date_end'                  => $request->date_end,
                'email'                     => $request->email,
                'no_phone'                  => $request->no_phone,
                'audit_status_id'           => '1',
                'location_id'               => $request->location_id,
                'department_id'             => $request->department_id,
                'auditor_id'                => $request->auditor_id,
                'doc_path'                  => $request->doc_path,
                'link'                      => $request->link,
                'remark_docs'               => $request->remark_docs,
                'standard_categories_id'    => $request->standard_categories_id,
                'standard_criterias_id'     => $request->standard_criterias_id,
            ]);
            if ($data) {
                return redirect()->route('audit_plan.index')->with('msg', 'Data ('.$request->lecture_id.') pada tanggal '.$request->date_start.' BERHASIL ditambahkan!!');
            }
        }

        $audit_plan = AuditPlan::with('auditstatus')->get();
        $locations = Location::orderBy('title')->get();
        $departments = Department::orderBy('name')->get();
        $auditStatus = AuditStatus::get();
        $category = StandardCategory::where('status', true)->get();
        $criterias = StandardCriteria::where('status', true)->get();

        $lecture = User::with(['roles' => function ($query) {
            $query->select('id', 'name');
        }])
        ->whereHas('roles', function($q) use ($request) {
            $q->where('name', 'lecture');
        })
        ->orderBy('name')->get();

        $auditor = User::with(['roles' => function ($query) {
            $query->select('id', 'name');
        }])
        ->whereHas('roles', function($q) use ($request) {
            $q->where('name', 'auditor');
        })
        ->orderBy('name')->get();

        $data = AuditPlan::all();

        return view("audit_plan.add", compact("data", "category", "criterias", "lecture", "auditor", "locations", "auditStatus", "departments", "audit_plan"));
    }


    public function edit(Request $request, $id){
        $data = AuditPlan::findOrFail($id);
        $locations = Location::orderBy('title')->get();
        $auditor = User::with(['roles' => function ($query) {
            $query->select( 'id','name' );
        }])
        ->whereHas('roles', function($q) use($request){
            $q->where('name', 'auditor');
        })
        ->orderBy('name')->get();
        return view('audit_plan.edit_audit', compact('data', 'locations', 'auditor'));
    }

    public function update(Request $request, $id){
        $request->validate([
            'date_start'    => 'required',
            'date_end'    => 'required',
            'auditor_id' => 'required',
            'location_id'    => 'required',
        ]);

        $data = AuditPlan::findOrFail($id);
        $data->update([
            'date_start'=> $request->date_start,
            'date_end'=> $request->date_end,
            'audit_status_id'=> '2',
            'auditor_id'=> $request->auditor_id,
            'location_id'=> $request->location_id,
        ]);
        return redirect()->route('audit_plan.index')->with('msg', 'Audit Plan berhasil diperbarui.');
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

    // public function approve(Request $request)
    // {
    //     $data = AuditPlan::find($request->id);
    //     if ($data) {
    //         $data->audit_status_id = "4";
    //         $data->save();
    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Status berhasil diubah!'
    //         ]);
    //     } else {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Gagal mengubah status!'
    //         ]);
    //     }
    // }

    // public function revised(Request $request){
    //     $data = AuditPlan::find($request->id);
    //     if($data){
    //         $data->audit_status_id ="5";
    //         $data->save();
    //         return response()->json([
    //             'success' => true,
    //             'message' => ' Status berhasil diubah!'
    //         ]);
    //     } else {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Gagal mengubah status!'
    //         ]);
    //     }
    // }

    public function data(Request $request){
        $data = AuditPlan::
        with([
            'lecture' => function ($query) {
                $query->select('id','name');
            },
            'auditstatus' => function ($query) {
                $query->select('id', 'title', 'color');
            },
            'auditor' => function ($query) {
                $query->select('id', 'name');
            },
            'category' => function ($query) {
                $query->select('id', 'description', 'status');
            },
            'criterias' => function ($query) {
                $query->select('id', 'title', 'status');
            },
            'departments' => function ($query) {
                $query->select('id', 'name');
            },
        ])
        ->leftJoin('locations', 'locations.id' , '=', 'location_id')
        ->select('audit_plans.*',
        'locations.title as location'
        )->orderBy("id");
                return DataTables::of($data)
                    ->filter(function ($instance) use ($request) {
                        //jika pengguna memfilter berdasarkan roles
                        if (!empty($request->get('select_lecture'))) {
                            $instance->whereHas('lecture', function($q) use($request){
                                $q->where('lecture_id', $request->get('select_lecture'));
                            });
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
        $data = AuditPlan::select('*');
        return DataTables::of($data)->make(true);
    }
}
