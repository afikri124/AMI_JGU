<?php

namespace App\Http\Controllers;

use App\Models\NotificationAudit;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;
use Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;

class NotificationAuditController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function __construct() {
        $this->middleware('auth');
    }
    public function index(Request $request)
    {

        if ($request->isMethod('POST')) {
            $this->validate($request, [
                'title' => ['string', 'max:255'],
                'date' => ['required','date'],
                'file_path' => ['required','mimes:jpg,jpeg,png','max:5120'], // max 5MB
                'description' => 'required',
            ]);
            $fileName = "";
            if(isset($request->file_path)){
                $ext = $request->file_path->extension();
                $name = str_replace(' ', '_', $request->file_path->getClientOriginalName());
                $fileName = FacadesAuth::user()->id.'_'.$name;
                $folderName =  "FILE/".Carbon::now()->format('Y/m');
                $path = public_path()."/".$folderName;
                if (!File::exists($path)) {
                    File::makeDirectory($path, 0755, true); //create folder
                }
                $upload = $request->file_path->move($path, $fileName); //upload image to folder
                if($upload){
                    $fileName=$folderName."/".$fileName;
                } else {
                    $fileName = "";
                }
            }
            $date = Carbon::parse($request->date)->format('Y-m-d');
            $data = NotificationAudit::create([
                'title' => $request->title,
                'date' => $date,
                'file_path' => $fileName,
                'description' => $request->description,
            ]);
            if($data){
                return redirect()->route('notification.index')->with('msg','Data atas ('.$request->title.') BERHASIL ditambahkan!');
            }else{
                return redirect()->route('notification.index')->with('msg',' Pengmuman GAGAL dibuat!');
            }
        }else{
            $data = "";
            $notification_audits = NotificationAudit::all('*');
            return view('notification.index', compact('data','notification_audits'));
        }
    }


    public function data(Request $request){
        $data = NotificationAudit::select('*')->orderBy("id");
            return DataTables::of($data)
                    ->filter(function ($instance) use ($request) {
                        if (!empty($request->get('search'))) {
                            $search = $request->get('search');
                            $instance->where('title', 'LIKE', "%$search%");
                        }
                    })->make(true);
    }

    public function datatables()
    {
        $notification_audits = NotificationAudit::select('*');
        return DataTables::of($notification_audits)->make(true);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $this->authorize('notification.update');
        $notification_audits = NotificationAudit::findOrFail($id);
        return view('notification.edit', compact('notification_audits'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update($id, Request $request)
    {

        $request->validate([
            'title' => 'required',
            'date' => ['date','required'],
            'file_path' => ['required','mimes:jpg,jpeg,png','max:5120'], // max 5MB
            'description' => 'required',
        ]);
        // dd($request);
        $notification_audits = NotificationAudit::findOrFail($id);
        $fileName = $notification_audits->file_path;
        if(isset($request->file_path)){
            $name = str_replace(' ', '_', $request->file_path->getClientOriginalName());
            $fileName = FacadesAuth::user()->id.'_'.$name;
            $folderName =  "FILE/".Carbon::now()->format('Y/m');
            $path = public_path()."/".$folderName;
            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true); //create folder
            }
            $upload = $request->file_path->move($path, $fileName); //upload image to folder
            if($upload){
                $fileName=$folderName."/".$fileName;
                if($notification_audits->file_path != null){
                    File::delete(public_path()."/".$notification_audits->file_path);
                }
            } else {
                $fileName = $notification_audits->file_path;
            }
        }
        $d = $notification_audits->update([
            'title' => $request->title,
            'date' => $request->date,
            'file_path' => $fileName,
            'description' => $request->description,
        ]);
        if($d){
            return redirect()->route('notification.edit',['id' => ($notification_audits->id)])
            ->with('msg','Announcements berhasil diubah!');
        }else{
            return redirect()->route('notification.edit',['id' => ($notification_audits->id)])
            ->with('msg','Announcements gagal diubah!');
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request){
        $this->authorize('notification.delete');
        $data = NotificationAudit::find($request->id);
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
}
