import { reloadTable } from "./reloadTable";
$(document).ready(function () {
    $('#table_bug').DataTable({
        "processing": true,
        "paging": true,
        "searching": true,
        "responsive": true,
        "language": {
            "search": "cari"
        },
        "ajax": {
            "url": "get-data-report-bug",
            "type": "GET"
        },
        "columns": [{
            "data": null,
            "render": function (_data, _type, _row, meta) {
                return `<div class="card mt-2">
                    <div class="input-group mb-2">
                        <span class="input-group-text" id="basic-addon3">Bug ${meta.row + 1}</span>
                        <div class="form-control flex-grow-1 ">
                            <label for="basic-url">${_data.email} <span class="badge rounded-pill bg-primary text-white d-none d-lg-inline">${_data.role ?? 'Uknown'}</span></label>
                        </div>
                        <div class="form-control text-end">
                            ${_data.status === 0 ? '<label for="basic-url" style="color: #b4b4b4">Pending <i class="fas fa-clock text-warning"></i></label>' : '<label for="basic-url" style="color: #b4b4b4">Solved <i class="far fa-check-circle" style="color: #04ff00;"></i></label>'}
                        </div>
                    </div>
                    <div class="card-body">
                        <h5><b>${_data.tanggal_report}</b></h5>
                        <p class="card-text">${_data.description}</p>
                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            ${_data.status === 0 ? '<button type="button" class="btn btn-primary btn-sm me-md-1" data-id="' + _data.id + '" id="resolveBtn"><i class="fas fa-check"></i></button>' : ''}
                            <button type="button" class="btn btn-sm btn-warning" data-id="${_data.id}" id="deleteBtn"><i class="fas fa-trash-alt"></i></button>
                        </div>
                    </div>
                </div>`;
            }
        },]
    });

    $(document).on('click', '#deleteBtn', function () {
        Swal.fire({
            title: "Yakin ingin menghapus?",
            icon: "warning",
            text: "Yakin ingin menghapus record ini",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes"
        }).then((result) => {
            if (result.isConfirmed) {
                var url = 'report-bug/' + $(this).data('id');
                $.ajax({
                    type: "DELETE",
                    url: url,
                    dataType: "json",
                    success: function (response) {
                        Swal.fire({
                            title: "Deleted!",
                            text: response.message,
                            icon: "success"
                        });
                        reloadTable(table_bug);
                    },
                    error: function (xhr, stattus, error) {
                        console.error(xhr + "\n" + stattus + "\n" + error)
                    }
                });
            }
        });
    });
    $(document).on('click', '#resolveBtn', function () {
        Swal.fire({
            title: "Bug sudah diatasi?",
            icon: "question",
            text: "Developer sudah berhasil memperbaiki bug?",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Yes"
        }).then((result) => {
            if (result.isConfirmed) {
                var url = 'report-bug/' + $(this).data('id');
                $.ajax({
                    type: "PUT",
                    url: url,
                    dataType: "json",
                    success: function (response) {
                        Swal.fire({
                            title: "Resolved!",
                            text: response.message,
                            icon: "success"
                        });
                        reloadTable(table_bug);
                    },
                    error: function (xhr, stattus, error) {
                        console.error(xhr + "\n" + stattus + "\n" + error)
                    }
                });
            }
        });
    });
});