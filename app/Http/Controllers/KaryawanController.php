<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;

class KaryawanController extends Controller
{
    public function user_dashboard()
    {
        $status_absen = Absensi::where('tanggal', date('Y-m-d'))->where('nik', Auth::user()->username)->first();
        return view('components.user.dashboard', compact('status_absen'));
    }

    public function get_absensi()
    {
        $data = Absensi::where('nik', Auth::user()->username)->get();
        foreach ($data as $d) {
            $d["tanggal"] = date('d F Y', strtotime($d->tanggal));
        }
        return response()->json($data);
    }

    public function submit_absensi(Request $request)
    {
        $image = $request->img;
        $image = str_replace('data:image/png;base64,', '', $image);
        $image = str_replace(' ', '+', $image);
        $imageName = Auth::user()->username . "-absen-" . time() . '.' . 'png';

        $path = public_path() . '/assets/absen/' . $imageName;
        File::put($path, base64_decode($image));
        $fotoAbsen = asset('assets/absen/' . $imageName);

        $jam_masuk = strtotime(Auth::user()->karyawan->divisi->jam_masuk);
        $jam_sekarang = strtotime(date("H:i"));
        $status = $jam_masuk - $jam_sekarang;

        if ($status >= 0) {
            $status = "absen";
        } elseif ($status < 0) {
            $status = "terlambat";
        }

        $catatan = "Absen pukul " . date('H:i', $jam_sekarang);

        Absensi::create([
            'tanggal' => date('Y-m-d'),
            'divisi_id' => Auth::user()->karyawan->divisi->id,
            'nik' => Auth::user()->username,
            'status' => $status,
            'catatan' => $catatan,
            'foto' => $fotoAbsen
        ]);

        $response = [
            "tanggal" => date('d F Y'),
            "catatan" => $catatan,
            "message" => "Berhasil melakukan absen !"
        ];

        return response()->json($response);
    }

    public function get_pengajuan()
    {
        if (Auth::user()->karyawan->divisi_id == null) {
            $response = [
                "response" => "failed",
                "message" => "Divisi anda belum ditentukan"
            ];
            return response()->json($response);
        } else {
            $pengajuan = Absensi::where('nik', Auth::user()->username)->where('status', 'cuti')->orWhere('status', 'izin')->get();
            $data = [];

            $tgl_sekarang = strtotime(date('Y-m-d'));
            $jam_masuk = strtotime(Auth::user()->karyawan->divisi->jam_masuk);
            $jam_sekarang = strtotime(date('H:i'));
            $jam = $jam_masuk - $jam_sekarang;

            foreach ($pengajuan as $p) {
                $tgl_pengajuan = strtotime($p->tanggal);

                if ($tgl_pengajuan == $tgl_sekarang) {
                    if ($jam >= 0) {
                        $action = true;
                    } elseif ($jam < 0) {
                        $action = false;
                    }
                } elseif ($tgl_pengajuan > $tgl_sekarang) {
                    $action = true;
                } elseif ($tgl_pengajuan < $tgl_sekarang) {
                    $action = false;
                }

                $data[] = [
                    "id" => $p->id,
                    "tanggal" => date('d F Y', strtotime($p->tanggal)),
                    "status" => $p->status,
                    "catatan" => $p->catatan,
                    "action" => $action
                ];
            }

            $response = [
                "response" => "success",
                "data" => $data
            ];
            return response()->json($response);
        }
    }

    public function add_pengajuan(Request $request)
    {
        Absensi::create([
            'tanggal' => $request->tanggal,
            'divisi_id' => Auth::user()->karyawan->divisi->id,
            'nik' => Auth::user()->username,
            'status' => $request->status,
            'catatan' => $request->catatan,
            'foto' => Auth::user()->karyawan->foto
        ]);

        return response()->json(["message" => "Berhasil membuat pengajuan"]);
    }

    public function delete_pengajuan(Request $request)
    {
        Absensi::where('id', $request->id)->delete();
        return response()->json(["message" => "Berhasil membatalkan pengajuan"]);
    }
}
