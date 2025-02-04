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
                <button><a href="admin/data_laporan/print_laporan.php">Download</a></button>   
            </p>
        </form>

        <div class="tabel-data">
            <div class="table_container" id="printArea">
                <table>
                    <tr>
                        <th>No</th>
                        <th>Nama Customer</th>
                        <th>Obat yang Dibeli</th>
                        <th>Jumlah Obat</th>
                        <th>Tipe Obat</th>
                        <th>Tanggal Pembelian</th>
                        <th>Harga Satuan</th>
                        <th>Nominal</th>
                        <th>Total Penjualan Obat</th>
                        <th>Action</th>
                    </tr>
                    <?php if ($result && $result->num_rows > 0): ?>
                        <?php $no = 1; ?>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr id="transaction-<?= $row['id_transaksi'] ?>">
                                <td><?= $no++ ?></td>
                                <td class="nama-customer"><?= $row['nama_customer'] ?></td>
                                <td class="nama-obat"><?= $row['nama_obat'] ?></td>
                                <td class="jumlah-obat"><?= $row['jumlah_obat'] ?></td>
                                <td class="tipe-obat"><?= $row['tipe_obat'] ?></td>
                                <td class="tanggal-pembelian"><?= $row['created_at'] ?></td>
                                <td class="total-harga"><?= $row['total_harga'] ?></td>
                                <td class="nominal">Rp<?= $row['nominal'] ?></td>
                                <td class="total-harga-sebelum">Rp <?= number_format($row['total_harga_sebelum'], 2) ?></td>
                                <td><button onclick="printTransaction(<?= $row['id_transaksi'] ?>)">Print</button></td>
                            </tr>
                        <?php endwhile; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="10">Tidak ada data untuk bulan dan tahun ini.</td>
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

<script>
    function printTransaction(id_transaksi) {
        console.log("Mencetak transaksi dengan ID: " + id_transaksi); // Pastikan ID transaksi tercetak

        // Mendapatkan baris data transaksi yang sesuai dengan ID
        var row = document.getElementById('transaction-' + id_transaksi);
        
        if (!row) {
            console.log("Baris transaksi tidak ditemukan!");
            return;
        }

        var nama_customer = row.querySelector('.nama-customer').innerText;
        var nama_obat = row.querySelector('.nama-obat').innerText;
        var jumlah_obat = row.querySelector('.jumlah-obat').innerText;
        var tipe_obat = row.querySelector('.tipe-obat').innerText;
        var tanggal_pembelian = row.querySelector('.tanggal-pembelian').innerText;
        var total_harga_sebelum = row.querySelector('.total-harga-sebelum').innerText;
        var total_harga = row.querySelector('.total-harga').innerText;
        var nominal = row.querySelector('.nominal') ? row.querySelector('.nominal').innerText : "N/A";

        // Menggunakan jsPDF untuk membuat PDF
        const { jsPDF } = window.jspdf;
        const doc = new jsPDF();

        doc.text('ID: ' + id_transaksi, 10, 10);
        doc.text('Nama Customer: ' + nama_customer, 10, 20);
        doc.text('Obat yang dibeli: ' + nama_obat, 10, 30);
        doc.text('Jumlah Obat: ' + jumlah_obat, 10, 40);
        doc.text('Tipe Obat: ' + tipe_obat, 10, 50);
        doc.text('Tanggal Pembelian: ' + tanggal_pembelian, 10, 60);
        doc.text('Harga Satuan: ' + total_harga, 10, 70);
        doc.text('Nominal Pembayaran: ' + nominal, 10, 80);
        doc.text('Total Pembelian: ' + total_harga_sebelum, 10, 90);

        doc.save('Kuitansi_Apotek_Bersama_' + tanggal_pembelian + '.pdf');
    }
</script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.5.1/jspdf.umd.min.js"></script>
</html>
