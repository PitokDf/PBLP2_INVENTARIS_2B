$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

function formatRupiah(number) {
    // Use Intl.NumberFormat to format the number as currency
    let formattedNumber = new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR',
        minimumFractionDigits: 0
    }).format(number);

    // Replace the default currency formatting with custom formatting
    return formattedNumber.replace(/,00/, ',-');
}

function calculateDenda(tglBatasPengembalian, tglDikembalikan, dendaPerHari) {
    // Convert date strings to Date objects
    const batasPengembalian = new Date(tglBatasPengembalian);
    const dikembalikan = new Date(tglDikembalikan);

    // Calculate the difference in time
    const timeDifference = dikembalikan - batasPengembalian;

    // Calculate the difference in days
    const daysLate = Math.ceil(timeDifference / (1000 * 60 * 60 * 24));

    // Calculate the fine
    const denda = daysLate > 0 ? daysLate * dendaPerHari : 0;

    return denda;
}

function getCurrentDate() {
    // Create a new Date object for the current date and time
    const today = new Date();

    // Get the year, month, and day from the Date object
    const year = today.getFullYear();
    let month = today.getMonth() + 1; // Months are zero-based in JavaScript
    let day = today.getDate();

    // Add leading zeros to month and day if they are less than 10
    if (month < 10) {
        month = '0' + month;
    }
    if (day < 10) {
        day = '0' + day;
    }

    // Combine year, month, and day into the desired format
    const formattedDate = `${year}-${month}-${day}`;

    return formattedDate;
}

function dateCutomFormat(date) {
    let days = ['Minggu', 'Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'];
    let months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

    let dateFormat = new Date(date);
    return `${days[dateFormat.getDay()]}, ${dateFormat.getDate()} ${months[dateFormat.getMonth()]} ${dateFormat.getFullYear()}`;
}