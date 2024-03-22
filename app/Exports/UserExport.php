<?php

namespace App\Exports;

use App\Models\Users;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class UserExport implements FromCollection, WithHeadingRow
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {
        return Users::select([
            'name',
            'email',
            'role',
            'password'
        ])->get();
    }

    public function headings(): array
    {
        return [
            "Nama",
            "Email",
            "Role",
            "Password",
        ];
    }
}