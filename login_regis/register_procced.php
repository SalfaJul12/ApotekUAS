<?php
include '../connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
    $status = 'customer'; // Default status untuk pengguna baru

    // Cek apakah email atau username sudah digunakan
    $checkQuery = "SELECT * FROM users WHERE email = ? OR username = ?";
    $stmt = $conn->prepare($checkQuery);
    $stmt->bind_param('ss', $email, $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Email atau Username sudah digunakan!'); window.location.href='register.php';</script>";
        exit;
    }

    // Simpan data user baru ke database
    $insertQuery = "INSERT INTO users (username, email, password, status) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insertQuery);
    $stmt->bind_param('ssss', $username, $email, $password, $status);

    if ($stmt->execute()) {
        echo "<script>alert('Registrasi berhasil! Silakan login.'); window.location.href='login-form.php';</script>";
    } else {
        echo "<script>alert('Registrasi gagal! Coba lagi.'); window.location.href='register.php';</script>";
    }
}
