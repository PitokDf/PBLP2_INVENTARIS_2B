<?php

namespace App\Http\Controllers;

use App\Exports\UserExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StoreUsersRequest;
use App\Http\Requests\UpdateUsersRequest;
use App\Imports\UserImport;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view("user.index");
    }

    public function getAllData()
    {
        $data = User::all();
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
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUsersRequest $request)
    {
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => $request->role,
            'email_verified_at' => now()
        ];

        User::create($data);

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
        $data = User::where('id_user', $id)->get([
            "id_user",
            'name',
            'email',
            'password',
            'role'
        ]);

        // dd($data . "dan id " . $id);
        return response()->json([
            'status' => 200,
            'data' => $data,
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
            $rules = [
                "email" => [
                    'required',
                    'email',
                    Rule::unique('users')->ignore($user),  // Use $user->id for clarity
                ]
            ];

            if (!empty($request->password)) {
                $rules['password'] = ['min:8'];  // Array for password rules
            }

            $validator = Validator::make($request->all(), $rules, [
                "email.unique" => "Email sudah pernah tersedia.",
                "password" => "Password minimal :min karakter."
            ]);


            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $user->name = $request->name;
            $user->email = $request->email;
            $user->role = $request->role;
            if (!empty($request->password)) {
                $user->password = bcrypt($request->password); // Perhatikan apakah Anda ingin mengizinkan penggunaan plaintext password di sini
            }
            $user->save();

            return response()->json([
                'status' => 200,
                'message' => "Berhasil mengupdate data."
            ]);
        } catch (\Throwable $e) {
            return response()->json([
                'status' => 500,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $users, $id)
    {
        if (auth()->user()->id_user != $id) {
            User::findOrFail($id)->delete();
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