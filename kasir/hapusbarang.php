<?php
    include('koneksi.php');

    $namabar = $_GET['nama_produk'];

    $hapus = mysqli_query($koneksi, "DELETE FROM tbl_barang WHERE nama_barang='$namabar'");

    if($hapus) {
        echo "Data berhasil dihapus! <br>";
    } else {
        echo "Gagal menghapus data: ";
    }

    echo "<br><a href='produk.php'>Kembali</a>";

    mysqli_close($koneksi);
?>
 