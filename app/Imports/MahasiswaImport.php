<?php

namespace App\Imports;


use App\Models\Mahasiswas;
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
        $existingMahasiswa = Mahasiswas::where('nim', $row['nim'])->first();

        if ($existingMahasiswa) {
            return null;
        }

        return new Mahasiswas([
            'nim' => $row['nim'],
            'nama' => $row['nama'],
            'code_prodi' => $row['prodi'],
            'angkatan' => $row['angkatan'],
            'ipk' => $row['ipk'],
        ]);
    }
}