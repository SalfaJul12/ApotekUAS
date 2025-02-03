<?php
include '../../connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_transaksi = isset($_POST['id_transaksi']) ? intval($_POST['id_transaksi']) : 0;
    $nominal = isset($_POST['nominal']) ? floatval($_POST['nominal']) : 0;

    if ($id_transaksi <= 0 || $nominal <= 0) {
        die("ID transaksi atau nominal tidak valid.");
    }

    // Query untuk mengambil data total_harga dari detail_transaksi dan data dari transaksi
    $query = "SELECT t.id_transaksi, dt.total_harga 
              FROM transaksi t
              INNER JOIN detail_transaksi dt ON t.id_transaksi = dt.id_transaksi
              WHERE t.id_transaksi = ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id_transaksi);
    $stmt->execute();
    $result = $stmt->get_result();
    $transaksi = $result->fetch_assoc();

    if (!$transaksi) {
        die("Transaksi tidak ditemukan.");
    }

    $total_harga = floatval($transaksi['total_harga']);

    // Hitung sisa pembayaran baru
    $sisa_pembayaran_baru = max(0, $total_harga - $nominal);

    // Tentukan status pembayaran
    $status_pembayaran = ($sisa_pembayaran_baru <= 0) ? 'LUNAS' : 'BELUM LUNAS';

    // Update total_harga di detail_transaksi dengan nominal yang sudah dibayar
    $update_query = "UPDATE detail_transaksi SET total_harga = total_harga - ? WHERE id_transaksi = ?";
    $update_stmt = $conn->prepare($update_query);
    $update_stmt->bind_param("di", $nominal, $id_transaksi);
    $update_stmt->execute();

    // Update status pembayaran di tabel transaksi
    $update_status_query = "UPDATE transaksi SET status_pembayaran = ? WHERE id_transaksi = ?";
    $update_status_stmt = $conn->prepare($update_status_query);
    $update_status_stmt->bind_param("si", $status_pembayaran, $id_transaksi);
    $update_status_stmt->execute();

    if ($status_pembayaran === 'LUNAS') {
        // Cek apakah transaksi sudah ada di laporan
        $cek_laporan = "SELECT id_laporan FROM laporan_transaksi WHERE id_transaksi = ?";
        $stmt_cek = $conn->prepare($cek_laporan);
        $stmt_cek->bind_param("i", $id_transaksi);
        $stmt_cek->execute();
        $result_cek = $stmt_cek->get_result();
    
        // Jika belum ada, insert ke laporan
        if ($result_cek->num_rows == 0) {
            $insert_laporan = "INSERT INTO laporan_transaksi (id_transaksi, nama_customer, nama_obat, jumlah_obat, tipe_obat, total_harga, created_at, status_pembayaran)
                               SELECT t.id_transaksi, t.nama_customer, dt.nama_obat, dt.jumlah_obat, dt.tipe_obat, dt.total_harga, t.created_at, t.status_pembayaran
                               FROM transaksi t
                               JOIN detail_transaksi dt ON t.id_transaksi = dt.id_transaksi
                               WHERE t.id_transaksi = ?";
    
            $stmt_insert = $conn->prepare($insert_laporan);
            $stmt_insert->bind_param("i", $id_transaksi);
            $stmt_insert->execute();
        }
    }
    
    // Redirect kembali ke halaman transaksi
    header("Location: ../../data_transaksi.php");
    exit();
}
?>
