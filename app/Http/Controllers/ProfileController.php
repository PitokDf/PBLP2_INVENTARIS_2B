<?php

namespace App\Http\Controllers;

use App\Models\Dosen;
use App\Models\Jabatan;
use App\Models\Mahasiswas;
use App\Models\Prodi;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProfileController extends Controller
{
    public function index()
    {
        $prodi = Prodi::latest()->get();
        $jabatan = Jabatan::latest()->get();
        return view('umum.profile')->with(['prodis' => $prodi, 'jabatans' => $jabatan]);
    }

    public function editAkun(Request $request)
    {
        // mencek kalau file_image null dan password null maka akan langsung return
        if (!$request->hasFile('file_image') && !$request->filled('password')) {
            return response()->json([
                'status' => 204,
                'message' => 'Nothing to update.'
            ]);
        }

        $user = User::find(auth()->user()->id_user); // mencari user berdasarkan id user yang login
        $rules = []; // membuat variabel rules yang akan menampung rules-rules nantinya
        $data = []; // membuat vairabel data yang menampung 
        $fileName = null;
        $file = null;
        $cek = false;

        if ($request->hasFile('file_image')) {
            $rules['file_image'] = 'image|mimes:jpeg,png,jpg|max:2048';
            $file = $request->file('file_image');
            $fileName = uniqid() . '_' . time() . '_' . now()->timestamp . '.' . $file->getClientOriginalExtension();
            $data['avatar'] = $fileName;
            $cek = true;
        }

        if (!empty($request->password)) {
            $rules['password'] = 'min:8|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[!@#$%]/'; // validasi untuk password dengan validasi minimal 8 karakter 
            $data['password'] = bcrypt($request->password); // memasukkan key password 
        }

        $message = [
            'password.regex' => 'password harus terdiri dari huruf besar, kecil, angka dan karakter !@#$%'
        ];

        // memvalidasi inputan sesuai validasi yang sudah disimpan di variable $rules
        $request->validate($rules, $message);

        // menghapus file gambar sebelumnya jika ada
        if ($user->avatar && $cek) {
            Storage::delete('public/avatar/' . $user->avatar);
        }

        // menyimpan file gambar ke folder storage
        $file !== null ? $file->storeAs('public/avatar/', $fileName) : '';
        // mengupdate data user
        $user->update($data);
        return response()->json([
            'status' => 200,
            'message' => 'berhasil merubah informasi akun.'
        ]);
    }

    public function editProfile(Request $request)
    {
        // menjalankan kode didalamnya jika role 4 atau mahasiswa
        if (auth()->user()->role == '4') {
            $mahasiswa = auth()->user()->mahasiswa;
            $cekMahasisChanges =
                $mahasiswa->nama === $request->namaM &&
                $mahasiswa->code_prodi === $request->prodi &&
                $mahasiswa->angkatan == $request->angkatan; // akan bernilai true jika nama dan code prodi sama dengan sebelumnya

            // ngereturn response json dengan message tidak ada yang diupdate
            if ($cekMahasisChanges) { // $cekMahasiswaChanges akan bernalai true atau false
                return response()->json(['status' => 204, 'message' => 'Nothing to update']);
            }

            $rules = [
                'namaM' => 'required|regex:/^[a-zA-Z\s]+$/', // mengizinkan nama hanya huruf besar kecil dan spasi
                'prodi' => 'required|exists:prodis,code_prodi', // memastikan code prodi yang dipilih ada pada table prodi
                'angkatan' => 'required|integer|max:' . (date('Y') - 1) // memastikan angkatan tidak lebih dari tahun sekarang  dikurang 1 untuk menghindari kekeliruan data
            ];

            $messagesIDN = [
                'namaM.regex' => 'Nama hanya boleh huruf besar dan kecil',
                'prodi.exists' => 'Code prodi tidak tersedia',
                'angkatan.max' => 'tahun angkatan yang dipilih tidak valid'
            ];

            $request->validate($rules, $messagesIDN); // akan ngereturn error jika ada validasi yang tidak sesuai

            Mahasiswas::find($mahasiswa->id_mahasiswa)->update([
                'nama' => $request->namaM ?? $mahasiswa->nama,
                'code_prodi' => $request->prodi ?? $mahasiswa->prodi,
                'angkatan' => $request->angkatan ?? $mahasiswa->angkatan
            ]);

        }

        // menjalankan kode didalamnya jika role 3 atau 5 dosen atau staf
        if (in_array(auth()->user()->role, ['3', '5'])) {
            $dosen = auth()->user()->dosen;

            $cekDosenChanges = $request->namaD === $dosen->name &&
                $request->jabatan == $dosen->jabatan->id &&
                $request->phone_number == $dosen->phone_number;

            if ($cekDosenChanges) {
                return response()->json(['status' => 204, 'message' => 'Nothing to update']);
            }

            $rules = [
                'namaD' => 'regex:/^[a-zA-Z\s]+$/',
                'jabatan' => 'exists:jabatans,id',
                'phone_number' => Rule::unique('dosen')->ignore($dosen)
            ];

            $messagesIDN = [
                'namaD.regex' => 'Nama harus terdiri dari huruf besar dan kecil.',
                'jabatan.exists' => 'Jabatan tidak tersedia.',
                'phone_number.unique' => 'No telepon sudah terdaftar.',
            ];

            $request->validate($rules, $messagesIDN);

            Dosen::find($dosen->id_dosen)->update([
                'name' => $request->namaD ?? $dosen->name,
                'jabatan_id' => $request->jabatan ?? $dosen->jabatan_id,
                'phone_number' => $request->phone_number ?? $dosen->phone_number
            ]);
        }

        return response()->json(['status' => 200, 'message' => 'Berhasil mengupdate info profile, halaman akan di refresh dalam 2 detik']);

    }
}