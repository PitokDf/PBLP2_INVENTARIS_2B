<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        return view('umum.profile');
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
        // mengupdate table user
        $user->update($data);
        return response()->json([
            'status' => 200,
            'message' => 'berhasil merubah informasi akun.'
        ]);
    }
}