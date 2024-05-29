<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $user = User::select([
            'username',
            'email',
            'role',
            'password'
        ])->get();
        return $user;
    }

    public function headings(): array
    {
        return [
            "Username",
            "Email",
            "Role",
            "Password"
        ];
    }
}