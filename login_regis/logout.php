<?php
session_start();
include '../connection.php';

$users_id = $_SESSION['users_id'];

// Cek apakah ada cart untuk pengguna ini
if (isset($_SESSION['cart'][$users_id])) {
    foreach ($_SESSION['cart'][$users_id] as $id_obat => $item) {
        $jumlah_obat = $item['jumlah'];

        $query = "UPDATE obat SET stock = stock + ? WHERE id_obat = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $jumlah_obat, $id_obat);
        $stmt->execute();
    }

    // Hapus cart dari session
    unset($_SESSION['cart'][$users_id]);
}

// Hapus user_id dari session
unset($_SESSION['users_id']);
session_destroy();

// Redirect ke halaman login
header('Location: login-form.php');
exit;
?>