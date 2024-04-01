<?php

namespace App\Imports;

use App\Models\Users;
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
        $existingUser = Users::where('email', $row['email'])->first();

        if ($existingUser) {
            return null;
        }
        return new Users([
            "name" => $row["nama"],
            "email" => $row["email"],
            "role" => $row["role"],
            "password" => bcrypt($row['password'])
        ]);
    }
}