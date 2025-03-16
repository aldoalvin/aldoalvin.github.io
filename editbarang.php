<?php
// Koneksi ke database
include('koneksi.php');

// Cek apakah request method adalah POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Ambil data dari form
    $nama_produk = $_POST['nama_produk'];
    $harga_beli = $_POST['hargabeli'];
    $harga_jual = $_POST['hargajual'];
    $stok = $_POST['stok'];

    // Validasi data (pastikan data tidak kosong)
    if (empty($nama_produk) || empty($harga_beli) || empty($harga_jual) || empty($stok)) {
        echo "Semua field harus diisi!";
        exit;
    }

    // Hitung keuntungan
    $keuntungan = $harga_jual - $harga_beli;

    // Query untuk update data
    $query = "UPDATE tbl_barang 
              SET harga_beli = '$harga_beli', 
                  harga_jual = '$harga_jual', 
                  stok = '$stok', 
                  untung = '$keuntungan' 
              WHERE nama_barang = '$nama_produk'";

    // Eksekusi query
    if (mysqli_query($koneksi, $query)) {
        // Jika update berhasil, redirect ke halaman produk dengan status sukses
        header("Location: produk.php?status=updated");
        exit;
    } else {
        // Jika update gagal, redirect ke halaman produk dengan status gagal
        header("Location: produk.php?status=update_failed");
        exit;
    }
} else {
    // Jika request method bukan POST, redirect ke halaman produk
    header("Location: produk.php");
    exit;
}
?>