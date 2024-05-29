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
                    setIconLog(response[i].time, response[i].user.username, `<i class="fas fa-trash-alt text-white"></i>`, response[i].deskripsi, 'bg-danger')
                } else if (response[i].activity == 'add') {
                    setIconLog(response[i].time, response[i].user.username, `<i class="fas fa-plus-circle text-white"></i>`, response[i].deskripsi, 'bg-success')
                } else if (response[i].activity == 'logout') {
                    setIconLog(response[i].time, response[i].user.username, `<i class="fas fa-sign-out-alt"></i>`, response[i].deskripsi, 'bg-warning')
                } else if (response[i].activity == 'Login') {
                    setIconLog(response[i].time, response[i].user.username, `<i class="fas fa-sign-in-alt text-white"></i>`, response[i].deskripsi, 'bg-success')
                } else {
                    setIconLog(response[i].time, response[i].user.username, `<i class="fas fa-pencil-alt text-white"></i>`, response[i].deskripsi, 'bg-warning')
                }
            }
        }
    });
});


function setIconLog(time, username, icon, deskripsi, background) {
    document.getElementById("activity-content").innerHTML +=
        `<a class="dropdown-item d-flex align-items-center mb-2" href="#">
            <div class="mr-3">
                <div class="icon-circle ${background}">
                    ${icon}
                </div>
            </div>
        <div>
            <div class="small text-gray-500">${time}</div>
            ${username} ${deskripsi}
        </div>
    </a>
    <hr>`
}