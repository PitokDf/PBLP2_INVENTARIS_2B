<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreDosenRequest;
use App\Http\Requests\UpdateDosenRequest;
use App\Models\ActivityLog;
use App\Models\Dosen;
use App\Models\Jabatan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class DosenController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $jabatan = Jabatan::all();
        return view("admin.dosen.index")->with('jabatans', $jabatan);
    }

    public function getDosenNip()
    {
        $dosen = Dosen::whereDoesntHave('user')->with('jabatan')->get();
        return response()->json([
            'status' => 200,
            'data' => $dosen
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    public function getData()
    {
        $data = Dosen::with('jabatan')->latest()->get();
        return response()->json([
            "status" => 200,
            "data" => $data
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|regex:/^[a-zA-Z,.\s]+$/u', // rule name harus diisi dan nama harus "huruf besar atau kecil dan spasi"
            'nip' => 'required|numeric|digits:18|unique:dosen,nip', // rule untuk nip wajib diisi, type harus number, terdiri dari 18 digits, dan nip unique dari tabel dosen
            'jabatan' => 'required|exists:jabatans,id', // rule untuk jabatan wajib diisi, dan jabatan harus ada di tabel jabatan
            'no_telpn' => 'required|regex:/^08[0-9]{9,}$/|unique:dosen,phone_number', // rule untuk nomor telepon wajin diisi, nomor telepon harus diawali dengan '08', nomor telepon unique di tabel dosen
            'email' => 'required|email|unique:dosen,email', // rule untuk email wajib diisi, email harus bertype email, email unique pada table dosen
            'dir_foto' => 'nullable|image|mimes:jpeg,png,jpeg|max:124' // rule untuk foto wajib diisi, file harus bertype gambar, ekstensi gambar yang diizinkan 'jpg, png, dan jpeg', ukuran maksimal gambar '2MB'
        ];

        $request->validate($rules, $this->messageIDN()); // melakukan validasi pada rules yang sudah ditentukan

        $file = $request->file('dir_foto'); // membuat inisialisasi dari method file
        $fileName = now() . '_' . uniqid() . '.' . $file->getClientOriginalExtension(); // membuat nama file yang akan disimpan

        $data = [ // membuat variable data yang menampung field yang akan dicreate
            "name" => $request->name,
            "nip" => $request->nip,
            "jabatan_id" => $request->jabatan,
            "phone_number" => $request->no_telpn,
            "email" => $request->email,
            "photo_dir" => 'asset/dosen/' . $fileName
        ];

        if (Dosen::create($data)) { // melakukan pengecekan apakah data dosen dicreate
            $file->move(public_path('asset/dosen/'), $fileName); // menyimpan file gambar jika data dosen berhasil dicreate
            ActivityLog::createLog('add', 'menambahkan data dosen');
        }

        return response()->json([ // mereturn response json jika semua proses berjalan semestinya
            'status' => 200,
            'message' => 'Berhasil menambahkan data dosen.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Dosen $dosen)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = Dosen::with("jabatan")->where("id_dosen", $id)->first();
        return response()->json([
            'status' => 200,
            'data' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     */

    public function update(Request $request, string $id)
    {
        $dosen = Dosen::where('id_dosen', $id)->first(); // mencari data dosen berdasarkan id yang didapat dari request
        $rules = [
            'name' => 'required|regex:/^[a-zA-Z,.\s]+$/u', // rule name harus diisi dan nama harus "huruf besar atau kecil dan spasi"
            'nip' => 'required|numeric|digits:18|' . Rule::unique('dosen')->ignore($dosen), // rule untuk nip wajib diisi, type harus number, terdiri dari 18 digits, dan nip unique dari tabel dosen mengabaikan data yang sedang diedit
            'jabatan' => 'required|exists:jabatans,id', // rule untuk jabatan wajib diisi, dan jabatan harus ada di tabel jabatan
            'phone_number' => 'required|regex:/^08[0-9]{9,}$/|' . Rule::unique('dosen')->ignore($dosen), // rule untuk nomor telepon wajin diisi, nomor telepon harus diawali dengan '08', nomor telepon unique dan mengabaikan data yang sedang diedit
            'email' => 'required|email|' . Rule::unique('dosen')->ignore($dosen), // rule untuk email wajib diisi, email harus bertype email, email unique pada table dosen mengabaikan data yang sedang diedit
            'dir_foto' => 'nullable|image|mimes:jpeg,png,jpeg|max:124' // rule untuk foto boleh tidak diisi, file harus bertype gambar, ekstensi gambar yang diizinkan 'jpg, png, dan jpeg', ukuran maksimal gambar '124 Kb'
        ];

        $request->validate($rules, $this->messageIDN()); // melakukan validasi pada rules yang sudah dibuat

        $data = [ // membuat variable data yang menampung field yang akan dicreate
            "name" => $request->name,
            "nip" => $request->nip,
            "jabatan_id" => $request->jabatan,
            "phone_number" => $request->phone_number,
            "email" => $request->email
        ];

        $file = null;
        $fileName = null;

        if ($request->hasFile('dir_foto')) { // mengecek apakah terdapat request yang menyeryakan file
            $file = $request->file('dir_foto'); // membuat inisialisasi dari method file
            $fileName = now() . '_' . uniqid() . '.' . $file->getClientOriginalExtension(); // membuat nama file yang akan disimpan
            $data["photo_dir"] = 'asset/dosen/' . $fileName;
        }

        $file ? (File::exists($dosen->photo_dir) ? File::delete($dosen->photo_dir) : '') : ''; // melakukan pengecekan apakah variable "$file" tidak null, dan menghapus file gambar di local jika ada

        if ($dosen->update($data)) { // melakukan pengecekan apakah data dosen berhasil diupdate
            $file ? $file->move(public_path('asset/dosen/'), $fileName) : ''; // menyimpan file gambar ke folder public/asset/dosen
            ActivityLog::createLog('update', 'mengupdate data dosen');
        }

        return response()->json([ // mereturn response json jika semua proses berjalan semestinya
            'status' => 200,
            'message' => 'Berhasil mengupdate data dosen.'
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $dosen = Dosen::findOrFail($id);

        if (!$dosen) {
            return response()->json([
                'status' => 404,
                'message' => 'Data not found'
            ]);
        }
        if (File::exists($dosen->photo_dir)) {
            File::delete($dosen->photo_dir);
        }
        $dosen->delete();
        ActivityLog::createLog('delete', 'menghapus data dosen');

        return response()->json([
            'status' => 200,
            'message' => 'Berhasil Menghapus data dosen.'
        ]);
    }

    public function messageIDN(): array
    {
        return [
            'name.required' => 'Nama wajib diisi.',
            'name.regex' => 'Nama hanya boleh terdiri dari huruf dan spasi.',
            'nip.required' => 'NIP wajib diisi.',
            'nip.numeric' => 'NIP harus berupa angka.',
            'nip.digits' => 'NIP harus terdiri dari 18 digit.',
            'nip.unique' => 'NIP sudah terdaftar, gunakan NIP lain.',
            'jabatan.required' => 'Jabatan wajib diisi.',
            'jabatan.exists' => 'Jabatan yang dipilih tidak valid.',
            'no_telpn.required' => 'Nomor telepon wajib diisi.',
            'no_telpn.regex' => 'Nomor telepon harus diawali dengan "08" dan minimal 11 digit.',
            'no_telpn.unique' => 'Nomor telepon sudah terdaftar, gunakan nomor lain.',
            'email.required' => 'Email wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email sudah terdaftar, gunakan email lain.',
            'dir_foto.required' => 'Foto wajib diisi.',
            'dir_foto.image' => 'File harus berupa gambar.',
            'dir_foto.mimes' => 'Ekstensi gambar yang diizinkan hanya jpg, png, dan jpeg.',
            'dir_foto.max' => 'Ukuran gambar maksimal 124kb.',
        ];
    }
}