<?php
include '../../connection.php';

if (isset($_GET['id'])) {
    $id_transaksi = $_GET['id'];

    if (is_numeric($id_transaksi)) {
        // Periksa status pembayaran transaksi
        $query_transaksi = "SELECT status_pembayaran FROM transaksi WHERE id_transaksi = ?";
        $stmt_transaksi = mysqli_prepare($conn, $query_transaksi);
        mysqli_stmt_bind_param($stmt_transaksi, "i", $id_transaksi);
        mysqli_stmt_execute($stmt_transaksi);
        mysqli_stmt_bind_result($stmt_transaksi, $status_pembayaran);
        mysqli_stmt_fetch($stmt_transaksi);
        mysqli_stmt_close($stmt_transaksi);

        // Jika transaksi belum lunas, kembalikan stok obat
        if ($status_pembayaran != 'LUNAS') {
            // Ambil detail transaksi untuk memperbarui stok obat
            $query_detail = "SELECT nama_obat, jumlah_obat FROM detail_transaksi WHERE id_transaksi = ?";
            $stmt_detail = mysqli_prepare($conn, $query_detail);
            mysqli_stmt_bind_param($stmt_detail, "i", $id_transaksi);
            mysqli_stmt_execute($stmt_detail);
            $result_detail = mysqli_stmt_get_result($stmt_detail);

            // Loop untuk mengembalikan stok obat
            while ($row = mysqli_fetch_assoc($result_detail)) {
                $nama_obat = $row['nama_obat'];
                $jumlah_obat = $row['jumlah_obat'];

                // Ambil stok obat yang ada
                $query_stock = "SELECT stock FROM obat WHERE nama_obat = ?";
                $stmt_stock = mysqli_prepare($conn, $query_stock);
                mysqli_stmt_bind_param($stmt_stock, "s", $nama_obat);
                mysqli_stmt_execute($stmt_stock);
                mysqli_stmt_bind_result($stmt_stock, $current_stock);
                mysqli_stmt_fetch($stmt_stock);
                mysqli_stmt_close($stmt_stock);

                // Tambahkan jumlah obat ke stok
                $new_stock = $current_stock + $jumlah_obat;

                // Update stok obat
                $query_update_stock = "UPDATE obat SET stock = ? WHERE nama_obat = ?";
                $stmt_update_stock = mysqli_prepare($conn, $query_update_stock);
                mysqli_stmt_bind_param($stmt_update_stock, "is", $new_stock, $nama_obat);
                mysqli_stmt_execute($stmt_update_stock);
                mysqli_stmt_close($stmt_update_stock);
            }
            mysqli_stmt_close($stmt_detail);
        }

        // Hapus detail transaksi terlebih dahulu
        $query_detail_delete = "DELETE FROM detail_transaksi WHERE id_transaksi = ?";
        $stmt_detail_delete = mysqli_prepare($conn, $query_detail_delete);
        mysqli_stmt_bind_param($stmt_detail_delete, "i", $id_transaksi);
        mysqli_stmt_execute($stmt_detail_delete);
        mysqli_stmt_close($stmt_detail_delete);

        // Hapus transaksi utama
        $query_delete_transaksi = "DELETE FROM transaksi WHERE id_transaksi = ?";
        $stmt_delete_transaksi = mysqli_prepare($conn, $query_delete_transaksi);

        if ($stmt_delete_transaksi) {
            mysqli_stmt_bind_param($stmt_delete_transaksi, "i", $id_transaksi);

            if (mysqli_stmt_execute($stmt_delete_transaksi)) {
                // Tampilkan pesan jika transaksi berhasil dihapus
                echo "<script>alert('Transaksi berhasil dihapus!'); window.location.replace('../../data_transaksi.php');</script>";
            } else {
                echo "<script>alert('Gagal menghapus transaksi: " . mysqli_error($conn) . "'); window.location.replace('../../data_transaksi.php');</script>";
            }

            mysqli_stmt_close($stmt_delete_transaksi);
        } else {
            echo "<script>alert('Query error: " . mysqli_error($conn) . "'); window.location.replace('../../data_transaksi.php');</script>";
        }
    } else {
        echo "<script>alert('ID tidak valid.'); window.location.replace('../../data_transaksi.php');</script>";
    }
} else {
    echo "<script>alert('ID tidak ditemukan.'); window.location.replace('../../data_transaksi.php');</script>";
}

mysqli_close($conn);
?>
