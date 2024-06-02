$(document).ready(function () {
    var kategoriList = "";

    $('#table_peminjaman').DataTable({
        "processing": true,
        "paging": true,
        "searching": true,
        "responsive": true,
        "language": {
            "search": " 🔍 "
        },
        "ajax": {
            "url": "/getDataPeminjaman", // Ganti dengan URL endpoint Anda
            "type": "GET"
        },
        "columns": [
            {
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
                }, "orderable": true
            },
            {
                "data": null,
                "render": function (_data, _row, item) {
                    return item.user.username
                },
                "orderable": true
            },
            {
                "data": null,
                'render': function (_data, _type, row) {
                    if (row.status === 0) {
                        return `<button id="${row.id_barang}" data-id="${row.id}" class="btn btn-sm btn-danger kembalikan">Kembalikan</button>`;
                    } else {
                        return `<button id="sudahKembali" class="btn btn-sm btn-success">sudah dikembalikan</button>`;
                    }
                },
                "orderable": false
            },
            {
                "data": null,
                "render": function (_data, _type, row) {
                    if (row.status === 1) {
                        return "<button type='button' data-id='" + row.id + "' class='btn btn-sm btn-danger btnDelete'><i class='fas a-solid fa-trash'></i></button> <button class='btn btn-sm btn-info btnDetail' id='" + row.id + "'><i class='fas fa-regular fa-info-circle'></i></button>"
                    } else {
                        return "<button class='btn btn-sm btn-info btnDetail' id='" + row.id + "'><i class='fas fa-regular fa-info-circle'></i></button>"
                    }
                }
                , "orderable": false
            }
        ]
    });


    var url = "";
    // var modal = $('#modal_peminjaman');
    var modal = $('#modalPeminjaman');
    var modal_title = $('.modal-title');
    var btnAction = $('.action');

    // fungsi untuk membersihkan pesan error
    function clearErrorMsg() {

        $('#namaB_error').text('');
        $('#namaU_error').text('');
        $('#jumlah_error').text('');
        $('#reason_error').text('');
        $('#namaBarang').removeClass('is-invalid');
        $('#namaUser').removeClass('is-invalid');
        $('#reason').removeClass('is-invalid');
        $('#jumlah').removeClass('is-invalid');
    }

    function claerInput() {
        $('.action').attr('disabled', true);
        $('#jumlah').attr('readonly', true);
        $('#code_barang').val('');
        $('#namaUser').val('');
        $('#jumlah').val('');
        $('#reason').val('');
        $('#kategori_barang').val('');
        $('#nama_barang').val('');
    }

    $(document).on('click', '.kembalikan', function () {
        $('#modalKembalikan').modal('show');
        $.ajax({
            type: "GET",
            url: "/peminjaman/" + $(this).data('id'),
            dataType: "json",
            success: function (response) {
                console.log(response);
                const data = response.data;
                $('#id').val(data.id);
                $('#nama_barangK').val(data.barang.nama_barang);
                $('#kode_barangK').val(data.barang.code_barang);
                $('#jumlahK').val(data.jumlah);
                $('#peminjamK').val(data.user.username);
                $('#tglpeminjamanK').val(dateCutomFormat(data.tgl_peminjaman));
                $('#bataspengembalianK').val(dateCutomFormat(data.batas_pengembalian));
                $('#reasonK').val(data.keterangan);
            }
        });
    });

    $('#kembalikan').on('click', function () {
        $('#kondisiK').removeClass('is-invalid');
        $('#kondisi_error').text('');
        var data = new FormData();
        data.append('_method', 'PUT');
        data.append('kondisi', $('#kondisiK').val());
        $.ajax({
            type: "POST",
            url: "/peminjaman/" + $('#id').val(),
            processData: false,
            contentType: false,
            data: data,
            dataType: "json",
            success: function (response) {
                response.status == 202 ?
                    Swal.fire({
                        title: "Opss...",
                        text: response.message,
                        icon: "error"
                    }) : '';
                response.status === 200 ? (
                    $('#kondisiK').removeClass('is-invalid'),
                    $('#kondisiK').val(''),
                    $('#kondisi_error').text(''),
                    $('#modalKembalikan').modal('hide'),
                    reloadTable(table_peminjaman),
                    Swal.fire({
                        title: "Dikembalikan!",
                        text: response.message,
                        icon: "success"
                    })
                ) : '';
            },
            error: function (errors) {
                $('#kondisiK').removeClass('is-invalid');
                $('#kondisi_error').text('');
                if (errors.responseJSON.kondisi) {
                    $('#kondisiK').addClass('is-invalid');
                    $('#kondisi_error').text(errors.responseJSON.kondisi);
                }
            }
        });
    })
    // saat tombol edit di click maka akan mengambil data sesaui id
    $(document).on('click', '.btnDetail', function () {
        $('#modalDetailPeminjaman').modal('show');
        btnAction.attr('id', 'btnDetail');
        url = "/peminjaman/" + $(this).attr('id');

        $.ajax({
            type: "GET",
            url: url,
            dataType: "json",
            success: function (response) {
                console.log(response)
                if (response.status === 200) {
                    const data = response.data;
                    $('#id_peminjaman').text(data.kode_peminjaman);
                    $('#namaBarang').text(data.barang.nama_barang);
                    $('#peminjam').text(data.user.username);
                    $('#kodeBarang').text(data.barang.code_barang);

                    let denda = calculateDenda(data.batas_pengembalian, getCurrentDate(), 1500);

                    $('#denda').text(data.denda == 0 ? formatRupiah(denda) : formatRupiah(data.denda));
                    $('#batasPeminjaman').text(dateCutomFormat(data.batas_pengembalian) ?? '~');
                    $('#dipinjam').text(dateCutomFormat(data.tgl_peminjaman) ?? '~');
                    data.tgl_pengembalian !== null ? (
                        $('#statusP').html(`<strong>Telah dikembalikan (${dateCutomFormat(data.tgl_pengembalian)})</strong>`),
                        $('#statusP').removeClass('text-danger').addClass('text-success')
                    ) : (
                        $('#statusP').html('<strong>Belum dikembalikan</strong>'),
                        $('#statusP').addClass('text-danger').removeClass('text-success')
                    );
                }
            },
            error: function (xhr, status, error) {
                console.info(xhr + "\n" + status + "\n" + error)
            }
        });
    });

    // menangani proses delete data
    $(document).on('click', '.btnDelete', function () {
        Swal.fire({
            title: "Yakin ingin menghapus?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes"
        }).then((result) => {
            if (result.isConfirmed) {
                var url = '/peminjaman/' + $(this).data('id');
                var data = { "_method": "DELETE" };
                $.ajax({
                    type: "POST",
                    url: url,
                    data: data,
                    dataType: "json",
                    success: function (response) {
                        response.status === 200 ? (
                            reloadTable(table_peminjaman),
                            Swal.fire({
                                title: "Deleted!",
                                text: response.message,
                                icon: "success"
                            })
                        ) : '';
                        response.status === 202 ? (
                            Swal.fire({
                                title: "ops..",
                                text: response.message,
                                icon: "error"
                            })
                        ) : '';
                    },
                    error: function (xhr, stattus, error) {
                        console.error(xhr + "\n" + stattus + "\n" + error)
                    }
                });
            }
        });
    });


    $('#cari_barang').click(function () {
        const code = document.getElementById('code_barang').value;
        if (code.trim() !== '') {
            $.ajax({
                type: "get",
                url: "/get-barang/" + code,
                dataType: "json",
                success: function (response) {
                    $('#nama_barang').val('');
                    $('#kategori_barang').val('');
                    console.log(response)
                    if (response.status === 200) {
                        $('#jumlah').attr('readonly', false);
                        $('.action').attr('disabled', false);
                        $('#jumlah').val('1');

                        $('#nama_barang').val(response.data.nama_barang);
                        $('#stok').val(response.data.quantity);
                        $('#kategori_barang').val(response.data.kategori.nama_kategori_barang);
                    }
                    if (response.status === 404) {
                        $('#jumlah').attr('readonly', true);
                        $('.action').attr('disabled', true);
                        $('#jumlah').val('');
                        //sweetalert
                        Swal.fire({
                            icon: 'error',
                            title: 'Ops !!',
                            text: response.message,
                            confirmButtonText: 'Periksa',
                            confirmButtonColor: '#007bff',
                        });
                    }
                }
            });
        }
    });


    // menampilkan modal form saat btn create di click
    $('#btnCreate').click(function () {
        $.ajax({ type: "GET", url: "/getKodePeminjaman", dataType: "text", success: function (response) { $('#kodeP').text(response); } });
        modal.modal('show');
        modal_title.text('Form Peminjaman');
        btnAction.html("<i class='fas fa-save'></i> Pinjam");
        $('#name_error').text('');
        if (btnAction.attr('id') != "btnCreateform") {
            clearErrorMsg();
            $('#modal_peminjaman input').val('');
        }
        btnAction.attr('id', 'btnCreateform');
    });

    // menangani proses create data
    $(document).on('click', '#btnCreateform', function () {
        var data = new FormData();
        data.append('namaBarang', $('#code_barang').val());
        data.append('namaUser', $('#namaUser').val());
        data.append('quantity', $('#jumlah').val());
        data.append('reason', $('#reason').val());

        $.ajax({
            type: "post",
            url: "/peminjaman",
            data: data,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (response) {
                clearErrorMsg();
                if (response.status === 200) {
                    claerInput();
                    modal.modal('hide')
                    reloadTable(table_peminjaman)
                    Swal.fire({
                        title: "Created!",
                        text: response.message,
                        icon: "success",
                        confirmButtonText: "Yes"
                    });
                }

                if (response.status === 202) {
                    Swal.fire({
                        title: "Ops..!",
                        text: response.message,
                        icon: "error",
                        confirmButtonText: "Yes"
                    });
                }
            },
            error: function (errors) {
                clearErrorMsg();
                const data = errors.responseJSON;
                if (data.namaBarang) {
                    Swal.fire({
                        title: "Ops..!",
                        text: 'Kode barang masih kosong',
                        icon: "error",
                        confirmButtonText: "Yes"
                    });
                }
                if (data.namaUser) {
                    $('#namaU_error').text(data.namaUser);
                    $('#namaUser').addClass('is-invalid');
                }
                if (data.quantity) {
                    $('#jumlah_error').text(data.quantity);
                    $('#jumlah').addClass('is-invalid');
                }
                if (data.reason) {
                    $('#reason_error').text(data.reason);
                    $('#reason').addClass('is-invalid');
                }
                console.log(errors)
            }
        });
    });

    // menangani proses edit data 
    $(document).on('click', '#btnEdit', function () {
        var data = new FormData();
        data.append('_method', "PUT")
        if ($('#foto')[0].files.length > 0) {
            data.append('foto', $('#foto')[0].files[0]);
        }
        data.append('jumlah', $('#jumlah').val());
        data.append('kategori', $('#kategori').val());
        data.append('kode_barang', $('#kode_barang').val());
        data.append('nama_barang', $('#nama_barang').val());
        data.append('posisi', $('#posisi').val());
        var id = $('#id').val();
        var url = "barang/" + id;
        $.ajax({
            type: "POST",
            url: url,
            data: data,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (response) {
                if (response.status == 200) {
                    reloadTable(table_barang);
                    claerInput();
                    clearErrorMsg();
                    modal.modal('hide');
                    Swal.fire({
                        title: "Update!",
                        text: response.message,
                        icon: "success",
                        confirmButtonText: "Yes"
                    });
                }
            },
            error: function (xhr, status, error) {
                clearErrorMsg();
                var data = xhr.responseJSON.errors;
                if (data.kode_barang) {
                    $('#kode_error').text(data.kode_barang);
                    $('#kode_barang').addClass('is-invalid');
                }
                if (data.nama_barang) {
                    $('#nama_error').text(data.nama_barang);
                    $('#nama_barang').addClass('is-invalid');
                }
                if (data.kategori) {
                    $('#kategori_error').text(data.kategori);
                    $('#kategori').addClass('is-invalid');
                }
                if (data.jumlah) {
                    $('#jumlah_error').text(data.jumlah);
                    $('#jumlah').addClass('is-invalid');
                } if (data.posisi) {
                    $('#posisi_error').text(data.posisi);
                    $('#posisi').addClass('is-invalid');
                }
                if (data.foto) {
                    $('#foto_error').text(data.foto);
                    $('#foto').addClass('is-invalid');
                }
            }
        });
    });

});