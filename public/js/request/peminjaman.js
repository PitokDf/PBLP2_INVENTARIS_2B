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
        "columns": [
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
                "data": 'keterangan',
                "orderable": false
            },
            {
                "data": null,
                'render': function (_data, _type, row) {
                    return !row.status ?
                        '<button class="btn btn-sm btn-outline-success" id="btnSetujui" data-id=' + row
                            .id + '><i class="fas fa-check"></i></button> <button class="btn btn-sm btn-outline-danger" id="btnReject" data-id=' + row
                            .id + '><i class="fas fa-times"></i></button>' :
                        '<button class="btn btn-sm btn-danger" id="btnHapus" data-id=' + row
                            .id + '><i class="fas fa-trash"></i></button>';
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
        });
    });

    $(document).on('click', '#btnReject', function () {
        // alert($(this).data('id'));
        Swal.fire({
            title: "Tolak peminjaman?",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes"
        }).then((result) => {
            if (result.isConfirmed) {
                var data = new FormData();
                data.append('id', $(this).data('id'));
                AjaxPostIncludeData('/reject-peminjaman', data, function (response) {
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
        });
    });

    $(document).on('click', '#btnHapus', function () {
        Swal.fire({
            title: "Hapus record?",
            icon: "question",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes"
        }).then((result) => {
            if (result.isConfirmed) {
                var data = new FormData();
                // data.append('id', $(this).data('id'));
                data.append('_method', 'DELETE');
                AjaxPostIncludeData('/peminjaman/' + $(this).data('id'), data, function (response) {
                    response.status == 200 ?
                        (Swal.fire({
                            title: "Success",
                            text: response.message,
                            icon: "success",
                            confirmButtonText: "Ok"
                        }), reloadTable(table_request)) : ''
                    response.status == 202 ?
                        Swal.fire({
                            title: "Ops..",
                            text: response.message,
                            icon: "error",
                            confirmButtonText: "Ok"
                        }) : ''
                })
            }
        });
    });
});