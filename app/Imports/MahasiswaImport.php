<?php

namespace App\Imports;

use App\Models\Mahasiswa;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class MahasiswaImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $existingMahasiswa = Mahasiswa::where('nim', $row['nim'])->first();

        if ($existingMahasiswa) {
            return null;
        }

        return new Mahasiswa([
            'nim' => $row['nim'],
            'nama' => $row['nama'],
            'program_studi' => $row['prodi'],
            'angkatan' => $row['angkatan'],
            'ipk' => $row['ipk'],
        ]);
    }
}