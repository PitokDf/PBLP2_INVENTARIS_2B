$(document).ready(function () {
    $('#tablebarang').DataTable();

    $(document).on('click', '#btnDetail', function () {
        // alert($(this).data('id'));
        $('#modalDetail').modal('show')
        AjaxGetData('/detail-peminjaman/' + $(this).data('id'), function (res) {
            console.log(res)
            if (res.status === 200) {
                $('#txt_kode_peminjaman').text(res.data.kode_peminjaman);
                $('#txt_kode_barang').text(res.data.barang.code_barang);
                $('#txt_nama_barang').text(res.data.barang.nama_barang);
                $('#txt_tgl_dipinjam').text(dateCutomFormat(res.data.tgl_peminjaman));
                $('#txt_batas_pinjam').text(dateCutomFormat(res.data.batas_pengembalian));
                $('#txt_denda').text(res.data.status ? formatRupiah(res.data.denda) : '~');
                $('#txt_alasan').text(res.data.keterangan);
                $('#txt_status').html(res.data.status ? (res.data.tgl_pengembalian ? dateCutomFormat(res.data.tgl_pengembalian) : '<span class="badge text-bg-danger">Belum dikembalikan</span>') : `<span class="badge text-bg-warning"><i class="fas fa-clock"></i> Pending Request</span>`);
            }
        });
    });
});