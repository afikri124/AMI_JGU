<?php
namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;

class SettingController extends Controller
{
    public function change_password()
    {
        return view('settings.change-password');
    }

    public function update_password(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'current_password' => 'required',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        $user = Auth::user();

        // Check current password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Password saat ini salah.']);
        }

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return back()->with('success', 'Password berhasil diubah.');
    }

    // HoD AMI
    public function hod_ami(Request $request) {
        if ($request->isMethod('post')) {
            $this->validate($request, [
                'id'=> ['required'],
                'title'=> ['required'],
                'content'=> ['required'],
            ]);
            $up = Setting::find($request->id)->update(request()->all());
        }
        $data = Setting::get();
        return view('hod_ami.index', ['data'=> $data]);
    }
}
