<?php

namespace App\Http\Controllers;

use App\Mail\sendEmail;
use App\Mail\reschedule;
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


class AuditPlanController extends Controller
{
    //Tampilan Audit Plan
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

    //Tambah Audit Plan
    public function add(Request $request)
    {
    if ($request->isMethod('POST')) {
        $this->validate($request, [
            'auditee_id'      => ['required'],
            'date_start'      => ['required'],
            'date_end'        => ['required'],
            'location_id'     => ['required'],
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
        // Send Email
        if ($auditee) {
            $department = Department::find($request->department_id);

            if ($auditee) {
                // Data untuk email
                $emailData = [
                    'lecture_id'           => (string) $request['lecture_id'],
                    'date_start'           => (string) $request['date_start'],
                    'date_end'             => (string) $request['date_end'],
                    'department_id'        => (string) $request['department_id'],
                    'location_id'          => (string) $request['location_id'],
                    'auditor_id'           => (string) $request['auditor_id'],
                    'standard_categories_id' => (string) $request['standard_categories_id'],
                    'standard_criterias_id' => (string) $request['standard_criterias_id'],
                    'link'                 => (string) $request['link'],
                ];

            // Kirim email ke pengguna yang ditemukan
            Mail::to($auditee->email)->send(new sendEmail($emailData));
            Mail::to($auditor->email)->send(new sendEmail($emailData));

            // Redirect dengan pesan sukses
            return redirect()->route('observations.index')->with('msg', 'Document telah di Review, Siap untuk Audit Lapangan');
        } else {
            // Redirect dengan pesan error jika pengguna tidak ditemukan
            return redirect()->route('observations.index')->with('msg', 'Pengguna tidak ditemukan');
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

    //Edit Audit Plan
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

    //Proses Edit Audit Plan
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
        'audit_status_id' => '2',
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

    // Kirim notifikasi email
    $auditee = User::find($data->auditee_id);
    if ($auditee) {
        $department = Department::find($data->department_id);
        $location = Location::find($data->location_id);

        // Assuming $request->auditor_id contains IDs of the auditors
        $auditorNames = [];
        foreach ($newAuditors as $auditorId) {
            $auditor = User::find($auditorId);
            if ($auditor) {
                $auditorNames[] = $auditor->name;
            }
        }

        // Data untuk email
        $emailData = [
            'auditor_id'    => implode(', ', $auditorNames), // Combine auditor names into a string
            'date_start'    => $request->date_start,
            'date_end'      => $request->date_end,
            'department_id' => $department ? $department->name : null,
            'location_id'   => $location ? $location->title : null,
            'subject'       => 'Reschedule Audit Plane' // Add the subject here
        ];

        // Kirim email ke auditee
        Mail::to($auditee->email)->send(new reschedule($emailData));

        // Kirim email ke auditor
        foreach ($newAuditors as $auditorId) {
            $auditor = User::find($auditorId);
            if ($auditor) {
                Mail::to($auditor->email)->send(new reschedule($emailData));
            }
        }
    }
    return redirect()->route('audit_plan.index')->with('msg', 'Audit Plan updated successfully.');
}


    // Delete Audit Plan
    public function delete(Request $request)
{
    $data = AuditPlan::find($request->id);

    if ($data) {
        // Hapus entri terkait di AuditPlanAuditor
        $auditPlanAuditors = AuditPlanAuditor::where('audit_plan_id', $data->id)->get();

        foreach ($auditPlanAuditors as $auditPlanAuditor) {
            // Hapus Observasi yang terkait dengan AuditPlanAuditor
            Observation::where('audit_plan_auditor_id', $auditPlanAuditor->id)->delete();
        }

        // Hapus AuditPlanAuditor
        AuditPlanAuditor::where('audit_plan_id', $data->id)->delete();

        // Hapus Observasi yang terkait dengan AuditPlan
        Observation::where('audit_plan_id', $data->id)->delete();

        // Hapus AuditPlan itu sendiri
        $data->delete();

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


    //Data Audit Plan
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
        ->where('id', $data->auditor_id)
        ->orderBy('name')
        ->get();

        $selectedCategory = AuditPlanCategory::where('audit_plan_auditor_id', $id)->pluck('standard_category_id')->toArray();
        $selectedCriteria = AuditPlanCriteria::where('audit_plan_auditor_id', $id)->pluck('standard_criteria_id')->toArray();

        return view("audit_plan.standard.create", compact("data", "category", "criteria", "auditor", "selectedCategory", "selectedCriteria"));
    }

    public function create_auditor_std(Request $request, $id)
    {
        $this->validate($request, [
            'auditor_id' => 'required|exists:users,id',
            'standard_category_id' => 'required|array',
            'standard_criteria_id' => 'required|array',
        ]);

        // Find the AuditPlanAuditor record by ID
        foreach ($request->standard_category_id as $categoryId) {
            AuditPlanCategory::create([
                'audit_plan_auditor_id' => $id,
                'standard_category_id' => $categoryId,
            ]);
        }

        // Create records for standard criteria
        foreach ($request->standard_criteria_id as $criteriaId) {
            AuditPlanCriteria::create([
                'audit_plan_auditor_id' => $id,
                'standard_criteria_id' => $criteriaId,
            ]);

        }
        return redirect()->route('audit_plan.standard', ['id' => $id])
        ->with('msg', 'Auditor data to determine each Standard was added successfully!');
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
        // Validate the request
        $this->validate($request, [
            'auditor_id' => 'required|exists:users,id',
            'standard_category_id' => 'required|array',
            'standard_criteria_id' => 'required|array',
        ]);

        // Update AuditPlanAuditor record by ID (assuming this is required, but not shown in the original code)
        $auditPlanAuditor = AuditPlanAuditor::findOrFail($id);
        $auditPlanAuditor->update([
            'auditor_id' => $request->auditor_id,
        ]);

        // Update or Create standard categories
        foreach ($request->standard_category_id as $categoryId) {
            AuditPlanCategory::updateOrCreate(
                ['audit_plan_auditor_id' => $id, 'standard_category_id' => $categoryId]
            );
        }

        // Delete categories that are no longer selected
        AuditPlanCategory::where('audit_plan_auditor_id', $id)
            ->whereNotIn('standard_category_id', $request->standard_category_id)
            ->delete();

        // Update or Create standard criteria
        foreach ($request->standard_criteria_id as $criteriaId) {
            AuditPlanCriteria::updateOrCreate(
                ['audit_plan_auditor_id' => $id, 'standard_criteria_id' => $criteriaId]
            );
        }

        // Delete criteria that are no longer selected
        AuditPlanCriteria::where('audit_plan_auditor_id', $id)
            ->whereNotIn('standard_criteria_id', $request->standard_criteria_id)
            ->delete();

        // Update the audit plan status
        $data = AuditPlan::findOrFail($id);
        $data->update([
            'audit_status_id' => '13',
        ]);
        // Redirect with a success message
        return redirect()->route('audit_plan.standard', ['id' => $id])
            ->with('msg', 'Auditor data to determine each Standard was updated successfully!');
    }

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
