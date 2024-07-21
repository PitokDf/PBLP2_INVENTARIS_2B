import { AjaxGetData, dateCutomFormat, formatRupiah } from "../setupAjax";

$(document).ready(function () {
    $('#tablebarang').DataTable({
        "processing": true,
        "paging": true,
        "searching": true,
        "responsive": true,
        "language": {
            "search": "cari"
        },
        "ajax": {
            "url": "get-riwayat-peminjaman",
            "type": "GET"
        },
        "columns": [{
            "data": null,
            "render": function (_data, _type, _row, meta) {
                return meta.row + 1;
            }
        },
        {
            "data": null,
            "render": function (_data, _type, _row, meta) {
                return _data.kode_peminjaman ?? '~';
            }
        },
        {
            "data": null,
            "render": function (_data, _type, _row, meta) {
                return _data.barang.nama_barang ?? '~';
            }
        },
        {
            "data": null,
            "render": function (_data, _type, _row, meta) {
                return dateCutomFormat(_data.tgl_peminjaman) ?? '~';
            }
        },
        {
            "data": null,
            "render": function (_data, _type, _row, meta) {
                return dateCutomFormat(_data.batas_pengembalian) ?? '~';
            }
        },
        {
            "data": null,
            "render": function (_data, _type, _row, meta) {
                return _data.status == 1 ? (_data.tgl_pengembalian ? `<span class="badge text-bg-success">Sudah dikembalikan</span>` : `<span class="badge text-bg-info">Belum dikembalikan</span>`) : (_data.status == 2 ? `<span class="badge text-bg-danger"><i class="fas fa-ban"></i> Request ditolak</span>` : `<span class="badge text-bg-warning"><i class="fas fa-clock"></i> Pending Request</span>`);
            }
        },
        {
            "data": null,
            "render": function (_data, _type, _row, meta) {
                return `<button class="btn btn-sm btn-info" data-id="${_data.id}" id="btnDetail">
                            <i class="fas fa-info-circle"></i>
                        </button>`;
            }
        },
        ]
    });

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