<?php

namespace App\Exports;

use App\Models\Mahasiswa;
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
        return Mahasiswa::select([
            "nim",
            "nama",
            "program_studi",
            "angkatan",
            "ipk"
        ])->get();
    }
}