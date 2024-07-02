$(document).ready(function () {
    var kategoriList = "";
    // mendapatkan kategori barang dari server
    $.ajax({
        url: "getKategori", // URL endpoint untuk mengambil data kategori
        type: "GET",
        success: function (response) {
            // Handle successful response
            kategoriList = response.data;

            // Populate the dropdown list with kategori options
            $.each(kategoriList, function (index, kategori) {
                $("#kategori").append(
                    "<option value='" + kategori.id + "'>" + kategori.nama_kategori_barang + "</option>"
                );
            });
        },
        error: function (error) {
            // Handle error response
            console.error("Error retrieving kategori:", error);
        }
    });

    $('#table_barang').DataTable({
        "processing": true,
        "paging": true,
        "searching": true,
        "responsive": true,
        "language": {
            "search": "cari"
        },
        "ajax": {
            "url": "getAllDataBarang", // Ganti dengan URL endpoint Anda
            "type": "GET"
        },
        "columns": [
            {
                "data": null,
                "render": function (_data, _type, row) {
                    return "<input class='selected' type='checkbox' value='" + row.id_barang + "'>"
                }
                , "orderable": false
            },
            {
                "data": null,
                "render": function (_data, _type, _row, meta) {
                    return meta.row + 1; // Nomor urut otomatis berdasarkan posisi baris
                },
                "orderable": false
            },
            { "data": "code_barang", "orderable": true },
            { "data": "nama_barang", "orderable": true },
            {
                "data": null,
                render: function (_data, _type, row) {
                    return row.kategori ? row.kategori.nama_kategori_barang : '<strong style="color:red;">not found</strong>';
                },
                "orderable": true
            },
            {
                "data": null,
                "render": function (_data, _type, row) {
                    return row.merek ? row.merek.merk : '<strong style="color:red;">not found</strong>';
                }, "orderable": true
            },
            { "data": "quantity", "orderable": true },
            {
                "data": null,
                "render": function (_data, _type, row) {
                    return "<button type='button' data-id='" + row.id_barang + "' class='btn btn-sm btn-danger btnDelete'><i class='fas a-solid fa-trash'></i></button> <button class='btn btn-sm btn-warning btnEdit' id='" + row.id_barang + "'><i class='fas fa-regular fa-pen'></i></button> <button class='btn btn-sm btn-info btnDetail' id='" + row.id_barang + "'><i class='fas fa-regular fa-info-circle'></i></button>"
                }
                , "orderable": false
            }
        ]
    });


    var url = "";
    var modal = $('#modal-kategori');
    var modal_title = $('.modal-title');
    var btnAction = $('.action');

    function updateDays() {
        var month = $('#bulan').val();
        var daySelect = $('#tanggal');
        daySelect.empty();
        daySelect.append('<option value="">Tanggal</option>');

        if (month) {
            var year = $('#tahun').val();
            var daysInMonth = new Date(year, month, 0).getDate();
            for (var i = 1; i <= daysInMonth; i++) {
                daySelect.append('<option value="' + (i < 10 ? '0' + i : i) + '">' + i + '</option>');
            }
        }
    }

    // fungsi untuk membersihkan pesan error
    function clearErrorMsg() {
        $('#kode_error').text('');
        $('#nama_error').text('');
        $('#kategori_error').text('');
        $('#jumlah_error').text('');
        $('#posisi_error').text('');
        $('#foto_error').text('');
        $('#pemasok_error').text('');
        $('#deskripsi_error').text('');
        $('#merek_error').text('');
        $('#tgl_error').text('');
        $('#kode_barang').removeClass('is-invalid');
        $('#nama_barang').removeClass('is-invalid');
        $('#kategori').removeClass('is-invalid');
        $('#jumlah').removeClass('is-invalid');
        $('#posisi').removeClass('is-invalid');
        $('#foto').removeClass('is-invalid');
        $('#deskripsi').removeClass('is-invalid');
    }
    function claerInput() {
        $('#kode_barang').val('');
        $('#nama_barang').val('');
        $('#kategori').val(1).trigger('change');
        $('#jumlah').val('');
        $('#posisi').val('');
        $('#tahun').val('');
        $('#bulan').val('');
        $('#tanggal').val('');
        $('#pemasok').selectpicker('val', '');
        $('#deskripsi').val('');
        $('#merek').selectpicker('val', '');
        $('#img-preview').attr('src', '/images/download.png');
    }

    $('#pemasok').selectpicker({
        liveSearch: true,
    });
    $('#merek').selectpicker({
        liveSearch: true,
    });

    $('#bulan').on('change', function () {
        updateDays()
    });
    // saat tombol edit di click maka akan mengambil data sesaui id
    $(document).on('click', '.btnEdit', function () {
        clearErrorMsg();
        modal.modal('show');
        modal_title.text('Edit Barang');
        btnAction.attr('id', 'btnEdit');
        btnAction.html("<i class='fas fa-regular fa-pen'></i> Update");
        url = "barang/" + $(this).attr('id') + "/edit";

        $.ajax({
            type: "GET",
            url: url, // Menggunakan variabel 'url' yang sudah didefinisikan sebelumnya
            dataType: "json",
            success: function (response) {
                var data = response.data[0];
                $('#id').val(data.id_barang);
                $('#kode_barang').val(data.code_barang);
                $('#nama_barang').val(data.nama_barang);
                $('#kategori').val(data.id_kategory);
                $('#jumlah').val(data.quantity);
                $('#posisi').val(data.posisi);
                $('#pemasok').selectpicker('val', data.supplier_id);
                $('#merek').selectpicker('val', data.merk_id);
                const date = data.tanggal_masuk;
                const parts = date.split('-');
                $('#tahun').val(parts[0]);
                $('#bulan').val(parts[1]);
                updateDays();
                $('#tanggal').val(parts[2]);
                $('#img-preview').attr('src', data.photo ?? '/images/download.png')
                $('#deskripsi').val(data.deskripsi)
            },
            error: function (xhr, status, error) {
                console.error(xhr + "\n" + status + "\n" + error)
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
                var url = 'barang/' + $(this).data('id');
                var data = { "_method": "DELETE" };
                $.ajax({
                    type: "POST",
                    url: url,
                    data: data,
                    dataType: "json",
                    success: function (response) {
                        reloadTable(table_barang);
                        Swal.fire({
                            title: "Deleted!",
                            text: response.message,
                            icon: "success"
                        });
                    },
                    error: function (xhr, stattus, error) {
                        if (xhr.status === 500) {
                            Swal.fire({
                                title: "Ops !!",
                                text: 'Something went wrong.',
                                icon: "error",
                                confirmButtonText: "Ok"
                            });
                        }
                        console.error(xhr + "\n" + stattus + "\n" + error)
                    }
                });
            }
        });
    });

    // menampilkan modal form saat btn create di click
    $('#btnCreate').click(function () {
        modal.modal('show');
        modal_title.text('Add Barang');
        btnAction.html("<i class='fas fa-save'></i> Simpan");
        $('#name_error').text('');
        if (btnAction.attr('id') != "btnCreateform") {
            claerInput();
            clearErrorMsg();
            // $('#modal-kategori input').val('');
        }
        btnAction.attr('id', 'btnCreateform');
    });

    // menangani proses create data
    $(document).on('click', '#btnCreateform', function () {
        var formData = new FormData();
        if ($('#file_image')[0].files.length > 0) {
            formData.append('foto', $('#file_image')[0].files[0]);
        }
        formData.append('jumlah', $('#jumlah').val());
        formData.append('kategori', $('#kategori').val());
        formData.append('kode_barang', $('#kode_barang').val());
        formData.append('nama_barang', $('#nama_barang').val());
        formData.append('posisi', $('#posisi').val());
        formData.append('merk', $('#merek').val());
        formData.append('tanggal_masuk', $('#tahun').val() + '-' + $('#bulan').val() + '-' + $('#tanggal').val());
        formData.append('deskripsi', $('#deskripsi').val());
        formData.append('pemasok', $('#pemasok').val());
        $.ajax({
            type: "POST",
            url: "barang",
            data: formData,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (response) {
                if (response.status == 200) {
                    reloadTable(table_barang);
                    modal.modal('hide');
                    claerInput();
                    clearErrorMsg();
                    Swal.fire({
                        title: "Insert!",
                        text: response.message,
                        icon: "success",
                        confirmButtonText: "Yes"
                    });
                }
            },
            error: function (xhr, status, error) {
                console.log(xhr)
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
                if (data.merk) {
                    $('#merek_error').text(data.merk);
                    $('#merek').addClass('is-invalid');
                }
                if (data.deskripsi) {
                    $('#deskripsi_error').text(data.deskripsi);
                    $('#deskripsi').addClass('is-invalid');
                }
                if (data.tanggal_masuk) {
                    $('#tgl_error').text(data.tanggal_masuk);
                }
                if (data.pemasok) {
                    $('#pemasok_error').text(data.pemasok);
                }
            }
        });
    });

    // menangani proses edit data
    $(document).on('click', '#btnEdit', function () {
        var data = new FormData();
        data.append('_method', 'PUT');
        if ($('#file_image')[0].files.length > 0) {
            data.append('foto', $('#file_image')[0].files[0]);
        }
        data.append('jumlah', $('#jumlah').val());
        data.append('kategori', $('#kategori').val());
        data.append('kode_barang', $('#kode_barang').val());
        data.append('nama_barang', $('#nama_barang').val());
        data.append('posisi', $('#posisi').val());
        data.append('merk', $('#merek').val());
        data.append('tanggal_masuk', $('#tahun').val() + '-' + $('#bulan').val() + '-' + $('#tanggal').val());
        data.append('deskripsi', $('#deskripsi').val());
        data.append('pemasok', $('#pemasok').val());
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
                if (data.merk) {
                    $('#merek_error').text(data.merk);
                    $('#merek').addClass('is-invalid');
                }
            }
        });
    });

    $(document).on('click', '.showImport', function () {
        $('#modalImport').modal('show');
        $('.action').html("<i class='fas fa-solid fa-file-import'></i> Import");
        $('.action').attr('id', "btnImport");
    });
    $(document).on('click', '#btnImport', function () {
        var data = new FormData();
        data.append('file', $('#file').prop('files')[0]);

        $.ajax({
            type: "POST",
            url: "/importBarang",
            data: data,
            processData: false,
            contentType: false,
            dataType: "json",
            success: function (response) {
                $("#modalImport").modal('hide');
                reloadTable(table_barang);
                $('#file').removeClass('is-invalid');
                $('.error-area').html('');
                $('#file').val('');
                Swal.fire({
                    title: "Imported!",
                    text: response.message,
                    icon: "success"
                });
            },
            error: function (errors) {
                $('#file').addClass('is-invalid');
                $('.error-area').html(`<span class="text-danger">Pilih hanya file .csv atau .xlsx</span>`)
                console.log(errors);
            }
        });
    });

    // update status btn delete all
    function updateBulkDeleteButton() {
        var ids = $('.selected:checked').length;
        if (ids > 0) {
            $('#deleteSelected').prop('disabled', false);
        } else {
            $('#deleteSelected').prop('disabled', true);
        }
    }

    $('#selectAll').click(function () {
        $('.selected').prop('checked', this.checked);
        updateBulkDeleteButton();
    });

    $(document).on('click', '.selected', function () {
        updateBulkDeleteButton();
    });

    $('#deleteSelected').click(function () {
        var ids = [];
        $('.selected:checked').each(function () {
            ids.push($(this).val());
        });

        if (ids.length > 0) {
            Swal.fire({
                title: "Yakin ingin menghapus data terpilih?",
                icon: "warning",
                showCancelButton: true,
                confirmButtonColor: "#3085d6",
                cancelButtonColor: "#d33",
                confirmButtonText: "Yes"
            }).then((result) => {
                if (result.isConfirmed) {
                    var url = '/barangs/bulk-delete';
                    var data = { "_method": "DELETE", ids: ids };
                    $.ajax({
                        type: "POST",
                        url: url,
                        data: data,
                        dataType: "json",
                        success: function (response) {
                            reloadTable(table_barang);
                            Swal.fire({
                                title: "Success",
                                text: response.message,
                                icon: "success"
                            });

                            if (response.status === 400) {
                                Swal.fire({
                                    title: "Ops !!",
                                    text: response.message,
                                    icon: "error",
                                    confirmButtonText: "Ok"
                                });
                            }
                        },
                        error: function (xhr, stattus, error) {
                            if (xhr.status === 500) {
                                Swal.fire({
                                    title: "Ops !!",
                                    text: 'Something went wrong.',
                                    icon: "error",
                                    confirmButtonText: "Ok"
                                });
                            }
                            console.error(xhr + "\n" + stattus + "\n" + error)
                        }
                    });
                }
            });
        } else {
            Swal.fire({
                title: "Ops..!",
                text: 'Tidak Ada Item Yang dipilih',
                icon: "error"
            });
        }
    });

    $(document).on('click', '.btnDetail', function () {
        $('#detailBarang').modal('show');
        AjaxGetData('/barang/' + $(this).attr('id'), function (response) {
            if (response.status === 200) {
                const data = response.data;
                $('#txt_code_barang').text(data.code_barang);
                $('#txt_nama_barang').text(data.nama_barang);
                $('#txt_kategori').html(data.kategori ? data.kategori.nama_kategori_barang : '<strong style="color:red;">not found</strong>');
                $('#photo').attr('src', data.photo);
                $('#txt_merek').html(data.merek ? data.merek.merk : '<strong style="color:red;">not found</strong>');
                $('#txt_pemasok').html(data.pemasok ? data.pemasok.nama : '<strong style="color:red;">not found</strong>');
                $('#txt_tgl_masuk').text(dateCutomFormat(data.tanggal_masuk));
                $('#txt_jumlah').text(data.quantity);
                $('#txt_posisi').text(data.posisi);
                $('#txt_deskripsi').text(data.deskripsi);
            }
        });
    });

    $(document).on('click', '#scan_kode', function () {
        const qrReader = document.getElementById('qr-reader');
        const kodeBarangInput = document.getElementById('kode_barang');

        function onScanSuccess(decodedText, decodedResult) {
            // Ketika kode barang ditemukan
            kodeBarangInput.value = decodedText;
            // Hentikan pemindaian dan sembunyikan pemindai
            html5QrcodeScanner.clear();
            qrReader.style.display = 'none';
            $('#modal_scan_kode').modal('hide');
        }

        html5QrcodeScanner = new Html5QrcodeScanner(
            "qr-reader", { fps: 10, qrbox: 250 }
        );

        html5QrcodeScanner.render(onScanSuccess);
        qrReader.style.display = 'block';
        $('#modal_scan_kode').modal('show');
    });

    // Event listener untuk menutup modal dan menghentikan pemindaian
    document.getElementById('modal_scan_kode').addEventListener('hidden.bs.modal', function () {
        if (html5QrcodeScanner) {
            html5QrcodeScanner.clear();
        }
        document.getElementById('qr-reader').style.display = 'none';
    });
});