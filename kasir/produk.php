<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Produk - Santoso Jaya Teknik</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            margin: 0;
            padding: 0; 
        }
       /* Navbar */
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
        .produk{
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
            color: white; padding: 10px; 
            border: none; 
            cursor: pointer; 
            margin-right: 10px; 
        }
        button:hover { 
            background-color: #333; 
        }
        /* Responsive */
        @media (max-width: 480px) {
            .navbar h1 {
                font-size: 1.2em;
            }
            .navbar ul {
                flex-direction: row;
                width: 100%;
                text-align: center;
            }
            .navbar ul li {
                margin: 5px 10;
            }
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
            position: relative;
            width: 90%;
            padding: 15px;
            margin: 20px 0;
            border-left: 2px solid #ccc; /* Contoh: garis abu-abu setebal 2px */
            padding-left: 40px; 
            font-size: 20px;
        }
    </style>
</head>
<body>
    <!-- KONTEN -->
    <nav class="navbar">
        <!-- NAVBAR -->
        <h1>Depot Ko Bagio</h1>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="transaksi.php">Transaksi</a></li>
            <li><a href="laporan.php">Laporan</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
    <div class="produk">
        <h2>Produk</h2>
        <!-- TOMBOL POPUP -->
        <button onclick="bukaPopup()">Tambah Produk</button>
        <div class="overlay" id="overlay" onclick="tutupPopup()"></div>
        <!-- POPUP -->
            <div class="popup" id="popup">
                <center>
                    <h3 id="popup-title">Tambah Produk</h3>
                    <form method="POST" action="simpandatabarang.php">
                        <input type="hidden" name="id" id="id">
                        <label>Nama Produk:</label><br>
                        <input type="text" name="nama_produk" id="nama_produk" required><br>
                        <label>Harga:</label><br>
                        <input type="number" name="harga" id="harga" required><br>
                        <label>Stok:</label><br>
                        <input type="number" name="stok" id="stok" required><br><br>
                        <button type="submit" name="simpan">Simpan</button>
                        <button type="button" onclick="tutupPopup()">Batal</button>
                    </form>
                </center>
            </div>
    </div>
    <!-- TABEL BARANG -->
    <!-- <table>
    <tr>
        <th>ID</th>
        <th>Nama Produk</th>
        <th>Harga</th>
        <th>Stok</th>
        <th>Aksi</th>
    </tr>
</table> -->
<!-- SCRIPT -->
    <script>
        function bukaPopup() {
            document.getElementById('popup-title').innerText = 'Tambah Produk';
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
    </script>

    <!-- PHP -->
    <?php
    include('koneksi.php');

    $tampil = mysqli_query($koneksi, "SELECT * FROM tbl_barang");

    echo "<table border='1'>
            <tr>
                <td><b>Nama Produk</b></td>
                <td><b>Harga</b></td>
                <td><b>Stok</b></td>
                <td><b>Aksi</b></td>
            </tr>";
    
    while ($data = mysqli_fetch_array($tampil)) {
        echo "<tr>
                <td>{$data['nama_barang']}</td>
                <td>{$data['harga_barang']}</td>
                <td>{$data['stok']}</td>
                <td>
                    <a href='hapusbarang.php?nama_produk={$data['nama_barang']}'>Hapus</a>
                    <a href='editbarang.php?nama_produk={$data['nama_barang']}'>Edit</a>
                </td>
              </tr>";
    }
    
    echo "</table>";
?>
</body>
</html>