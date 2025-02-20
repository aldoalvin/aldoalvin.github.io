<?php
session_start();
include 'koneksi.php'; // Pastikan file koneksi ada

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = mysqli_real_escape_string($koneksi, $_POST['username']);
    $password = mysqli_real_escape_string($koneksi, $_POST['password']);

    // Ambil data user dari database
    $query = "SELECT * FROM tbl_user WHERE username='$username'";
    $result = mysqli_query($koneksi, $query);
    $row = mysqli_fetch_assoc($result);

    if ($row) {
        // Jika password menggunakan password_hash()
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $row['role']; // Jika ada role
            header("Location: dashboard.php");
            exit();
        } else {
            echo "<script>alert('Username atau password salah!'); window.location='index.php';</script>";
        }
    } else {
        echo "<script>alert('Username atau password salah!'); window.location='index.php';</script>";
    }
}
?>
