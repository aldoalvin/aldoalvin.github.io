<?php

    include('koneksi.php');

        $namabar = $_GET['nama_produk'];

        // Ambil data barang berdasarkan kode barang
        $query = mysqli_query($koneksi, "SELECT * FROM tbl_barang WHERE nama_barang='$namabar'");
        $data = mysqli_fetch_array($query);
        $harga = $data['harga_barang'];
        $stok = $data['stok'];

    // Proses update data setelah form disubmit
    if ($_POST) {
        $harga_baru = $_POST['harga'];
        $stok_baru = $_POST['stok'];

        // Query untuk update data barang
        $update_query = mysqli_query($koneksi,"UPDATE tbl_barang SET harga_barang='$harga_baru', stok='$stok_baru' WHERE nama_barang='$namabar'");

        if($update_query){
            echo "Data berhasil diupdate! <br>
            <a href='produk.php'>Kembali</a>";
            exit;
        } else {
            echo "Gagal mengupdate data".mysqli_error($koneksi);
        }
    }

    mysqli_close($koneksi);
?>

<html>
    <body>
        <h2>Edit Barang</h2>
        <form method="POST" action="">
            Nama Barang: <input type="text" name="namabarang" value="<?php echo $namabar; ?>"><br>
            Harga: <input type="text" name="harga" value="<?php echo $harga; ?>"><br>
            Stok: <input type="text" name="stok" value="<?php echo $stok; ?>"><br>
            <input type="submit" name="update" value="Update">
        </form>
        <br>
        <a href='produk.php'>Kembali</a>
    </body>
</html>
