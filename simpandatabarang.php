<?php
include('koneksi.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $a = $_POST['nama_produk'];
    $b = $_POST['hargabeli'];
    $c = $_POST['hargajual'];
    $d = $_POST['stok'];
    $e = $c - $b; // Hitung keuntungan

    // Query untuk insert data
    $query = mysqli_query($koneksi, "INSERT INTO tbl_barang (nama_barang, harga_beli, harga_jual, stok, untung) VALUES ('$a', '$b', '$c', '$d', '$e')");

    if ($query) {
        header('Location: produk.php?status=success'); // Redirect dengan status sukses
        exit();
    } else {
        header('Location: produk.php?status=error'); // Redirect dengan status gagal
        exit();
    }
}

mysqli_close($koneksi);
?>
