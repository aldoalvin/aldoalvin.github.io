<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Santoso Jaya Teknik</title>
    <style>
        /* Reset */
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background: #f4f4f9;
            transition: background 0.5s ease;
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

        /* Container */
        .container {
            padding: 2rem;
            text-align: center;
        }

        .cards {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1rem;
        }

        .card {
            background: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            flex: 1;
            min-width: 250px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .card.hover {
            transform: scale(1.05);
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.3);
        }

        .card h3 {
            color: #333;
            margin-bottom: 10px;
        }

        .card p {
            font-size: 1.5em;
            color: #444;
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
    <!-- Navbar -->
    <nav class="navbar">
        <h1>Depot Ko Bagio</h1>
        <ul>
            <li><a href="produk.php">Produk</a></li>
            <li><a href="transaksi.php">Transaksi</a></li>
            <li><a href="laporan.php">Laporan</a></li>
            <li><a href="logout.php">Logout</a></li>
        </ul>
    </nav>

    <!-- Container Dashboard -->
    <div class="container">
        <h2>Dashboard Penjualan</h2>
        <div class="cards">
            <div class="card" id="produk-card">
                <h3>Total Produk</h3>
                <?php
                    $k = mysqli_connect("localhost","root","","sjt");
                    $hasil = mysqli_query($k,"SELECT COUNT(nama_barang) AS jumlah_produk FROM tbl_barang GROUP BY nama_barang");
                    $banyak = mysqli_num_rows($hasil);
                    echo "<p id='total-produk'>$banyak</p>";
                ?>
            </div>
            <div class="card" id="pendapatan-card">
                <h3>Total Pendapatan</h3>
                <?php
                    $k = mysqli_connect("localhost", "root", "", "sjt");
                    $hasil = mysqli_query($k, "SELECT SUM(total) AS jumlah_pendapatan FROM tbl_laporan");
                    $data = mysqli_fetch_assoc($hasil);
                    $totalPendapatan = $data['jumlah_pendapatan'];
                    echo "<p id='total-pendapatan'>$totalPendapatan</p>";
                ?>
            </div>
            <div class="card" id="transaksi-card">
                <h3>Total Produk Terjual</h3>
                <?php
                    $k = mysqli_connect("localhost", "root", "", "sjt");
                    $hasil = mysqli_query($k, "SELECT SUM(qty) AS total FROM tbl_laporan");
                    $data = mysqli_fetch_assoc($hasil);
                    $totalTransaksi = $data['total'];
                    echo "<p id='total-transaksi'>$totalTransaksi</p>";
                ?>
            </div>
        </div>
    </div>

    <!-- Script untuk fetch data dan interaktivitas -->
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Fetch data dari data.php
            fetch('data.php')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('total-produk').textContent = data.totalProduk;
                    document.getElementById('total-pendapatan').textContent = 'Rp ' + data.totalPendapatan;
                    document.getElementById('total-transaksi').textContent = data.totalTransaksi;
                });

            // Animasi interaktif
            const cards = document.querySelectorAll('.card');
            cards.forEach(card => {
                card.addEventListener('mouseover', () => {
                    card.classList.add('hover');
                });
                card.addEventListener('mouseout', () => {
                    card.classList.remove('hover');
                });
            });
        });
    </script>
</body>
</html>
