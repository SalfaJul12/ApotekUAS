<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Laporan</title>
    <link rel="stylesheet" href="assets/css/laporan.css">
</head>
<body>
<?php
include './connection.php';

$months = array('January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
$year = date('Y');

if (isset($_GET['month']) && isset($_GET['year'])) {
    $month = $_GET['month'];
    $year = $_GET['year'];

    $query = "SELECT * FROM laporan_transaksi 
          WHERE MONTH(created_at) = $month 
          AND YEAR(created_at) = $year";

    $result = $conn->query($query);
} else {
    $result = null; 
}
?>
    <div class="container">
        <h2>Data Laporan</h2>
        <form method="GET" action="">
            <p>
                <select name="month" required>
                    <option value="">Month</option>
                    <?php for ($m = 1; $m <= 12; $m++) { ?>
                        <option value="<?= $m ?>" <?= (isset($_GET['month']) && $_GET['month'] == $m) ? 'selected' : '' ?>>
                            <?= $months[$m - 1] ?>
                        </option>
                    <?php } ?>
                </select>
                <select name="year" required>
                    <option value="">Year</option>
                    <?php for ($y = 0; $y < 3; $y++) { ?>
                        <option value="<?= $year - $y ?>" <?= (isset($_GET['year']) && $_GET['year'] == $year - $y) ? 'selected' : '' ?>>
                            <?= $year - $y ?>
                        </option>
                    <?php } ?>
                </select>
                <input type="submit" value="Cari">
            </p>
        </form>

        <div class="tabel-data">
            <div class="table_container">
                <table>
                    <tr>
                        <th>No</th>
                        <th>Nama Customer</th>
                        <th>Obat yang Dibeli</th>
                        <th>Jumlah Obat</th>
                        <th>Tipe Obat</th>
                        <th>Tanggal Pembelian</th>
                        <th>Total Penjualan Obat</th>
                        <th>Action</th>
                    </tr>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php $no = 1; ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?= $no++ ?></td>
                                <td><?= $row['nama_customer'] ?></td>
                                <td><?= $row['nama_obat'] ?></td>
                                <td><?= $row['jumlah_obat'] ?></td>
                                <td><?= $row['tipe_obat'] ?></td>
                                <td><?= $row['created_at'] ?></td>
                                <td>Rp<?= number_format($row['total_harga'], 2) ?></td>
                                <td><a href="delete_transaksi.php?id=<?= $row['id_transaksi'] ?>">Print</a></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="8">Tidak ada data untuk bulan dan tahun ini.</td>
                        </tr>
                    <?php endif; ?>
                </table>
            </div>
        </div>
    </div>
</body>
<style>
.table_container {
    max-height: 330px;
    overflow-y: auto;
    border: 1px solid #ddd;
}

table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    border: 1px solid #ddd;
    padding: 8px;
    text-align: left;
}

th {
    position: sticky;
    top: 0;
    z-index: 2;
}
</style>
</html>
