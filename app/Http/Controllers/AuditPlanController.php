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
use App\Models\Observation;
use App\Models\StandardCategory;
use App\Models\StandardCriteria;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use App\Mail\CommentDocs;

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
            'auditee_id'      => ['required'],
            'date_start'      => ['required'],
            'date_end'        => ['required'],
            'location_id'     => ['required'],
            'link'            => ['string'],
            'department_id'   => ['required'],
            'type_audit'      => ['required'],
            'periode'         => ['required'],
        ]);

        $auditee = User::find($request->auditee_id);

        $data = AuditPlan::create([
            'auditee_id'      => $request->auditee_id,
            'date_start'      => $request->date_start,
            'date_end'        => $request->date_end,
            'audit_status_id' => '1',
            'location_id'     => $request->location_id,
            'department_id'   => $request->department_id,
            'link'            => $request->link,
            'type_audit'      => $request->type_audit,
            'periode'         => $request->periode,
        ]);

        if ($request->auditor_id) {
            foreach ($request->auditor_id as $auditorId) {
                AuditPlanAuditor::create([
                    'audit_plan_id' => $data->id,
                    'auditor_id'    => $auditorId,
                ]);
            }
        }

        if ($data) {
            // Tambahkan email notification
            $department = Department::find($request->department_id);

            if ($auditee) {
                // Data untuk email
                $emailData = [
                    'lecture_id'    => $auditee->name,
                    'remark_docs'   => $request->remark_docs ?? 'N/A', // Pastikan remark_docs ada atau berikan nilai default
                    'date_start'    => $request->date_start,
                    'date_end'      => $request->date_end,
                    'department_id' => $department ? $department->name : null,
                ];

                // Kirim email ke pengguna yang ditemukan
                Mail::to($auditee->email)->send(new CommentDocs($emailData));

                // Redirect dengan pesan sukses
                return redirect()->route('audit_plan.standard', ['id' => $data->id])
                    ->with('msg', 'Data ' . $auditee->name . ' on date ' . $request->date_start . ' until date ' . $request->date_end . ' successfully added and email sent!!');
            } else {
                // Redirect dengan pesan error jika pengguna tidak ditemukan
                return redirect()->route('audit_plan.standard', ['id' => $data->id])
                    ->with('msg', 'Data ' . $auditee->name . ' on date ' . $request->date_start . ' until date ' . $request->date_end . ' successfully added, but email not sent - user not found.');
            }
        }

        return redirect()->back()->with('msg', 'Failed to add data.');
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
        // Mendapatkan data audit plan berdasarkan id
        $data = AuditPlan::findOrFail($id);

        // Mendapatkan semua lokasi
        $locations = Location::orderBy('title')->get();

        // Mendapatkan auditor yang memiliki peran 'auditor'
        $auditors = User::with(['roles' => function ($query) {
            $query->select('id', 'name');
        }])
        ->whereHas('roles', function ($q) {
            $q->where('name', 'auditor');
        })
        ->orderBy('name')->get();

        // Mendapatkan semua auditor_id dari tabel audit_plan_auditor yang terkait dengan audit_plan_id
        $selectedAuditors = AuditPlanAuditor::where('audit_plan_id', $id)->pluck('auditor_id')->toArray();

        return view('audit_plan.edit_audit', compact('data', 'locations', 'auditors', 'selectedAuditors'));
    }


    public function update(Request $request, $id)
    {
    $request->validate([
        'date_start' => 'required',
        'date_end' => 'required',
        'location_id' => 'required',
        'auditor_id' => 'array',
    ]);

    $data = AuditPlan::findOrFail($id);
    $updateData = [
        'date_start' => $request->date_start,
        'date_end' => $request->date_end,
        'location_id' => $request->location_id,
    ];

    $data->update($updateData);

    // Ambil semua auditor saat ini dari database untuk audit plan ini
    $currentAuditors = $data->auditor->pluck('auditor_id')->toArray();

    // Ambil auditor baru dari form
    $newAuditors = $request->auditor_id;

    // Hapus auditor yang tidak ada di form
    $auditorsToDelete = array_diff($currentAuditors, $newAuditors);
    AuditPlanAuditor::where('audit_plan_id', $id)
                    ->whereIn('auditor_id', $auditorsToDelete)
                    ->delete();

    // Tambahkan atau perbarui auditor baru
    foreach ($newAuditors as $auditor) {
        AuditPlanAuditor::updateOrCreate(
            ['audit_plan_id' => $id, 'auditor_id' => $auditor]
        );
    }

    return redirect()->route('audit_plan.index')->with('msg', 'Audit Plan updated successfully.');
}


    // Delete Audit Plan
    public function delete(Request $request)
    {
        // Find the AuditPlan by ID
        $auditPlan = AuditPlan::find($request->id);

        if ($auditPlan) {
            // First, delete related AuditPlanAuditor records
            $auditPlan->auditor()->delete();

            // Then, delete related Observation records
            $auditPlan->observation()->delete();

            // Finally, delete the AuditPlan itself
            $auditPlan->delete();

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

    public function data(Request $request)
    {
        $data = AuditPlan::with([
            'auditee' => function ($query) {
                $query->select('id', 'name', 'no_phone');
            },
            'auditstatus' => function ($query) {
                $query->select('id', 'title', 'color');
            },
            'auditorId' => function ($query) {
                $query->select('id', 'name', 'no_phone');
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
                'locations.title as location',
            )->orderBy("id");
        return DataTables::of($data)
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('select_auditee'))) {
                    $instance->whereHas('auditee', function ($q) use ($request) {
                        $q->where('auditee_id', $request->get('select_auditee'));
                    });
                }
                if (!empty($request->get('search'))) {
                    $instance->where(function ($w) use ($request) {
                        $search = $request->get('search');
                        $w->orWhere('date_start', 'LIKE', "%$search%")
                        ->orWhere('date_end', 'LIKE', "%$search%")
                        ->orWhere('locations.title', 'LIKE', "%$search%")
                        ->orWhereHas('auditee', function ($query) use ($search) {
                            $query->where('name', 'LIKE', "%$search%");
                        });
                    });
                }
            })->make(true);
    }




    // ------------- CHOOSE STANDARD AUDITOR ---------------
    public function standard(Request $request, $id)
    {
        $data = AuditPlanAuditor::findOrFail($id);
        $auditor = AuditPlanAuditor::where('audit_plan_id', $id)->get();
        return view('audit_plan.standard.index', compact('data', 'auditor'));
    }

    public function edit_auditor_std(Request $request, $id)
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
        ->where('id', $data->auditor_id)
        ->orderBy('name')
        ->get();

        $selectedCategory = AuditPlanCategory::where('audit_plan_auditor_id', $id)->pluck('standard_category_id')->toArray();
        $selectedCriteria = AuditPlanCriteria::where('audit_plan_auditor_id', $id)->pluck('standard_criteria_id')->toArray();

        return view("audit_plan.standard.edit", compact("data", "category", "criteria", "auditor", "selectedCategory", "selectedCriteria"));
    }

    public function update_auditor_std(Request $request, $id)
    {
    // Validate the incoming request data
    $this->validate($request, [
        'auditor_id' => 'required|exists:users,id',
        'standard_category_id' => 'required|array',
        'standard_criteria_id' => 'required|array',
    ]);

    // Find the AuditPlanAuditor record by ID
    foreach ($request->standard_category_id as $categoryId) {
        AuditPlanCategory::updateOrCreate([
            'audit_plan_auditor_id' => $id,
            'standard_category_id' => $categoryId,
        ]);
    }

    // Create records for standard criteria
    foreach ($request->standard_criteria_id as $criteriaId) {
        AuditPlanCriteria::updateOrCreate([
            'audit_plan_auditor_id' => $id,
            'standard_criteria_id' => $criteriaId,
        ]);
    }
    // Redirect with a success message
    return redirect()->route('audit_plan.standard', ['id' => $id])
        ->with('msg', 'Auditor data to determine each Standard was added successfully!');
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
        $data = AuditPlanAuditor::where('audit_plan_id',$id)->
        with([
            'auditor' => function ($query) {
                $query->select('id', 'name', 'no_phone');
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
