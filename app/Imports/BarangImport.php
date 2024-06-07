<?php

namespace App\Imports;


use App\Models\Barang;
use App\Models\KategoriBarang;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class BarangImport implements ToModel, WithHeadingRow
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        $existingBarang = Barang::where('code_barang', $row['kode'])->first();

        if ($existingBarang) {
            return null;
        }

        $idKategori = KategoriBarang::where('nama_kategori_barang', '=', $row['kategori'])->first();
        if (!$idKategori) {
            return null;
        }
        return new Barang([
            'code_barang' => $row['kode'],
            'nama_barang' => $row['nama'],
            'id_kategory' => $idKategori->id,
            'quantity' => $row['jumlah'],
            'posisi' => $row['posisi'],
        ]);
    }
}