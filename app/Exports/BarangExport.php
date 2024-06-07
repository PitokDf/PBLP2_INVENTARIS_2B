<?php

namespace App\Exports;

use App\Models\Barang;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class BarangExport implements FromCollection, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
    public function headings(): array
    {
        return ['Kode', 'Nama', 'Kategori', 'Jumlah', 'Posisi'];
    }
    public function collection()
    {
        return Barang::with('kategori')->get()->map(function ($barang) {
            return [
                'code_barang' => $barang->code_barang,
                'nama_barang' => $barang->nama_barang,
                'nama_kategori' => $barang->kategori->nama_kategori_barang,
                'quantity' => $barang->quantity,
                'posisi' => $barang->posisi,
            ];
        });
    }
}