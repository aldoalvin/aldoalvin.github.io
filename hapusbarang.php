<?php 
include('koneksi.php');

$namabar = $_GET['nama_produk'];

$hapus = mysqli_query($koneksi, "DELETE FROM tbl_barang WHERE nama_barang='$namabar'");

if ($hapus) {
    header('location:produk.php?status=deleted'); 
} else {
    header('location:produk.php?status=delete_failed'); 
}

mysqli_close($koneksi);
?>
