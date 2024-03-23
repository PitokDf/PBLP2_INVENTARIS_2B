<?php

namespace App\Exports;

use App\Models\Users;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class UserExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        $user = Users::select([
            'name',
            'email',
            'role',
            'password'
        ])->get();
        return $user;
    }

    public function headings(): array
    {
        return [
            "Nama",
            "Email",
            "Role",
            "Password"
        ];
    }
}