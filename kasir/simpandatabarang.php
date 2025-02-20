<?php
	include('koneksi.php');

	$a = $_POST['nama_produk'];
	$b = $_POST['harga'];
	$c = $_POST['stok'];
	$query = mysqli_query($koneksi,"INSERT INTO tbl_barang(nama_barang,harga_barang,stok) VALUES ('$a','$b','$c')");

	if($query){
		echo "<br>Data berhasil disimpan! <br>
		<a href='produk.php'>Kembali</a> <br>";
	}else{
		echo "<br>Gagal menyimpan data! <br>
		<a href='produk.php'>Kembali</a>";
	}

	mysqli_close($koneksi);
?>