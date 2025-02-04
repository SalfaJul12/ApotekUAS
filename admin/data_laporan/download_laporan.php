<?php
include '../../connection.php';

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Kuitansi_Apotek_Bersama.xls");

if (isset($_GET['month']) && isset($_GET['year'])) {
    $month = $_GET['month'];
    $year = $_GET['year'];

    $query = "SELECT * FROM laporan_transaksi 
              WHERE MONTH(created_at) = $month 
              AND YEAR(created_at) = $year";

    $result = $conn->query($query);
} else {
    die("Bulan dan tahun tidak valid.");
}
?>

<table border="1">
    <tr>
        <th>No</th>
        <th>Nama Customer</th>
        <th>Obat yang Dibeli</th>
        <th>Jumlah Obat</th>
        <th>Tipe Obat</th>
        <th>Tanggal Pembelian</th>
        <th>Harga Obat Persatu</th>
        <th>Total Penjualan Obat</th>
    </tr>
    <?php $no = 1; ?>
    <?php while ($row = $result->fetch_assoc()): ?>
        <tr>
            <td><?= $no++ ?></td>
            <td><?= $row['nama_customer'] ?></td>
            <td><?= $row['nama_obat'] ?></td>
            <td><?= $row['jumlah_obat'] ?></td>
            <td><?= $row['tipe_obat'] ?></td>
            <td><?= $row['created_at'] ?></td>
            <td>Rp <?= number_format($row['total_harga_sebelum'], 2) ?></td>
        </tr>
    <?php endwhile; ?>
</table>
