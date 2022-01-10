<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Karyawan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class WebController extends Controller
{
    public function index()
    {
        if (Auth::guest()) {
            return view('components.index');
        } else {
            if (Auth::user()->role == 'karyawan') {
                return redirect('user/dashboard');
            } elseif (Auth::user()->role == 'admin') {
                return redirect('admin/dashboard');
            }
        }
    }

    public function login_attempt(Request $request)
    {
        if (Auth::attempt(['username' => $request->username, 'password' => $request->password])) {
            if (Auth::user()->role == 'karyawan') {
                return redirect('user/dashboard');
            } elseif (Auth::user()->role == 'admin') {
                return redirect('admin/dashboard');
            }
        } else {
            Session::flash('failed');
            return redirect()->back()->withInput($request->all());
        }
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/');
    }

    public function change_password(Request $request)
    {
        $cekPass = Hash::check($request->oldPass, Auth::user()->password);

        if ($cekPass === true) {
            User::where('id', Auth::user()->id)->update([
                "password" => bcrypt($request->newPass)
            ]);
            return response()->json([
                "response" => "success",
                "message" => "Password anda berhasil dirubah"
            ]);
        } else {
            return response()->json([
                "response" => "failed",
                "message" => "Password lama anda salah !"
            ]);
        }
    }

    public function profile_update(Request $request)
    {
        $foto = $request->foto;
        if ($foto != null) {
            $extension = explode('/', explode(':', substr($foto, 0, strpos($foto, ';')))[1])[1];
            $replace = substr($foto, 0, strpos($foto, ',') + 1);
            $image = str_replace($replace, '', $foto);
            $image = str_replace(' ', '+', $image);
            $imageName = Auth::user()->username . "-foto-" . time() . '.' . $extension;

            $path = public_path() . '/assets/user-img/' . $imageName;
            File::put($path, base64_decode($image));
            $fotoUrl = asset('assets/user-img/' . $imageName);

            User::where('id', Auth::user()->id)->update([
                "name" => $request->nama
            ]);

            Karyawan::where('nik', Auth::user()->username)->update([
                "telepon" => $request->telepon,
                "foto" => $fotoUrl
            ]);

            return response()->json([
                "img" => $fotoUrl,
                "nama" => $request->nama,
                "telepon" => $request->telepon
            ]);
        } else {

            User::where('id', Auth::user()->id)->update([
                "name" => $request->nama
            ]);

            Karyawan::where('nik', Auth::user()->username)->update([
                "telepon" => $request->telepon
            ]);

            return response()->json([
                "img" => Auth::user()->karyawan->foto,
                "nama" => $request->nama,
                "telepon" => $request->telepon
            ]);
        }
    }
}
