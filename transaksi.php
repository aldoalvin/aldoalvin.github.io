<?php
    session_start();
    if(empty($_SESSION['username'])){
        header("location:index.html");
    };
?>
<!DOCTYPE html>
<html>
<head>
    <title>Transaksi - SJT</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
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
        .container {
            width: 80%;
            margin: auto;
            margin-top: 2.5%;
            padding: 20px;
            background-color: #fff;
            border-radius: 5px;
            box-shadow: 0px 0px 5px 0px #888;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        input, select {
            width: 100%;
            padding: 8px;
            box-sizing: border-box;
        }

        button {
            padding: 10px 15px;
            background-color: #333;
            margin-top: 10px;
            color: #fff;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <h1>SJT</h1>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="produk.php">Barang</a></li>
            <li><a href="laporan.php">Laporan</a></li>
            <li><a href="logout.php">Log Out</a></li>
        </ul>
    </nav>

    <div class="container">
        <h2>Transaksi</h2>
        <form id="formTransaksi" method="POST">
            <label>Nama Barang:</label> <br>
            <select id="namaBarang">
                <option value="">Pilih Barang</option>
                <?php
                $koneksi = mysqli_connect('localhost', 'root', '', 'sjt');
                $tampil = mysqli_query($koneksi, "SELECT * FROM tbl_barang");

                while ($data = mysqli_fetch_array($tampil)) {
                    echo "<option value='" . $data['nama_barang'] . "'>" . $data['nama_barang'] . "</option>";
                }
                ?>
            </select> <br><br>

            <label>Harga:</label>
            <input type="number" id="hargaBarang" readonly>
            <br><br>

            <label>Jumlah:</label>
            <input type="number" id="jumlah">
            <br><br>

            <button type="button" onclick="tambahProduk()">Tambahkan</button>

            <h3>Keranjang Belanja</h3>
            <table>
                <thead>
                    <tr>
                        <th name="namaBarang">Nama Barang</th>
                        <th name="hargaBarang">Harga</th>
                        <th name="qty">Qty</th>
                        <th name="Total">Total</th>
                    </tr>
                </thead>
                <tbody id="keranjangBody">
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3"><strong>Total:</strong></td>
                        <td id="grandTotal">Rp 0</td>
                    </tr>
                </tfoot>
            </table>
            <button onclick="checkout()">Checkout</button>
        </form>
    </div>

    <script>
        document.getElementById("namaBarang").addEventListener("change", function () {
            let selectedBarang = this.value;
            if (!selectedBarang) {
                document.getElementById("hargaBarang").value = "";
                return;
            }

            fetch("get_harga.php", {
                method: "POST",
                headers: { "Content-Type": "application/x-www-form-urlencoded" },
                body: "nama_barang=" + encodeURIComponent(selectedBarang)
            })
            .then(response => response.text())
            .then(data => {
                document.getElementById("hargaBarang").value = data;
            });
        });

        let keranjang = [];

        function tambahProduk() {
            let namaBarang = document.getElementById("namaBarang").value;
            let hargaBarang = parseInt(document.getElementById("hargaBarang").value);
            let jumlah = parseInt(document.getElementById("jumlah").value);

            if (!namaBarang || isNaN(hargaBarang) || isNaN(jumlah) || jumlah <= 0) {
                alert("Harap masukkan data dengan benar!");
                return;
            }

            let total = hargaBarang * jumlah;
            keranjang.push({ nama: namaBarang, harga: hargaBarang, jumlah: jumlah, total: total });

            perbaruiKeranjang();
        }

        function perbaruiKeranjang() {
            let tabelBody = document.getElementById("keranjangBody");
            let grandTotal = 0;
            tabelBody.innerHTML = "";

            keranjang.forEach((item) => {
                grandTotal += item.total;
                tabelBody.innerHTML += `<tr>
                    <td>${item.nama}</td>
                    <td>Rp ${item.harga}</td>
                    <td>${item.jumlah}</td>
                    <td>Rp ${item.total}</td>
                </tr>`;
            });

            document.getElementById("grandTotal").innerText = `Rp ${grandTotal}`;
        }

        function checkout() {
            if (keranjang.length === 0) {
                alert("Keranjang masih kosong!");
                return;
            }

            fetch("checkout.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify(keranjang)
            })
            .then(response => response.text())
            .then(data => {
                alert(data);
                keranjang = []; // Kosongkan keranjang setelah checkout berhasil
                perbaruiKeranjang(); // Update tampilan
            })
            .catch(error => console.error("Error:", error));
        }

    </script>
</body>
</html>
