<?php

namespace App\Imports;


use App\Models\Barang;
use App\Models\KategoriBarang;
use App\Models\Merk;
use App\Models\Pemasok;
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

        $idKategori = KategoriBarang::where('nama_kategori_barang', $row['kategori'])->first();
        $idPemasok = Pemasok::where('nama', $row['pemasok'])->first();
        $idMerk = Merk::where('merk', $row['merk'])->first();
        if (!$idKategori || !$idPemasok || !$idMerk) {
            return null;
        }
        return new Barang([
            'code_barang' => $row['kode'],
            'nama_barang' => $row['nama'],
            'id_kategory' => $idKategori->id,
            'merk_id' => $idMerk->id,
            'quantity' => $row['jumlah'],
            'tanggal_masuk' => $row['tanggal_masuk'],
            'supplier_id' => $idPemasok->id,
            'posisi' => $row['posisi']
        ]);
    }
}