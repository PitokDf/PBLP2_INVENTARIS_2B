<?php

namespace App\Exports;

use App\Models\Mahasiswas;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class MahasiswaExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function headings(): array
    {
        return ['Nim', 'Nama', 'Prodi', 'Angkatan', 'IPK'];
    }
    public function collection()
    {
        return Mahasiswas::select([
            "nim",
            "nama",
            "code_prodi",
            "angkatan",
            "ipk"
        ])->get();
    }
}