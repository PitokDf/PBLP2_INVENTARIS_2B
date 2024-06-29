<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UserImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $existingUser = User::where('email', $row['email'])->first();

        if ($existingUser) {
            return null;
        }
        return new User([
            "username" => $row["username"],
            "email" => $row["email"],
            "role" => $row["role"],
            "password" => bcrypt($row['password'])
        ]);
    }
}