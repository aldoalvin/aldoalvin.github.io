<?php
// Koneksi ke database
$koneksi = mysqli_connect('localhost', 'root', '', 'sjt');

if (!$koneksi) {
    die("Koneksi gagal: " . mysqli_connect_error());
}

// Pastikan data diterima sebagai JSON
$dataJson = file_get_contents("php://input");
$items = json_decode($dataJson, true);

if (!$items || !is_array($items)) {
    die("Data tidak valid atau kosong!");
}

$tanggal = date("Y-m-d");

foreach ($items as $item) {
    $namaBarang = mysqli_real_escape_string($koneksi, $item['nama']);
    $hargaBarang = (int)$item['harga'];
    $qty = (int)$item['jumlah'];
    $total = (int)$item['total'];

    // Cek stok sebelum transaksi
    $cekStok = mysqli_query($koneksi, "SELECT stok FROM tbl_barang WHERE nama_barang = '$namaBarang'");
    $dataStok = mysqli_fetch_assoc($cekStok);

    if (!$dataStok) {
        die("Barang '$namaBarang' tidak ditemukan di database.");
    }

    if ($dataStok['stok'] < $qty) {
        die("Stok tidak cukup untuk '$namaBarang'! Stok tersedia: " . $dataStok['stok']);
    }

    // Simpan ke tabel laporan
    $queryInsert = "INSERT INTO tbl_laporan (tgl, nama_barang, harga_barang, qty, total) 
                    VALUES ('$tanggal', '$namaBarang', '$hargaBarang', '$qty', '$total')";

    if (!mysqli_query($koneksi, $queryInsert)) {
        die("Gagal menyimpan transaksi: " . mysqli_error($koneksi));
    }

    // Kurangi stok di tbl_barang
    $queryUpdate = "UPDATE tbl_barang SET stok = stok - $qty WHERE nama_barang = '$namaBarang'";

    if (!mysqli_query($koneksi, $queryUpdate)) {
        die("Gagal mengupdate stok: " . mysqli_error($koneksi));
    }
}

// Kirim respons sukses
echo "Checkout berhasil";

// Tutup koneksi
mysqli_close($koneksi);
?>
