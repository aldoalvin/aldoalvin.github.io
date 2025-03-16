<?php
    session_start();
    if(empty($_SESSION['username'])){
        header("location:index.html");
    };

    // Notifikasi update
    if (isset($_GET['status'])) {
        $status = $_GET['status'];
        if ($status === 'updated') {
            echo "<script>alert('Data barang berhasil diupdate!');</script>";
        } else if ($status === 'update_failed') {
            echo "<script>alert('Gagal mengupdate data barang!');</script>";
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk - SJT</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }
        .navbar {
            background: #333;
            color: #fff;
            padding: 1rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
        }
        .navbar h1 {
            font-size: 1.5em;
        }
        .navbar ul {
            list-style: none;
            display: flex;
            padding: 0;
            margin: 0;
        }
        .navbar ul li {
            margin-left: 20px;
        }
        .navbar ul li a {
            color: white;
            text-decoration: none;
            transition: color 0.3s;
        }
        .navbar ul li a:hover {
            color: #f0a500;
        }
        .produk {
            margin: 20px;
        }
        table {
            position: relative;
            margin-left: 5%;
            width: 90%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
            padding: 10px;
            text-align: left;
        }
        button {
            background-color: #333;
            color: white;
            padding: 10px;
            border: none;
            cursor: pointer;
            margin-right: 10px;
        }
        button:hover {
            background-color: #555;
        }
        .popup {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 50%;
            padding: 30px;
            background-color: white;
            box-shadow: 0px 0px 10px gray;
            z-index: 10;
        }
        .overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 5;
        }
        .popup input {
            width: 90%;
            padding: 15px;
            margin: 20px 0;
            border: 2px solid #ccc;
            padding-left: 40px;
            font-size: 15px;
        }
        #searchBar {
            width: 15%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <h1>SJT</h1>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="transaksi.php">Transaksi</a></li>
            <li><a href="laporan.php">Laporan</a></li>
            <li><a href="logout.php">Log Out</a></li>
        </ul>
    </nav>

    <!-- Konten Produk -->
    <div class="produk">
        <h2>Barang</h2>
        <button onclick="bukaPopup()">Tambah Barang</button>
        <div class="overlay" id="overlay" onclick="tutupPopup()"></div>
        <!-- Popup Tambah Barang -->
        <div class="popup" id="popup">
            <center>
                <h3 id="popup-title">Tambah Barang</h3>
                <form method="POST" action="simpandatabarang.php" id="popup-form">
                    <input type="hidden" name="id" id="id">
                    <label>Nama Barang:</label><br>
                    <input type="text" name="nama_produk" id="nama_produk" required><br>
                    <label>Harga Beli:</label><br>
                    <input type="number" name="hargabeli" id="harga" required><br>
                    <label>Harga Jual:</label><br>
                    <input type="number" name="hargajual" id="hargajual" required><br>
                    <label>Stok:</label><br>
                    <input type="number" name="stok" id="stok" required><br><br>
                    <button type="submit" name="simpan">Simpan</button>
                    <button type="button" onclick="tutupPopup()">Batal</button>
                </form>
            </center>
        </div>
        <!-- Popup Edit Barang -->
        <div class="overlay" id="editOverlay" onclick="tutupEditPopup()"></div>
        <div class="popup" id="editPopup">
            <center>
                <h3 id="edit-popup-title">Edit Barang</h3>
                <form method="POST" action="editbarang.php" id="edit-popup-form">
                    <input type="hidden" name="nama_produk" id="edit_nama_produk">
                    <label>Nama Barang:</label><br>
                    <input type="text" id="edit_nama_produk_display" disabled><br>
                    <label>Harga Beli:</label><br>
                    <input type="number" name="hargabeli" id="edit_harga_beli" required><br>
                    <label>Harga Jual:</label><br>
                    <input type="number" name="hargajual" id="edit_harga_jual" required><br>
                    <label>Stok:</label><br>
                    <input type="number" name="stok" id="edit_stok" required><br><br>
                    <button type="submit" name="update">Update</button>
                    <button type="button" onclick="tutupEditPopup()">Batal</button>
                </form>
            </center>
        </div>
        <!-- Input Pencarian -->
        <input type="text" id="searchBar" onkeyup="cariBarang()" placeholder="Cari produk">
    </div>

    <!-- PHP untuk Menampilkan Data -->
    <?php
    include('koneksi.php');
    $tampil = mysqli_query($koneksi, "SELECT * FROM tbl_barang");
    echo "<table border='1' id='tabelProduk'>
            <tr>
                <td><b>Nama Produk</b></td>
                <td><b>Harga Beli</b></td>
                <td><b>Harga Jual</b></td>
                <td><b>Stok</b></td>
                <td><b>Keuntungan</b></td>
                <td><b>Aksi</b></td>
            </tr>";
    while ($data = mysqli_fetch_array($tampil)) {
        echo "<tr>
                <td>{$data['nama_barang']}</td>
                <td>{$data['harga_beli']}</td>
                <td>{$data['harga_jual']}</td>
                <td>{$data['stok']}</td>
                <td>{$data['untung']}</td>
                <td>
                    <a href='hapusbarang.php?nama_produk={$data['nama_barang']}'>Hapus</a>
                    <a href='#' onclick=\"bukaPopupEdit('{$data['nama_barang']}', '{$data['harga_beli']}', '{$data['harga_jual']}', '{$data['stok']}')\">Edit</a>
                </td>
              </tr>";
    }
    echo "</table>";
    ?>

    <!-- JavaScript -->
    <script>
        function bukaPopup() {
            document.getElementById('popup-title').innerText = 'Tambah Barang';
            document.getElementById('id').value = '';
            document.getElementById('nama_produk').value = '';
            document.getElementById('harga').value = '';
            document.getElementById('stok').value = '';
            document.getElementById('overlay').style.display = 'block';
            document.getElementById('popup').style.display = 'block';
        }

        function tutupPopup() {
            document.getElementById('overlay').style.display = 'none';
            document.getElementById('popup').style.display = 'none';
        }

        function bukaPopupEdit(nama, hargaBeli, hargaJual, stok) {
            document.getElementById('edit_nama_produk').value = nama;
            document.getElementById('edit_nama_produk_display').value = nama;
            document.getElementById('edit_harga_beli').value = hargaBeli;
            document.getElementById('edit_harga_jual').value = hargaJual;
            document.getElementById('edit_stok').value = stok;

            document.getElementById('editOverlay').style.display = 'block';
            document.getElementById('editPopup').style.display = 'block';
        }

        function tutupEditPopup() {
            document.getElementById('editOverlay').style.display = 'none';
            document.getElementById('editPopup').style.display = 'none';
        }

        function cariBarang() {
            let input = document.getElementById("searchBar").value.toLowerCase();
            let table = document.getElementById("tabelProduk");
            let rows = table.getElementsByTagName("tr");

            for (let i = 1; i < rows.length; i++) {
                let namaProduk = rows[i].getElementsByTagName("td")[0];
                if (namaProduk) {
                    let textValue = namaProduk.textContent || namaProduk.innerText;
                    if (textValue.toLowerCase().indexOf(input) > -1) {
                        rows[i].style.display = "";
                    } else {
                        rows[i].style.display = "none";
                    }
                }
            }
        }
    </script>
</body>
</html>
