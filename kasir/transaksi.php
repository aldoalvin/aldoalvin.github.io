<!DOCTYPE html>
<html>
<head>
    <title>Santoso Jaya Teknik | Kasir</title>
    <form action="save_item.php" method="post"></form>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f4f4f4;
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

        th {
            background-color: #999;
        }

        input[type="text"], input[type="number"], select {
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
        /* Responsive */
        @media (max-width: 1024px) {
            .container {
                justify-content: center;
            }
            .produk-container {
                width: 45%;
            }
            .keranjang {
                width: 100%;
            }
        }

        @media (max-width: 768px) {
            .container {
                flex-direction: column;
                align-items: center;
            }
            .produk-container {
                width: 75%;
                margin: 10px auto;
            }
            .keranjang {
                width: 100%;
                margin: 10px auto;
            }
        }
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
    </style>
</head>
<body>
    <nav class="navbar">
        <h1>Depot Ko Bagio</h1>
        <ul>
            <li><a href="dashboard.php">Dashboard</a></li>
            <li><a href="produk.php">Produk</a></li>
            <li><a href="laporan.php">Laporan</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
    <div class="container">
        <h2>Depot Ko Bagio</h2>
        <div class="produk-container">
            <div class="produk">
                <label>Nama Barang:</label> <br>
                <select id="namaBarang">
                    <option value="">Pilih Barang</option>
                    <?php
                        $koneksi = mysqli_connect('localhost','root','','sjt');
                        $tampil = mysqli_query($koneksi, "SELECT * FROM tbl_barang");
                        while ($data = mysqli_fetch_array($tampil)){
                            echo "<option id='namaBarang' value=".$data['nama_barang'].">".$data['nama_barang']."</option>";
                        }
                    ?>
                </select> <br>
                <br>
                <label>Harga:</label>
                <input type="number" id="hargaBarang" readonly>
                <br>
                <label>Jumlah:</label>
                <input type="number" id="jumlah">
                <button onclick="tambahProduk()">Tambahkan</button>
            </div>
        </div>
        <div class="keranjang">
            <h3>Keranjang Belanja</h3>
            <table>
                <thead>
                    <tr>
                        <th name="namaBarang">Nama Barang</th>
                        <th name="hargaBarang">Harga</th>
                        <th name="jumlah">Jumlah</th>
                        <th name="total">Total</th>
                    </tr>
                </thead>
                <tbody id="keranjangBody">
                    <!-- Daftar item di keranjang -->
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3"><strong>Total:</strong></td>
                        <td id="grandTotal">Rp 0</td>
                    </tr>
                </tfoot>
            </table>
            <button onclick="checkout()" action="checkout.php">Checkout</button>
            <button onclick="bersihkanKeranjang()">Bersihkan Keranjang</button>
        </div>
    </div>

    <script>
        const namaBarang = document.getElementById('namaBarang');
        const hargaBarang = document.getElementById('hargaBarang');

        namaBarang.addEventListener('change', function() {
            const selectedBarang = this.value;

            // Kirim permintaan AJAX ke server
            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'get_harga.php', true); // Ganti 'get_harga.php' dengan path yang sesuai
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onload = function() {
                if (this.status === 200) {
                    hargaBarang.value = this.responseText;
                }
            };
            xhr.send('nama_barang=' + selectedBarang);
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

            keranjang.forEach((item, index) => {
                grandTotal += item.total;
                let row = `<tr>
                    <td>${item.nama}</td>
                    <td>Rp ${item.harga.toLocaleString()}</td>
                    <td>${item.jumlah}</td>
                    <td>Rp ${item.total.toLocaleString()}</td>
                </tr>`;
                tabelBody.innerHTML += row;
            });

            document.getElementById("grandTotal").innerText = `Rp ${grandTotal.toLocaleString()}`;
        }

        function hapusItem(index) {
            keranjang.splice(index, 1);
            perbaruiKeranjang();
        }

        function bersihkanKeranjang() {
            keranjang = [];
            perbaruiKeranjang();
        }
        function checkout() {
            if (keranjang.length === 0) {
                alert("Keranjang masih kosong!");
                return;
            }

            let data = {
                tanggal: new Date().toISOString().split('T')[0], // Format YYYY-MM-DD
                items: keranjang
            };

            let xhr = new XMLHttpRequest();
            xhr.open("POST", "checkout.php", true);
            xhr.setRequestHeader("Content-Type", "application/json");

            xhr.onload = function () {
                if (xhr.status === 200) {
                    alert("Checkout berhasil!");
                    bersihkanKeranjang();
                } else {
                    alert("Checkout gagal, coba lagi.");
                }
            };

            xhr.send(JSON.stringify(data));
        }
        fetch("checkout.php", {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify({
                tanggal: "2025-02-19",
                namaBarang: "Produk A",
                hargaBarang: 50000,
                qty: 2,
                total: 100000
            })
        })
        .then(response => response.json())
        .then(data => console.log(data))
        .catch(error => console.error("Error:", error));
    </script>
</body>
</html>
