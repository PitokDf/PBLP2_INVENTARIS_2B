<?php

namespace App\Http\Controllers;

use App\Exports\UserExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Requests\StoreUsersRequest;
use App\Http\Requests\UpdateUsersRequest;
use App\Imports\UserImport;
use App\Models\Users;
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
        $data = Users::all();
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
            'password' => $request->password,
            'role' => $request->role
        ];

        Users::create($data);

        return response()->json([
            'status' => 200,
            'message' => 'Berhasil Menambahkan data user.'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Users $users)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Users $users, $id)
    {
        $data = Users::where('id_user', $id)->get([
            "id_user",
            'name',
            'email',
            'password',
            'role'
        ]);
        return response()->json([
            'status' => 200,
            'data' => $data
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUsersRequest $request, $id)
    {
        try {
            $user = Users::findOrFail($id);

            $rules = [
                'email' => [
                    'required',
                    'email',
                    Rule::unique('users')->ignore($user),
                ],
            ];

            $validator = Validator::make($request->all(), $rules, [
                "email.unique" => "Email sudah pernah digunakan",
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 422);
            }

            $user->name = $request->name;
            $user->email = $request->email;
            $user->role = $request->role;
            $user->password = $request->password; // Perhatikan apakah Anda ingin mengizinkan penggunaan plaintext password di sini
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
    public function destroy(Users $users, $id)
    {
        Users::where('id_user', $id)->delete();
        return response()->json([
            'status' => 200,
            'message' => 'Berhasil Menghapus data user.'
        ]);
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
        // try {
        //     Excel::download(new UserExport(), 'datauser.xlsx');
        //     response()->json([
        //         "status" => 200,
        //         "message" => "File berhasil diexport"
        //     ]);
        // } catch (\Exception $e) {
        //     return response()->json([
        //         "status" => 500,
        //         "message" => "Gagal mengekspor file: " . $e->getMessage()
        //     ]);
        // }
    }

}