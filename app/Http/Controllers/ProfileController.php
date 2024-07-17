<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Validator;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\View\View;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Validator as FacadesValidator;
use Spatie\Permission\Contracts\Role;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    // Menampilkan halaman profil pengguna
    public function index()
    {
        $user = FacadesAuth::user();
        $departments = Department::orderBy('name')->get();
        return view('profile.index', compact('user', 'departments'));
    }
    
    protected function update_profile(Request $request)
    {
        $this->validate($request, [
            'name' => ['required', 'string', 'max:255'],
            'username' => ['nullable', 'string', 'max:255', Rule::unique('users')->ignore(FacadesAuth::user()->id, 'id')],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore(FacadesAuth::user()->id, 'id')],
            'no_phone' => ['nullable', 'string', 'max:15', Rule::unique('users')->ignore(FacadesAuth::user()->id, 'id')],
            'gender' => ['nullable'],
            'department_id' => ['nullable', 'exists:departments,id'],
            'image' => ['mimes:jpg,jpeg,png','max:5120'],
        ]);

        $fileName = "";
        if ($request->hasFile('image')) {
            $ext = $request->image->extension();
            $name = str_replace(' ', '_', $request->image->getClientOriginalName());
            $fileName = FacadesAuth::user()->id . '_' . $name;
            $folderName = "storage/FILE/profile/" . Carbon::now()->format('Y/m');
            $path = public_path() . "/" . $folderName;
            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true); // create folder
            }
            $upload = $request->image->move($path, $fileName); // upload file to folder
            if ($upload) {
                $fileName = $folderName . "/" . $fileName;
            } else {
                $fileName = "";
            }
        }
    
        User::where('id', FacadesAuth::user()->id)->update([
            'name' => $request->name,
            'username' => $request->username,
            'email' => $request->email,
            'no_phone' => $request->no_phone,
            'gender' => $request->gender,
            'department_id' => $request->department_id,
            'nidn' => $request->nidn,
            'front_title' => $request->front_title,
            'back_title' => $request->back_title,
            'job' => $request->job,
            'updated_at' => Carbon::now(),
            'image' => $request->image,
        ]);
    
        return redirect()->route('profile.index')->with('success', 'Profile updated successfully.');
    }

    public function updateImage(Request $request)
    {
        $this->validate($request, [
            'image' => ['required', 'mimes:jpg,jpeg,png', 'max:5120'], // max 5MB
        ]);

        $fileName = "";
        if ($request->hasFile('image')) {
            $ext = $request->image->extension();
            $name = str_replace(' ', '_', $request->image->getClientOriginalName());
            $fileName = FacadesAuth::user()->id . '_' . $name;
            $folderName = "storage/FILE/profile/" . Carbon::now()->format('Y/m');
            $path = public_path() . "/" . $folderName;
            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true); // create folder
            }
            $upload = $request->image->move($path, $fileName); // upload file to folder
            if ($upload) {
                $fileName = $folderName . "/" . $fileName;
            } else {
                $fileName = "";
            }
        }

        User::where('id', FacadesAuth::user()->id)->update([
            'image' => $fileName,
            'updated_at' => Carbon::now(),
        ]);

        return redirect()->route('profile.index')->with('success', 'Image updated successfully.');
    }

}
