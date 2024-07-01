<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Jabatan;
use App\Models\Mahasiswas;
use App\Models\Peminjaman;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class PeminjamanUmumController extends Controller
{
    public function index()
    {
        $jabatan = Jabatan::latest()->get();
        $prodi = Prodi::latest()->get();

        $peminjamanDeadline = Peminjaman::where('id_user', auth()->user()->id_user)
            ->whereNull('tgl_pengembalian')->where('batas_pengembalian', '<=', Carbon::now()->addDays(2)->toDateString())
            ->where('status', 1)->whereNull('tgl_pengembalian')
            ->get();

        return in_array(Auth::user()->role, ['3', '5']) ?
            view("umum.peminjaman.index")->with(['jabatans' => $jabatan, 'peminjaman' => $peminjamanDeadline]) :
            (
                Auth::user()->role == '4' ? view("umum.peminjaman.index")->with(['prodis' => $prodi, 'peminjaman' => $peminjamanDeadline]) : view("umum.peminjaman.index")
            );
    }

    public function store(Request $request)
    {
        $request->validate([
            'nim' => 'required',
        ]);
        return response()->json([
            'status' => 200,
            'message' => 'Berhasil Melakukan Peminjaman',
            'data' => $request->nim
        ]);
    }

    public function lengkapi(Request $request)
    {
        if (in_array(auth()->user()->role, ['3', '5'])) {
            $request->validate([
                'nip' => 'required|numeric|digits:18|unique:dosen,nip',
                'nama' => 'required',
                'jabatan' => 'required|exists:jabatans,id',
                'no_hp' => 'required|numeric|unique:dosen,phone_number'
            ]);

            $data = [
                'name' => $request->nama,
                'nip' => $request->nip,
                'jabatan_id' => $request->jabatan,
                'phone_number' => $request->no_hp,
                'email' => auth()->user()->email
            ];
            if (Dosen::create($data)) {
                $idDosen = Dosen::latest()->first();
                User::find(auth()->user()->id_user)->update([
                    'dosen_id' => $idDosen->id_dosen
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berhasil Melengkapi Data!'
                ]);
            }
        }

        if (auth()->user()->role == '4') {
            $request->validate([
                'nama' => 'required',
                'nim' => 'required|numeric|digits:10|unique:mahasiswa,nim',
                'prodi' => 'required|exists:prodis,code_prodi',
                'angkatan' => "required|numeric|min:2000|max:" . date('Y'),
                'ipk' => 'required|numeric|min:0|max:4',
            ]);

            $data = [
                "nama" => $request->nama,
                "nim" => $request->nim,
                "code_prodi" => $request->prodi,
                "angkatan" => $request->angkatan,
                "ipk" => $request->ipk,
            ];

            if (Mahasiswas::create($data)) {
                $idMahasiswa = Mahasiswas::latest()->first();
                User::find(auth()->user()->id_user)->update([
                    'mahasiswa_id' => $idMahasiswa->id_mahasiswa
                ]);
                return response()->json([
                    'status' => 200,
                    'message' => 'Berhasil Melengkapi Data!'
                ]);
            }
        }
    }
}