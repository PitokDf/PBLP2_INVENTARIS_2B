$(document).on('click', '#activity-log', function () {
    $('#modalActivity').modal('show');
    document.getElementById("activity-content").innerHTML = "";
    $.ajax({
        type: "get",
        url: "activity",
        dataType: "json",
        success: function (response) {
            if (response.length == 0) {
                document.getElementById("activity-content").innerHTML = `<h2 class="h2">Belum ada log activity!</h2>`
            }
            for (let i = 0; i < response.length; i++) {
                if (response[i].activity == 'delete') {
                    document.getElementById("activity-content").innerHTML +=
                        `<a class="dropdown-item d-flex align-items-center mb-2" href="#">
                        <div class="mr-3">
                            <div class="icon-circle bg-danger">
                                <i class="fas fa-trash-alt text-white"></i>
                            </div>
                        </div>
                        <div>
                            <div class="small text-gray-500">${response[i].time}</div>
                            ${response[i].user.name} ${response[i].deskripsi}
                        </div>
                    </a>
                    <hr>`
                } else if (response[i].activity == 'add') {
                    document.getElementById("activity-content").innerHTML +=
                        `<a class="dropdown-item d-flex align-items-center mb-2" href="#">
                            <div class="mr-3">
                                <div class="icon-circle bg-success">
                                <i class="fas fa-plus-circle text-white"></i>
                                </div>
                            </div>
                            <div>
                                <div class="small text-gray-500">${response[i].time}</div>
                                ${response[i].user.name} ${response[i].deskripsi}
                            </div>
                        </a>`
                } else if (response[i].activity == 'Login') {
                    document.getElementById("activity-content").innerHTML +=
                        `<a class="dropdown-item d-flex align-items-center mb-2" href="#">
                            <div class="mr-3">
                                <div class="icon-circle bg-info">
                                    <i class="fas fa-sign-in-alt text-white"></i>
                                </div>
                            </div>
                            <div>
                                <div class="small text-gray-500">${response[i].time}</div>
                                ${response[i].user.name} ${response[i].deskripsi}
                            </div>
                        </a>`
                } else {
                    document.getElementById("activity-content").innerHTML +=
                        `<a class="dropdown-item d-flex align-items-center mb-2" href="#">
                            <div class="mr-3">
                                <div class="icon-circle bg-warning">
                                    <i class="fas fa-pencil-alt text-white"></i>
                                </div>
                            </div>
                            <div>
                                <div class="small text-gray-500">${response[i].time}</div>
                                ${response[i].user.name} ${response[i].deskripsi}
                            </div>
                        </a>`
                }
            }
        }
    });
});
