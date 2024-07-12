<?php

namespace App\Http\Controllers;

use App\Mail\sendEmail;
use App\Models\AuditPlan;
use App\Models\AuditPlanAuditor;
use App\Models\AuditPlanCategory;
use App\Models\AuditPlanCriteria;
use App\Models\AuditStatus;
use App\Models\Department;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use App\Models\User;
use App\Models\Location;
use App\Models\StandardCategory;
use App\Models\StandardCriteria;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class AuditPlanController extends Controller
{
    public function index(Request $request)
    {
        $data = AuditPlan::all();
        $auditee = User::with(['roles' => function ($query) {
            $query->select('id', 'name');
        }])
            ->whereHas('roles', function ($q) use ($request) {
                $q->where('name', 'auditee');
            })
            ->orderBy('name')->get();
        return view('audit_plan.index', compact('data', 'auditee'));
    }

    public function add(Request $request)
    {
        if ($request->isMethod('POST')) {
            $this->validate($request, [
                'auditee_id'            => ['required'],
                'date_start'            => ['required'],
                'date_end'              => ['required'],
                'email'                 => ['required'],
                'no_phone'              => ['required'],
                'location_id'           => ['required'],
                'link'                  => ['string'],
            ]);
            $data = AuditPlan::create([
                'auditee_id'                => $request->auditee_id,
                'date_start'                => $request->date_start,
                'date_end'                  => $request->date_end,
                'email'                     => $request->email,
                'no_phone'                  => $request->no_phone,
                'audit_status_id'           => '1',
                'location_id'               => $request->location_id,
                'department_id'             => $request->department_id,
                'doc_path'                  => $request->doc_path,
                'link'                      => $request->link,
                'remark_docs'               => $request->remark_docs,
            ]);
            if ($request->auditor_id) {
                foreach ($request->auditor_id as $auditorId) {
                    AuditPlanAuditor::create([
                        'audit_plan_id'         => $data->id,
                        'auditor_id'            => $auditorId,
                    ]);
                }
            }
            if ($data) {
                return redirect()->route('audit_plan.index')->with('msg', 'Data (' . $request->auditee_id . ') pada tanggal ' . $request->date_start . ' BERHASIL ditambahkan!!');
            }
        }

        $audit_plan = AuditPlan::with('auditstatus')->get();
        $locations = Location::orderBy('title')->get();
        $departments = Department::orderBy('name')->get();
        $auditStatus = AuditStatus::get();
        $category = StandardCategory::where('status', true)->get();
        $criterias = StandardCriteria::where('status', true)->get();
        $auditee = User::with(['roles' => function ($query) {
            $query->select('id', 'name');
        }])
            ->whereHas('roles', function ($q) use ($request) {
                $q->where('name', 'auditee');
            })
            ->orderBy('name')->get();

        $auditor = User::with(['roles' => function ($query) {
            $query->select('id', 'name');
        }])
            ->whereHas('roles', function ($q) use ($request) {
                $q->where('name', 'auditor');
            })
            ->orderBy('name')->get();

        $data = AuditPlan::all();

        return view("audit_plan.add", compact("data", "category", "criterias", "auditee", "auditor", "locations", "auditStatus", "departments", "audit_plan"));
    }


    public function edit(Request $request, $id)
    {
        $data = AuditPlan::findOrFail($id);
        $locations = Location::orderBy('title')->get();
        $auditor = User::with(['roles' => function ($query) {
            $query->select('id', 'name');
        }])
            ->whereHas('roles', function ($q) use ($request) {
                $q->where('name', 'auditor');
            })
            ->orderBy('name')->get();
        return view('audit_plan.edit_audit', compact('data', 'locations', 'auditor'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'date_start'    => 'required',
            'date_end'    => 'required',
            'auditor_id' => 'required',
            'location_id'    => 'required',
        ]);

        $data = AuditPlan::findOrFail($id);
        $data->update([
            'date_start' => $request->date_start,
            'date_end' => $request->date_end,
            'audit_status_id' => '2',
            'auditor_id' => $request->auditor_id,
            'location_id' => $request->location_id,
        ]);
        return redirect()->route('audit_plan.index')->with('msg', 'Audit Plan berhasil diperbarui.');
    }

    // Delete Audit Plane
    public function delete(Request $request)
{
    $auditPlan = AuditPlan::find($request->id);

    if ($auditPlan) {
        // Menghapus relasi dengan audit plan categories
        // AuditPlanCategory::where('audit_plan_id', $auditPlan->id)->delete();

        // Menghapus relasi dengan audit plan auditors
        AuditPlanAuditor::where('audit_plan_id', $auditPlan->id)->delete();

        // Menghapus relasi dengan audit plan criterias
        // AuditPlanCriteria::where('audit_plan_id', $auditPlan->id)->delete();

        // Menghapus audit plan itu sendiri
        $auditPlan->delete();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil dihapus!'
        ]);
    } else {
        return response()->json([
            'success' => false,
            'message' => 'Gagal dihapus! Data tidak ditemukan.'
        ]);
    }
}

    public function data(Request $request)
    {
        $data = AuditPlan::with([
            'auditee' => function ($query) {
                $query->select('id', 'name');
            },
            'auditstatus' => function ($query) {
                $query->select('id', 'title', 'color');
            },
            'auditorId' => function ($query) {
                $query->select('id', 'name');
            },
            'category' => function ($query) {
                $query->select('id', 'description', 'status');
            },
            'criteria' => function ($query) {
                $query->select('id', 'title', 'status');
            },
            'departments' => function ($query) {
                $query->select('id', 'name');
            },
        ])
            ->leftJoin('locations', 'locations.id', '=', 'location_id')
            ->select(
                'audit_plans.*',
                'locations.title as location'
            )->orderBy("id");
        return DataTables::of($data)
            ->filter(function ($instance) use ($request) {
                //jika pengguna memfilter berdasarkan roles
                if (!empty($request->get('select_lecture'))) {
                    $instance->whereHas('auditee', function ($q) use ($request) {
                        $q->where('auditee_id', $request->get('select_lecture'));
                    });
                }
                if (!empty($request->get('search'))) {
                    $instance->where(function ($w) use ($request) {
                        $search = $request->get('search');
                        $w->orWhere('date_start', 'LIKE', "%$search%")
                            ->orWhere('date_end', 'LIKE', "%$search%");
                    });
                }
            })->make(true);
    }



    // CHOOSE STANDARD AUDIT
    public function standard(Request $request, $id)
    {
        $data = AuditPlanAuditor::findOrFail($id);
        $categoryId = StandardCategory::all();
        $criteriaId = StandardCriteria::all();
        $auditor = AuditPlanAuditor::where('audit_plan_id', $id)->get();
        return view('audit_plan.standard.index', compact('data', 'auditor', 'categoryId', 'criteriaId'));
    }

    public function create(Request $request, $id)
    {
        $data = AuditPlanAuditor::findOrFail($id);
        $category = StandardCategory::where('status', true)->get();
        $criteria = StandardCriteria::where('status', true)->get();

        $auditor = User::with(['roles' => function ($query) {
            $query->select('id', 'name');
        }])
        ->whereHas('roles', function ($q) use ($request) {
            $q->where('name', 'auditor');
        })
        ->where('id', $data->auditor_id) // Gunakan ID dari data yang diambil
        ->orderBy('name')
        ->get();

        // // Ambil kriteria yang sudah dipilih oleh auditor lain
        // $selectedCriteria = AuditPlanAuditor::where('auditor_id', '!=', $id)
        // ->pluck('standard_criteria_id')
        // ->flatten()
        // ->unique();

        return view("audit_plan.standard.create", compact("data", "category", "criteria", "auditor"
        // "selectedCriteria"
        ));
    }

    public function update_std(Request $request, $id)
    {
        if ($request->isMethod('POST')) {
            $this->validate($request, [
                'auditor_id' => 'required',
                'standard_criteria_id' => 'required',
                'standard_category_id' => 'required',
            ]);
            // dd($request->all());

            $data = AuditPlanAuditor::findOrFail($id);

            if ($request->standard_category_id) {
                foreach ($request->standard_category_id as $categoryId) {
                    AuditPlanCategory::create([
                        'audit_plan_auditor_id' => $data->id,
                        'standard_category_id'  => $categoryId,
                    ]);
                }
            }

            if ($request->standard_criteria_id) {
                foreach ($request->standard_criteria_id as $criteriaId) {
                    AuditPlanCriteria::create([
                        'audit_plan_auditor_id'=> $data->id,
                        'standard_criteria_id' => $criteriaId,
                    ]);
                }
            }
        }


        return redirect()->route('audit_plan.index')->with('msg', 'Data Berhasil di tambahkan!!');
    }

    // public function getStandardCategoryId(Request $request)
    // {
    //     $category = StandardCategory::where('standard_category_id', $request->id)->get();
    //     return response()->json($category);
    // }

    public function getStandardCriteriaId(Request $request)
    {
        $criteria = StandardCriteria::where('standard_category_id', $request->id)->get();
        return response()->json($criteria);
    }

    public function data_auditor(Request $request, $id)
    {
        $data = AuditPlanAuditor::where('audit_plan_id', $id)->
        with([
            'auditor' => function ($query) {
                $query->select('id', 'name');
            }
        ])->orderBy("id");

        // Gunakan DataTables untuk memfilter dan membuat respons JSON
        return DataTables::of($data)
            ->filter(function ($query) use ($request) {
                // Filter berdasarkan auditee jika dipilih
                if (!empty($request->get('select_auditee'))) {
                    $query->where('auditee_id', $request->get('select_auditee'));
                }

                // Pencarian umum
                if (!empty($request->get('search'))) {
                    $query->where(function ($w) use ($request) {
                        $search = $request->get('search');
                        $w->orWhere('date_start', 'LIKE', "%$search%")
                            ->orWhere('date_end', 'LIKE', "%$search%");
                    });
                }
            })
            ->make(true);
    }


    public function datatables()
    {
        $data = AuditPlan::select('*');
        return DataTables::of($data)->make(true);
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
