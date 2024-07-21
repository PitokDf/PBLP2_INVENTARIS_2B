<?php

function getFilesFromFolder($folderPath) {
    // Pastikan folder path yang diberikan valid
    if (!is_dir($folderPath)) {
        return [];
    }

    // Inisialisasi array buat nampung nama file
    $filesArray = [];

    // Scan folder dan dapetin list file dan folder di dalamnya
    $files = scandir($folderPath);

    // Looping tiap item yang ditemukan di folder
    foreach ($files as $file) {
        // Lewatin item yang namanya '.' atau '..'
        if ($file === '.' || $file === '..') {
            continue;
        }

        // Buat path lengkap dari item
        $fullPath = $folderPath . DIRECTORY_SEPARATOR . $file;

        // Cek kalo item tersebut adalah file, tambahin ke array
        if (is_file($fullPath)) {
            $filesArray[] = $file;
        }
    }

    return $filesArray;
}

// Contoh penggunaan
$folderPath = 'resources/js/';
$filesArray = getFilesFromFolder($folderPath);

// Print array nama file
print_r($filesArray);
?>
