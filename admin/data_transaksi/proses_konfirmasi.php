<?php
include '../connection.php';

if (isset($_GET['id'])) {
    $transaksi_id = $_GET['id'];

    // Hapus transaksi dari database
    $query = "DELETE FROM transaksi WHERE id_transaksi = ?";
    $stmt = $conn->prepare($query);

    if ($stmt) {
        $stmt->bind_param("i", $transaksi_id);
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo "<script>alert('Transaksi telah dikonfirmasi.'); window.location.href='show_transaksi.php';</script>";
            } else {
                echo "<script>alert('Transaksi tidak ditemukan atau sudah dihapus.'); window.location.href='show_transaksi.php';</script>";
            }
        } else {
            echo "Error: " . $stmt->error; // Debugging
        }
    } else {
        echo "<script>alert('Terjadi kesalahan saat mempersiapkan query.'); window.location.href='show_transaksi.php';</script>";
    }
} else {
    echo "<script>alert('ID transaksi tidak ditemukan.'); window.location.href='show_transaksi.php';</script>";
}
?>