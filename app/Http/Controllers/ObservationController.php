<?php

namespace App\Http\Controllers;

use App\Mail\CommentDocs;
use App\Mail\sendEmail;
use App\Models\AuditPlan;
use App\Models\AuditPlanAuditor;
use App\Models\AuditPlanCategory;
use App\Models\AuditPlanCriteria;
use App\Models\Department;
use App\Models\Indicator;
use App\Models\Location;
use App\Models\ObservationChecklist;
use Illuminate\Http\Request;
use App\Models\Observation;
use App\Models\ObservationCategory;
use App\Models\ObservationCriteria;
use App\Models\ReviewDocs;
use App\Models\StandardCategory;
use App\Models\StandardCriteria;
use App\Models\SubIndicator;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Yajra\DataTables\Facades\DataTables;

class ObservationController extends Controller
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

        return view('observations.index', compact('data', 'auditee'));
    }

    public function create(Request $request, $id)
    {
        $locations = Location::orderBy('title')->get();
        $category = StandardCategory::orderBy('description')->get();
        $criteria = StandardCriteria::orderBy('title')->get();
        $data = AuditPlan::findOrFail($id);
        // Ambil auditor_id dari pengguna yang sedang login
        $auditorId = Auth::user()->id; // Ganti ini sesuai dengan cara mendapatkan auditor_id
        // Tarik data sesuai dengan auditor yang sedang login
        $auditorData = AuditPlanAuditor::where('auditor_id', $auditorId)->firstOrFail();

        // Ambil auditor sesuai dengan auditor_id dari pengguna yang sedang login
        $auditor = User::with(['roles' => function ($query) {
                $query->select('id', 'name');
            }])
            ->whereHas('roles', function ($q) {
                $q->where('name', 'auditor');
            })
            ->where('id', $auditorId) // Menggunakan auditor_id yang tepat
            ->orderBy('name')
            ->get();

        $department = Department::where('id', $data->department_id)->orderBy('name')->get();

        return view('observations.make', compact('auditorData', 'auditor', 'data', 'locations', 'department', 'category', 'criteria'));
    }

    public function make(Request $request, $id)
    {
        if ($request->isMethod('POST')) {
            $this->validate($request, [
                'audit_plan_id' => ['required'],
                'audit_plan_auditor_id' => ['required'],
                'location_id' => ['required'],
                'remark_plan' => ['required'],
                'audit_plan_category_id' => ['required', 'array'],
                'audit_plan_criteria_id' => ['required', 'array'],
                'sub_indicator_id' => ['required', 'array'],
                'remark_description' => ['required', 'array'],
                'obs_checklist_option' => ['required', 'array'],
                'remark_success_failed' => ['required', 'array'],
                'remark_recommend' => ['required', 'array'],
                'remark_upgrade_repair' => ['required', 'array'],
                'person_in_charge' => ['required', 'array'],
            ]);

            // Create Observation
            $observation = Observation::create([
                'audit_plan_id' => $request->audit_plan_id,
                'audit_plan_auditor_id' => $request->audit_plan_auditor_id,
                'location_id' => $request->location_id,
                'remark_plan' => $request->remark_plan,
            ]);

            // Create Observation Categories and Criteria
            foreach ($request->audit_plan_category_id as $index => $categoryId) {
                $observationCategory = ObservationCategory::create([
                    'observation_id' => $observation->id,
                    'audit_plan_category_id' => $categoryId,
                    'audit_plan_criteria_id' => $request->audit_plan_criteria_id[$index],
                ]);

                ObservationCriteria::create([
                    'observation_id' => $observation->id,
                    'observation_category_id' => $observationCategory->id,
                ]);
            }

            // Create Observation Checklists
            foreach ($request->sub_indicator_id as $index => $subIndicatorId) {
                ObservationChecklist::create([
                    'observation_id' => $observation->id,
                    'sub_indicator_id' => $subIndicatorId,
                    'remark_description' => $request->remark_description[$index],
                    'obs_checklist_option' => $request->obs_checklist_option[$index],
                    'remark_success_failed' => $request->remark_success_failed[$index],
                    'remark_recommend' => $request->remark_recommend[$index],
                    'remark_upgrade_repair' => $request->remark_upgrade_repair[$index],
                    'person_in_charge' => $request->person_in_charge[$index],
                ]);
            }

            if ($observation) {
                return redirect()->route('observations.index')->with('msg', 'Observasi berhasil di laksanakan!!');
            }
        }
        return back()->withErrors(['msg' => 'Terjadi kesalahan saat menambahkan data.'])->withInput();
    }

    public function edit($id)
    {
        $data = AuditPlan::findOrFail($id);
        $data->doc_path;
        $data->link;
        return view('observations.edit', compact('data'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'remark_docs'    => '',
        ]);

        $data = AuditPlan::findOrFail($id);
        $data->update([
            'remark_docs' => $request->remark_docs,
            'audit_status_id' => '3',
        ]);

        // if ($data) {
        //     // Cari pengguna dan departemen berdasarkan ID yang ada dalam request
        //     $auditee = User::find($request->auditee_id);
        //     $department = Department::find($request->department_id);

        //     if ($auditee) {
        //         // Data untuk email
        //         $emailData = [
        //             'auditee_id'    => $auditee->name,
        //             'remark_docs'   => $request->remark_docs,
        //             'date_start'    => $request->date_start,
        //             'date_end'      => $request->date_end,
        //             'department_id' => $department ? $department->name : null,
        //         ];

        //         // Kirim email ke pengguna yang ditemukan
        //         Mail::to($auditee->email)->send(new CommentDocs($emailData));

        //         // Redirect dengan pesan sukses
        //         return redirect()->route('observations.index')->with('msg', 'Document telah di Review, Siap untuk Audit Lapangan');
        //     } else {
        //         // Redirect dengan pesan error jika pengguna tidak ditemukan
        //         return redirect()->route('observations.index')->with('msg', 'Pengguna tidak ditemukan');
        //     }
        // } else {
        //     // Redirect dengan pesan error jika data tidak berhasil diupdate
        //     return redirect()->route('observations.index')->with('msg', 'Data gagal diupdate');
        // }
        return redirect()->route('observations.index')->with('msg', 'Document telah di Review, Siap untuk Audit Lapangan');
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
                $query->select('id', 'name');
            },
            'category' => function ($query) {
                $query->select('id', 'description');
            },
            'departments' => function ($query) {
                $query->select('id', 'name');
            },
        ])->leftJoin('locations', 'locations.id', '=', 'location_id')
            ->select(
                'audit_plans.*',
                'locations.title as location'
            )
            // ->where('auditor_id', Auth::user()->id)
            ->orderBy("id");
        return DataTables::of($data)
            ->filter(function ($instance) use ($request) {
                //jika pengguna memfilter berdasarkan roles
                if (!empty($request->get('select_auditee'))) {
                    $instance->whereHas('auditee', function ($q) use ($request) {
                        $q->where('auditee_id', $request->get('select_auditee'));
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
}
