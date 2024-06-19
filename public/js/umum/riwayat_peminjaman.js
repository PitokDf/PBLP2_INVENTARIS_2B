$(document).ready(function () {
    $('#tablebarang').DataTable();

    $(document).on('click', '#btnDetail', function () {
        // alert($(this).data('id'));
        $('#modalDetail').modal('show')
        AjaxGetData('/detail-peminjaman/' + $(this).data('id'), function (res) {
            if (res.status === 200) {
                $('#txt_kode_peminjaman').text(res.data.status == 2 ? 'Peminjaman ditolak' : res.data.kode_peminjaman ?? 'Peminjaman belum disetujui.');
                $('#txt_kode_barang').text(res.data.barang.code_barang);
                $('#txt_nama_barang').text(res.data.barang.nama_barang);
                $('#txt_tgl_dipinjam').text(dateCutomFormat(res.data.tgl_peminjaman));
                $('#txt_batas_pinjam').text(dateCutomFormat(res.data.batas_pengembalian));
                $('#txt_denda').text(res.data.status == 1 ? formatRupiah(res.data.denda) : '~');
                $('#txt_alasan').text(res.data.keterangan);
                $('#txt_status').html(res.data.status == 1 ? (res.data.tgl_pengembalian ? ` <span class="badge text-bg-success">Sudah dikembalikan pada ${dateCutomFormat(res.data.tgl_pengembalian)}</span>` : '<span class="badge text-bg-info">Belum dikembalikan</span>') : (res.data.status == 2 ? `<span class="badge text-bg-danger"><i class="fas fa-ban"></i> Request ditolak</span>` : `<span class="badge text-bg-warning"><i class="fas fa-clock"></i> Pending Request</span>`));
            }
        });
    });
});