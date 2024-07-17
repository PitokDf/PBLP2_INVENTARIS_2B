import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css',
                'resources/js/app.js',
                'resources/js/umum/peminjaman.js',
                'resources/js/umum/profile.js',
                'resources/js/umum/riwayat_peminjaman.js',
                'resources/js/pages/register.js',
                "resources/js/activity_log.js",
                "resources/js/admin_bug_report.js",
                "resources/js/barang.js",
                "resources/js/barang_keluar.js",
                "resources/js/barang_masuk.js",
                "resources/js/berita.js",
                "resources/js/bootstrap.js",
                "resources/js/bug_report.js",
                "resources/js/dosen.js",
                "resources/js/jabatan.js",
                "resources/js/kategori_barang.js",
                "resources/js/kategori_berita.js",
                "resources/js/mahasiswa.js",
                "resources/js/merk.js",
                "resources/js/pemasok.js",
                "resources/js/preview.js",
                "resources/js/prodi.js",
                "resources/js/reloadTable.js",
                "resources/js/request_peminjaman.js",
                "resources/js/setupAjax.js",
                "resources/js/topThreeBarang.js",
                "resources/js/user.js"
            ],
            refresh: true,
        }),
    ],
});
