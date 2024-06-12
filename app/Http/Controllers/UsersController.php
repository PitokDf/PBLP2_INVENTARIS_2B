<?php

namespace App\Http\Controllers;

use App\Exports\UserExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StoreUsersRequest;
use App\Http\Requests\UpdateUsersRequest;
use App\Imports\UserImport;
use App\Models\ActivityLog;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // private $log = new ActivityLog();
    public function index()
    {
        return view("user.index");
    }

    public function getAllData()
    {
        $data = User::latest()->get();
        return response()->json([
            'status' => 200,
            'data' => $data
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUsersRequest $request)
    {
        $data = [
            'username' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'email_verified_at' => now()
        ];

        if (!empty($request->nim) || !empty($request->nip)) {
            $data['mahasiswa_id'] = $request->nim;
            $data['dosen_id'] = $request->nip;
        }

        User::create($data);
        ActivityLog::createLog('add', 'Menambahkan data user');
        return response()->json([
            'status' => 200,
            'message' => 'Berhasil Menambahkan data user.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(User $users)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $data = User::with(['mahasiswa', 'dosen'])->where('id_user', $id)->first();

        return response()->json([
            'status' => 200,
            'data' => [
                $data,
                'nim' => $data->mahasiswa ? $data->mahasiswa->nim : null,
                'nip' => $data->dosen ? $data->dosen->nip : null
            ],
            'session' => Auth::user()->email
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUsersRequest $request, $id)
    {
        try {
            $user = User::findOrFail($id);
            if (!empty($request->role)) {
                if (in_array($user->role, ['2', '3', '4']) && ($user->mahasiswa_id !== null || $user->dosen_id !== null)) {
                    return response()->json([
                        'status' => '400',
                        'message' => 'Role Mahasiswa atau Dosen tidak boleh diubah.'
                    ]);
                }
            }
            $rules = [
                "email" => 'required|email|' . Rule::unique('users')->ignore($user),
                "role" => 'required_if:role,!null',
                'password' => 'nullable|min:8'
            ];

            $validator = Validator::make($request->all(), $rules, [
                "email.unique" => "Email sudah pernah tersedia.",
                "password" => "Password minimal :min karakter."
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            if (!empty($request->role)) {
                $user->role = $request->role;
            }

            if (!empty($request->nim) || !empty($request->nip)) {
                $user->mahasiswa_id = $request->nim;
                $user->dosen_id = $request->nip;
            }

            $user->username = $request->name;
            $user->email = $request->email;

            if (!empty($request->password)) {
                $user->password = bcrypt($request->password);
            }
            $user->save();
            ActivityLog::createLog('update', 'Mengupdate data user');
            return response()->json([
                'status' => 200,
                'message' => "Berhasil mengupdate data."
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => '400',
                'message' => $e->getMessage(),
            ], '400');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $users, $id)
    {
        if (auth()->user()->id_user != $id) {
            User::findOrFail($id)->delete();
            ActivityLog::create([
                'id_user' => auth()->user()->id_user,
                'activity' => 'delete',
                'deskripsi' => 'menghapus data user pada ' . date('Y-F-d H:i'),
                'time' => now()
            ]);
            return response()->json([
                'status' => 200,
                'message' => 'Berhasil Menghapus data user.'
            ]);
        } else {
            return response()->json([
                'status' => 302,
                'message' => 'Tidak dapat menghapus diri sendiri.'
            ]);
        }
    }

    public function import()
    {
        Excel::import(new UserImport, request()->file('file'));

        return response()->json([
            "status" => 200,
            "message" => "file berhasil diimport"
        ]);
    }
    public function export()
    {
        // $export = new UserExport; 
        return Excel::download(new UserExport, 'data.xlsx');
    }

}