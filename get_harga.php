<?php
$koneksi = mysqli_connect('localhost', 'root', '', 'sjt');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nama_barang = mysqli_real_escape_string($koneksi, $_POST['nama_barang']);
    $query = mysqli_query($koneksi, "SELECT harga_jual FROM tbl_barang WHERE nama_barang = '$nama_barang'");

    if ($data = mysqli_fetch_assoc($query)) {
        echo $data['harga_jual'];
    } else {
        echo "0";
    }
}
?>
