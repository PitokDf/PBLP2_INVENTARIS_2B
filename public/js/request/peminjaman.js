$(document).ready(function () {
    $('#table_request').DataTable({
        "processing": true,
        "paging": true,
        "searching": true,
        "responsive": true,
        "language": {
            "search": " 🔍 "
        },
        "ajax": {
            "url": "/getRequestPeminjaman", // Ganti dengan URL endpoint Anda
            "type": "GET"
        },
        "columns": [{
            "data": "kode_peminjaman",
            // "render": function (_data, _type, _row, meta) {
            //     return meta.row + 1; // Nomor urut otomatis berdasarkan posisi baris
            // },
            "orderable": false
        },
        {
            "data": null,
            "render": function (_data, _row, item) {
                return item.barang.nama_barang
            },
            "orderable": true
        },
        {
            "data": null,
            "render": function (_data, _row, item) {
                if (item.user.role == 4) {
                    return item.user.mahasiswa.nama + ' <span class="badge text-bg-primary">Mahasiswa</span>'
                } else if (item.user.role == 3) {
                    return item.user.dosen.name + ' <span class="badge text-bg-primary">Dosen</span>'
                } else {
                    return item.user.username + ' <span class="badge text-bg-primary">Staf</span>';
                }
            },
            "orderable": true
        },
        {
            "data": null,
            'render': function (_data, _type, row) {
                return !row.status ?
                    '<button class="btn btn-sm btn-info" id="btnSetujui" data-id=' + row
                        .kode_peminjaman + '><i class="fas fa-check-double"></i> Setujui</button>' :
                    '';
            },
            "orderable": false
        }
        ]
    });

    $(document).on('click', '#btnSetujui', function () {
        Swal.fire({
            title: "Yakin ingin menyetujui peminjaman?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes"
        }).then((result) => {
            if (result.isConfirmed) {
                var data = new FormData();
                data.append('kode_peminjaman', $(this).data('id'));
                AjaxPostIncludeData('/setujui-peminjaman', data, function (response) {
                    console.log(response);
                    response.status == 200 ?
                        (Swal.fire({
                            title: "Success",
                            text: response.message,
                            icon: "success",
                            confirmButtonText: "Ok"
                        }), reloadTable(table_request)) : ''
                    response.status == 400 ?
                        Swal.fire({
                            title: "Ops..",
                            text: response.message,
                            icon: "error",
                            confirmButtonText: "Ok"
                        }) : ''
                })
            }
        })
    });
});