<?php
    include('koneksi.php');
    $data = json_decode(file_get_contents("php://input"), true);

    $jenisLaporan = $data['jenisLaporan'];
    $tanggal = $data['tanggal'] ?? '';
    $tanggalAwal = $data['tanggalAwal'] ?? '';
    $tanggalAkhir = $data['tanggalAkhir'] ?? '';
    $bulan = $data['bulan'] ?? '';

    $query = "";

    if ($jenisLaporan == "harian") {
        $query = "SELECT * FROM tbl_laporan WHERE tgl = '$tanggal'";
    } elseif ($jenisLaporan == "mingguan") {
        $query = "SELECT * FROM tbl_laporan WHERE tgl BETWEEN '$tanggalAwal' AND '$tanggalAkhir'";
    } elseif ($jenisLaporan == "bulanan") {
        $query = "SELECT * FROM tbl_laporan WHERE MONTH(tgl) = MONTH('$bulan') AND YEAR(tgl) = YEAR('$bulan')";
    } elseif ($jenisLaporan == "tahunan") {
        $tahun = date("Y");
        $query = "SELECT * FROM tbl_laporan WHERE YEAR(tgl) = '$tahun'";
    }

    $result = mysqli_query($koneksi, $query);
    $dataLaporan = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $dataLaporan[] = $row;
    }

    echo json_encode($dataLaporan);
    mysqli_close($koneksi);
?>
