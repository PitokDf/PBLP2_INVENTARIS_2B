$(document).ready(function () {

    var ctx = document.getElementById('topThreeBarang').getContext('2d');
    var ctx2 = document.getElementById('resume').getContext('2d');
    var labels = '';
    var quantities = '';

    function prosesData(response) {
        const data = response.data;
        labels = data.map(item => item.nama_barang);
        quantities = data.map(item => item.quantity);

        var ctx = document.getElementById('topThreeBarang').getContext('2d');
        var myPieChart = new Chart(ctx, {
            type: 'pie',
            data: {
                labels: labels,
                datasets: [{
                    data: quantities,
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)'
                    ],
                    borderWidth: 1
                }]
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 10,
                    yPadding: 15,
                    displayColors: true,
                    caretPadding: 10,
                },
                legend: {
                    display: false
                },
                hoverOffset: 15,
                cutoutPercentage: 80,
            },
        });
        var myAreaChart = new Chart(ctx2, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    data: quantities,
                    backgroundColor: 'rgba(78, 115, 223, 0.05)', // Warna latar belakang area
                    borderColor: 'rgba(78, 115, 223, 1)', // Warna garis batas area
                    borderWidth: 2 // Lebar garis batas area
                }]
            },
            options: {
                maintainAspectRatio: false,
                tooltips: {
                    backgroundColor: "rgb(255,255,255)",
                    bodyFontColor: "#858796",
                    borderColor: '#dddfeb',
                    borderWidth: 1,
                    xPadding: 15,
                    yPadding: 15,
                    displayColors: false, // Menyembunyikan warna pada tooltip
                    caretPadding: 10,
                },
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            display: false, // Menyembunyikan garis grid pada sumbu x
                        },
                        ticks: {
                            maxTicksLimit: 7 // Jumlah maksimum tanda sumbu x
                        }
                    }],
                    yAxes: [{
                        gridLines: {
                            color: "rgb(234, 236, 244)",
                            zeroLineColor: "rgb(234, 236, 244)",
                            drawBorder: false,
                            borderDash: [2],
                            zeroLineBorderDash: [2]
                        },
                        ticks: {
                            maxTicksLimit: 5, // Jumlah maksimum tanda sumbu y
                            padding: 10
                        },
                    }],
                },
                hover: {
                    mode: 'nearest',
                    intersect: false
                },
                tooltips: {
                    mode: 'index',
                    intersect: false
                }
            }
        });


    }
    $.ajax({
        type: "get",
        url: "topThreeBarang",
        dataType: "json",
        success: prosesData
    });
});