<?php
	 $a = $_POST['namaBarang'];
	 $b = $_POST['hargaBarang'];
	 $c = $_POST['jumlah'];
	 $d = $_POST['total'];

	 $koneksi = mysqli_connect('localhost','root','','sjt');

	 $query = mysqli_query($koneksi,"insert into tbl_laporan(nama_barang,harga_barang,qty,total) values ('$a','$b','$c','$d')");

	 if($query){
	 	echo "Data berhasil disimpan! <br>
	 			<a href='transaksi.php'> Kembali </a>";
	 }else{
	 	echo "Gagal simpan data!".mysqli_error($query);
	 }

	 mysqli_close($koneksi);
	
?>