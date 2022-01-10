<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use App\Models\Divisi;
use App\Models\Karyawan;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    function random($type, $length)
    {
        $result = "";
        if ($type == 'char') {
            $char = 'ABCDEFGHJKLMNPRTUVWXYZ';
            $max        = strlen($char) - 1;
            for ($i = 0; $i < $length; $i++) {
                $rand = mt_rand(0, $max);
                $result .= $char[$rand];
            }
            return $result;
        } elseif ($type == 'num') {
            $char = '123456789';
            $max        = strlen($char) - 1;
            for ($i = 0; $i < $length; $i++) {
                $rand = mt_rand(0, $max);
                $result .= $char[$rand];
            }
            return $result;
        } elseif ($type == 'mix') {
            $char = 'ABCDEFGHJKLMNPRTUVWXYZ123456789';
            $max = strlen($char) - 1;
            for ($i = 0; $i < $length; $i++) {
                $rand = mt_rand(0, $max);
                $result .= $char[$rand];
            }
            return $result;
        }
    }

    public function dashboard()
    {
        $karyawan = Karyawan::all();
        $divisi = Divisi::all();

        $izin = Absensi::where('tanggal', date('Y-m-d'))->where('status', 'izin')->get();
        $cuti = Absensi::where('tanggal', date('Y-m-d'))->where('status', 'cuti')->get();
        return view('components.admin.dashboard', compact('karyawan', 'divisi', 'izin', 'cuti'));
    }

    public function get_divisi()
    {
        $data = Divisi::all();
        $response = [
            "error" => false,
            "data" => $data
        ];

        return response()->json($response);
    }

    public function add_divisi(Request $request)
    {
        $id = Divisi::max('id');
        $id = $id + 1;
        Divisi::create([
            'id' => $id,
            'nama' => $request->nama,
            'jam_masuk' => $request->jam_masuk,
            'jam_keluar' => $request->jam_keluar
        ]);

        $response = [
            "error" => false,
            "message" => "Berhasil menambahkan divisi"
        ];

        return response()->json($response);
    }

    public function update_divisi(Request $request)
    {
        Divisi::where('id', $request->id)->update([
            'nama' => $request->nama,
            'jam_masuk' => $request->jam_masuk,
            'jam_keluar' => $request->jam_keluar
        ]);

        $response = [
            "error" => false,
            "message" => "Berhasil merubah divisi"
        ];

        return response()->json($response);
    }

    public function delete_divisi(Request $request)
    {
        Divisi::where('id', $request->id)->delete();
        Karyawan::where('divisi_id', $request->id)->update([
            "divisi_id" => null
        ]);
        Absensi::where('divisi_id', $request->id)->update([
            "divisi_id" => null
        ]);

        $response = [
            "error" => false,
            "message" => "Berhasil menghapus divisi"
        ];

        return response()->json($response);
    }

    public function karyawan()
    {
        $divisi = Divisi::all();
        return view('components.admin.karyawan', compact('divisi'));
    }

    public function get_karyawan()
    {
        $karyawan = Karyawan::all();
        $data = [];

        foreach ($karyawan as $k) {
            if ($k->divisi_id == null) {
                $divisi = [
                    "id" => null,
                    "nama" => "Tidak ada divisi"
                ];
            } else {
                $divisi = [
                    "id" => $k->divisi_id,
                    "nama" => $k->divisi->nama
                ];
            }

            $data[] = [
                "id" => $k->user_id,
                "foto" => $k->foto,
                "nik" => $k->nik,
                "nama" => $k->user->name,
                "telepon" => $k->telepon,
                "divisi" => $divisi
            ];
        }

        return response()->json($data);
    }

    public function add_karyawan(Request $request)
    {
        $cekNik = User::where('username', $request->nik)->first();
        if ($cekNik) {
            $response = [
                "response" => "failed",
                "message" => "NIK" . $request->nik . " telah terdaftar !"
            ];
            return response()->json($response);
        } else {
            $userid = $this->random('num', 6);
            while (true) {
                $cek = User::where('id', $userid)->first();
                if ($cek) {
                    $userid = $this->random('num', 6);
                } else {
                    break;
                }
            }

            User::create([
                'id' => $userid,
                'name' => $request->nama,
                'username' => $request->nik,
                'password' => bcrypt('12345'),
                'role' => 'karyawan'
            ]);

            Karyawan::create([
                'nik' => $request->nik,
                'user_id' => $userid,
                'divisi_id' => $request->divisi,
                'telepon' => $request->telepon,
                'foto' => asset('assets/user-img/no-picture.png')
            ]);

            $response = [
                "response" => "success",
                "message" => "Karyawan berhasil ditambahkan"
            ];
            return response()->json($response);
        }
    }

    public function update_karyawan(Request $request)
    {
        User::where('id', $request->id)->update([
            "name" => $request->nama,
        ]);

        Karyawan::where('user_id', $request->id)->update([
            "divisi_id" => $request->divisi,
            "telepon" => $request->telepon
        ]);

        Absensi::where('nik', $request->nik)->update([
            "divisi_id" => $request->divisi
        ]);

        $response = [
            "response" => "success",
            "message" => "Karyawan " . $request->nik . " berhasil di edit"
        ];
        return response()->json($response);
    }

    public function delete_karyawan(Request $request)
    {
        User::where('id', $request->id)->delete();
        Karyawan::where('user_id', $request->id)->delete();
        Absensi::where('nik', $request->nik)->delete();

        $response = [
            "error" => false,
            "message" => "Berhasil menghapus karyawan"
        ];

        return response()->json($response);
    }

    public function absensi()
    {
        $divisi = Divisi::all();
        return view('components.admin.absensi', compact('divisi'));
    }

    public function get_absensi(Request $request)
    {
        if ($request->divisi == "all") {
            $karyawan = Karyawan::all();
        } else {
            $karyawan = Karyawan::where('divisi_id', $request->divisi)->get();
        }

        $data = [];
        foreach ($karyawan as $k) {
            $absensi = Absensi::where('tanggal', $request->tanggal)->where('nik', $k->nik)->first();

            if ($k->divisi_id == null) {
                $divisi = "Tidak ada divisi";
                $jam_masuk = "-";
            } else {
                $divisi = $k->divisi->nama;
                $jam_masuk = $k->divisi->jam_masuk;
            }

            if ($absensi) {
                $data[] = [
                    "absen" => true,
                    "foto" => $absensi->foto,
                    "nik" => $k->nik,
                    "nama" => $k->user->name,
                    "divisi" => $divisi,
                    "jam_masuk" => $jam_masuk,
                    "status" => $absensi->status,
                    "catatan" => $absensi->catatan
                ];
            } else {
                $data[] = [
                    "absen" => false,
                    "foto" => asset('assets/user-img/no-picture.png'),
                    "nik" => $k->nik,
                    "nama" => $k->user->name,
                    "divisi" => $divisi,
                    "jam_masuk" => $jam_masuk,
                    "status" => null,
                    "catatan" => null
                ];
            }
        }

        return response()->json($data);
    }
}
