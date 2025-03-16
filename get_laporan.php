<?php
include('koneksi.php');

$data = json_decode(file_get_contents("php://input"), true);

$tanggalAwal = $data['tanggalAwal'] ?? '';
$tanggalAkhir = $data['tanggalAkhir'] ?? '';

if (!$tanggalAwal || !$tanggalAkhir) {
    echo json_encode(["error" => "Tanggal tidak valid"]);
    exit();
}

$query = "SELECT tgl, nama_barang, qty, total FROM tbl_laporan WHERE tgl BETWEEN '$tanggalAwal' AND '$tanggalAkhir'";
$result = mysqli_query($koneksi, $query);

$dataLaporan = [];
while ($row = mysqli_fetch_assoc($result)) {
    $dataLaporan[] = $row;
}

// Hitung total keseluruhan
$queryTotal = "SELECT SUM(total) AS grandTotal FROM tbl_laporan WHERE tgl BETWEEN '$tanggalAwal' AND '$tanggalAkhir'";
$resultTotal = mysqli_query($koneksi, $queryTotal);
$rowTotal = mysqli_fetch_assoc($resultTotal);
$grandTotal = $rowTotal['grandTotal'] ?? 0;

echo json_encode(["laporan" => $dataLaporan, "grandTotal" => $grandTotal]);

mysqli_close($koneksi);
?>
