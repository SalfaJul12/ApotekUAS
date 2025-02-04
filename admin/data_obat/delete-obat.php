<?php
    session_start();
    include "../../connection.php";
    if (isset($_GET['id'])) {
        $id_obat = $_GET['id'];

        // Pastikan ID adalah angka
        if (is_numeric($id_obat)) {
            // Query DELETE dengan prepared statement
            $query = "DELETE FROM obat WHERE id_obat = ?";
            $stmt = mysqli_prepare($conn, $query);

            $userid = $_SESSION['users_id'];
            $activity_query = "INSERT INTO log(users_id, aksi,created_at) VALUES ('$userid', 'Telah Menghapus Obat', NOW())";
            $conn->query($activity_query);

            if ($stmt) {
                // Bind parameter dan eksekusi
                mysqli_stmt_bind_param($stmt, "i", $id_obat);

                if (mysqli_stmt_execute($stmt)) {
                    echo "<script>alert('Obat berhasil dihapus!'); window.location.replace('../../data_obat.php');</script>";
                } else {
                    echo "<script>alert('Gagal menghapus obat.'); window.location.replace('../../data_obat.php');</script>";
                }

                // Menutup statement
                mysqli_stmt_close($stmt);
            } else {
                echo "<script>alert('Query error: " . mysqli_error($conn) . "'); window.location.replace('../../data_obat.php');</script>";
            }
        } else {
            echo "<script>alert('ID tidak valid.'); window.location.replace('../../data_obat.php');</script>";
        }
    } else {
        echo "<script>alert('ID tidak ditemukan.'); window.location.replace('../../data_obat.php');</script>";
    }

    // Menutup koneksi database
    mysqli_close($conn);
?>
