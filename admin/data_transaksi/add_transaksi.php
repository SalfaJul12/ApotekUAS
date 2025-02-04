<?php
session_start();
include '../../connection.php';

if (isset($_POST['save'])) {
    $nama_customer = $_POST['nama_customer'];
    $nama_obat = $_POST['nama_obat'];
    $tipe_obat = $_POST['tipe_obat'];
    $jumlah_obat = $_POST['jumlah_obat'];
    $harga_obat = $_POST['harga_obat'];
    $total_harga = $jumlah_obat * $harga_obat;

    $query_check_stock = "SELECT stock FROM obat WHERE nama_obat = '$nama_obat'";
    $result_stock = $conn->query($query_check_stock);
    $row_stock = $result_stock->fetch_assoc();

    if ($row_stock && $row_stock['stock'] >= $jumlah_obat) {
        $query = "INSERT INTO transaksi (nama_customer, created_at, status_pembayaran) VALUES ('$nama_customer', NOW(), 'Belum Lunas')";
        if ($conn->query($query) === TRUE) {
            $transaksi_id = $conn->insert_id;

            $query_detail = "INSERT INTO detail_transaksi (id_transaksi, nama_obat, tipe_obat, jumlah_obat, harga_obat, total_harga) 
                             VALUES ('$transaksi_id', '$nama_obat', '$tipe_obat', '$jumlah_obat', '$harga_obat', '$total_harga')";

            $userid = $_SESSION['users_id'];
            $activity_query = "INSERT INTO log(users_id, aksi,created_at) VALUES ('$userid', 'Telah Menambahkan Transaksi', NOW())";
            $conn->query($activity_query);

            if ($conn->query($query_detail) === TRUE) {
                $query_update_stock = "UPDATE obat SET stock = stock - $jumlah_obat WHERE nama_obat = '$nama_obat'";
                $conn->query($query_update_stock);

                header("Location: ../../data_transaksi.php");
            } else {
                echo "Error: " . $query_detail . "<br>" . $conn->error;
            }
        } else {
            echo "Error: " . $query . "<br>" . $conn->error;
        }
    } else {
        echo "<script>alert('Jumlah obat tidak tersedia!'); window.history.back();</script>";
    }
}

?>
