<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Department;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\File;
use Carbon\Carbon;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    // Menampilkan halaman profil pengguna
    public function index(): View
    {
        $user = Auth::user();
        $departments = Department::orderBy('name')->get();
        return view('profile.index');
    }
    
    public function edit(Request $request)
{
    $user = Auth::user();
    $departments = Department::orderBy('name')->get();

    $this->validate($request, [
        'name' => ['required', 'string', 'max:255'],
        'username' => ['nullable', 'string', 'max:255', Rule::unique('users')->ignore($user->id)],
        'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
        'no_phone' => ['nullable', 'string', 'max:15', Rule::unique('users')->ignore($user->id)],
        'gender' => ['nullable'],
        'department_id' => ['nullable', 'exists:departments,id'],
        'image' => ['mimes:jpg,jpeg,png','max:5120'],
    ]);

    $fileName = "";
    if ($request->hasFile('image')) {
        $ext = $request->image->extension();
        $name = str_replace(' ', '_', $request->image->getClientOriginalName());
        $fileName = $user->id . '_' . $name;
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

    User::where('id', $user->id)->update([
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
        'image' => $fileName,
    ]);

    return redirect()->route('profile.edit')->with('msg', 'Profil telah diperbarui!');
}

public function showEditForm()
{
    $user = Auth::user();
    $departments = Department::orderBy('name')->get();

    return view('profile.edit', compact('user', 'departments'));
}

}

