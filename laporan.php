<?php
    session_start();
    if(empty($_SESSION['username'])){
        header("location:adminlogin.php");
    };
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan - SJT</title>
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
            margin-top: 5%;
        }

        th, td {
            border: 1px solid #ccc;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #999;
        }

        .grand-total {
            margin-top: 20px;
            text-align: right;
            font-size: 1.2em;
            font-weight: bold;
        }
        button {
            padding: 10px 15px;
            background-color: #333;
            margin-top: 10px;
            color: #fff;
            border: none;
            cursor: pointer;
        }
        input[type="text"], input[type="date"], select {
            width: 20%;
            padding: 10px;
            margin: 5px;
            box-sizing: border-box;
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .cards {
                flex-direction: row;
                justify-content: center;
            }
            .card {
                width: 45%;
            }
        }

        @media (max-width: 768px) {
            .cards {
                flex-direction: column;
                align-items: center;
            }
            .card {
                width: 80%;
                margin: 10px auto;
            }
        }

        @media (max-width: 480px) {
            .card {
                width: 90%; /* Lebih lebar agar tidak terlalu ke kanan */
                margin: 10px auto; /* Tengah dengan margin auto */
            }
            .navbar h1 {
                font-size: 1.1em;
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
        <h1>SJT</h1>
        <ul>
            <li><a href="index.html">Dashboard</a></li>
            <li><a href="produk.php">Barang</a></li>
            <li><a href="transaksi.php">Transaksi</a></li>
            <li><a href="logout.php">Log Out</a></li>    
        </ul>
    </nav>

    <div class="container">
        <h2>Laporan Penjualan</h2>
        <label>Tanggal:</label>
        <input type="date" id="tanggalAwal">
        <span>sampai</span>
        <input type="date" id="tanggalAkhir">

        <button onclick="ambilLaporan()">Tampilkan Laporan</button>
        <table id="laporanTable">
            <thead>
                <tr>
                    <th>Tanggal</th>
                    <th>Nama Produk</th>
                    <th>QTY</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <!-- Data laporan akan dimuat di sini -->
            </tbody>
        </table>
        <div class="grand-total">
            <strong>Grand Total: </strong><span id="grandTotal">Rp 0.000</span>
        </div>
    </div>

    <script>
        function ambilLaporan() {
            let tanggalAwal = document.getElementById("tanggalAwal").value;
            let tanggalAkhir = document.getElementById("tanggalAkhir").value;

            if (!tanggalAwal || !tanggalAkhir) {
                alert("Silakan pilih rentang tanggal terlebih dahulu.");
                return;
            }

            fetch("get_laporan.php", {
                method: "POST",
                headers: { "Content-Type": "application/json" },
                body: JSON.stringify({ tanggalAwal, tanggalAkhir })
            })
            .then(response => response.json())
            .then(data => {
                let tbody = document.getElementById("laporanTable").getElementsByTagName("tbody")[0];
                let grandTotalElement = document.getElementById("grandTotal");
                tbody.innerHTML = "";

                if (data.laporan.length === 0) {
                    tbody.innerHTML = "<tr><td colspan='4'>Tidak ada data untuk rentang tanggal yang dipilih.</td></tr>";
                    grandTotalElement.innerText = "Rp 0";
                    return;
                }

                let grandTotal = 0;

                data.laporan.forEach(item => {
                    grandTotal += parseInt(item.total);
                    tbody.innerHTML += `<tr>
                        <td>${item.tgl}</td>
                        <td>${item.nama_barang}</td>
                        <td>${item.qty}</td>
                        <td>Rp ${parseInt(item.total).toLocaleString()}</td>
                    </tr>`;
                });

                grandTotalElement.innerText = `Rp ${grandTotal.toLocaleString()}`;
            })
            .catch(error => console.error("Error:", error));
        }
    </script>

</body>
</html>
