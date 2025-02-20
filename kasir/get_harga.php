<?php
    $koneksi = mysqli_connect('localhost','root','','sjt');
    $nama_barang = $_POST['nama_barang'];

    $query = mysqli_query($koneksi, "SELECT harga_barang FROM tbl_barang WHERE nama_barang = '$nama_barang'");
    $data = mysqli_fetch_array($query);

    echo $data['harga_barang'];
?>