// Pie Chart Example
$(document).ready(function () {
  $.ajax({
    type: "get",
    url: "topThreeBarang",
    dataType: "json",
    success: function (response) {
      const data = response.data;
      const labels = data.map(item => item.nama_barang);
      const quantities = data.map(item => item.quantity);

      var ctx = document.getElementById("myPieChart").getContext('2d');
      new Chart(ctx, {
        type: 'pie',
        data: {
          labels: labels,
          datasets: [{
            data: quantities,
            backgroundColor: ['#4e73df', '#1cc88a', '#36b9cc'],
            hoverBackgroundColor: ['#2e59d9', '#17a673', '#2c9faf'],
            hoverBorderColor: "rgba(234, 236, 244, 1)",
          }],
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
            displayColors: false,
            caretPadding: 10,
          },
          legend: {
            display: true
          },
          cutoutPercentage: 80,
        },
      });
    }
  });
});
