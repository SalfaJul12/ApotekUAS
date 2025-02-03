<?php
include './connection.php';

// Ambil data transaksi
$query = "SELECT * FROM transaksi";
$result = $conn->query($query);

// Ambil data obat
$query_obat = "SELECT * FROM obat";
$result_obat = $conn->query($query_obat);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Transaksi</title>
    <link rel="stylesheet" href="assets/css/medicine.css">
</head>
<body>
<div class="data_transaksi">
    <h2>DATA TRANSAKSI</h2>
    <div class="data-section">
        <div class="title2">
            <h2 class="title2">List Transaksi</h2>
            <button id="add-button" class="add-button">TAMBAH TRANSAKSI</button>
        </div>
        <div class="table_container">
            <table>
                <tr>
                    <th>No</th>
                    <th>Nama Customer</th>
                    <th>Tanggal Transaksi</th>
                    <th>Status Pembayaran</th>
                    <th>Action</th>
                </tr>
                <?php 
                $i = 1;
                $query = "SELECT dt.*, t.nama_customer, t.created_at, t.status_pembayaran 
                        FROM detail_transaksi dt
                        LEFT JOIN transaksi t ON dt.id_transaksi = t.id_transaksi";
                $result = $conn->query($query);
                if (!$result) {
                    echo "Database Error: " . $conn->error;
                    exit;
                }

                while ($row = $result->fetch_assoc()) { 
            ?>
                <tr>
                    <td><?php echo $i++; ?></td>
                    <td><?php echo isset($row['nama_customer']) ? $row['nama_customer'] : 'N/A'; ?></td>
                    <td><?php echo isset($row['created_at']) ? $row['created_at'] : 'N/A'; ?></td>
                    <td><?php echo isset($row['status_pembayaran']) ? $row['status_pembayaran'] : 'N/A'; ?></td>
                    <td>
                        <button class="detail-button" 
                            data-nama_customer="<?php echo htmlspecialchars($row['nama_customer']); ?>"
                            data-nama_obat="<?php echo htmlspecialchars($row['nama_obat']); ?>"
                            data-tipe="<?php echo htmlspecialchars($row['tipe_obat']); ?>"
                            data-jumlah="<?php echo htmlspecialchars($row['jumlah_obat']); ?>"
                            data-harga="<?php echo htmlspecialchars($row['harga_obat']); ?>"
                            data-total="<?php echo htmlspecialchars($row['total_harga']); ?>"
                            data-created_at="<?php echo htmlspecialchars($row['created_at']); ?>">
                            Detail
                        </button>
                        
                        <?php
                        // Debugging untuk memastikan status_pembayaran ada
                        // var_dump($row['status_pembayaran']); // Cek nilai status_pembayaran langsung dari $row
                        if (isset($row['status_pembayaran']) && $row['status_pembayaran'] == "BELUM LUNAS") {
                            echo '<button class="confirm-button" 
                                    data-id="' . htmlspecialchars($row['id_transaksi']) . '"
                                    data-nama_customer="' . htmlspecialchars($row['nama_customer']) . '"
                                    data-total="' . htmlspecialchars($row['total_harga']) . '">
                                    Konfirmasi
                                    </button>';
                        }
                        ?>
                        <button class="delete" data-id="<?=$row['id_transaksi'];?>">DELETE</button>
                    </td>
                </tr>
            <?php } ?>
            </table>
        </div>
    </div>
</div>

<!-- Modal ADD -->
<div id="addModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h1>FORM ADD TRANSAKSI</h1>
        <form method="post" action="admin/data_transaksi/add_transaksi.php" enctype="multipart/form-data">
            <div class="form-group">
                <label for="nama_customer">Nama Customer</label>
                <input type="text" id="nama_customer" name="nama_customer" required>
            </div>
            <div class="form-group">
                <label for="nama_obat">Nama Obat</label>
                <select id="nama_obat" name="nama_obat" required>
                    <option value="">Pilih Obat</option>
                    <?php while ($row_obat = $result_obat->fetch_assoc()) { ?>
                        <option value="<?php echo $row_obat['nama_obat']; ?>" data-tipe="<?php echo $row_obat['tipe_obat']; ?>" data-harga="<?php echo $row_obat['harga_obat']; ?>">
                            <?php echo $row_obat['nama_obat']; ?>
                        </option>
                    <?php } ?>
                </select>
            </div>
            <div class="form-group">
                <label for="tipe_obat">Tipe Obat</label>
                <input type="text" id="tipe_obat" name="tipe_obat" readonly>
            </div>
            <div class="form-group">
                <label for="jumlah_obat">Jumlah Obat</label>
                <input type="number" id="jumlah_obat" name="jumlah_obat" required>
            </div>
            <div class="form-group">
                <label for="harga_obat">Harga Obat</label>
                <input type="number" id="harga_obat" name="harga_obat" readonly>
            </div>
            <div class="form-group">
                <label for="total_harga">Total</label>
                <input type="number" id="total_harga" name="total_harga" readonly>
            </div>
            <div class="form-actions">
                <input type="submit" name="save" value="SAVE">
                <input type="reset" name="reset" value="RESET">
            </div>
        </form>
    </div>
</div>

<!-- Modal Konfirmasi -->
<div id="confirmModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h1>KONFIRMASI PEMBAYARAN</h1>
        <form id="confirmForm" method="post" action="admin/data_transaksi/konfirmasi_transaksi.php">
            <div class="form-group">
                <label for="nama_customer">Nama Customer</label>
                <input type="text" id="confirmNamaCustomer" name="nama_customer" readonly>
            </div>
            <div class="form-group">
                <label for="total_harga">Total Harga</label>
                <input type="number" id="confirmTotalHarga" name="total_harga" readonly>
            </div>
            <div class="form-group">
                <label for="nominal">Nominal Pembayaran</label>
                <input type="number" id="confirmNominal" name="nominal" required>
            </div>
            <div class="form-actions">
                <button type="submit" class="confirm">Konfirmasi</button>
                <input type="hidden" id="confirmIdTransaksi" name="id_transaksi">
            </div>
        </form>
    </div>
</div>

<!-- Modal Detail -->
<div id="detailModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h1>DETAIL TRANSAKSI</h1>
        <table>
            <tr>
                <th>Nama Customer</th>
                <th>Nama Obat</th>
                <th>Tipe Obat</th>
                <th>Jumlah Obat</th>
                <th>Harga Obat</th>
                <th>Total Harga</th>
                <th>Tanggal Transaksi</th>
            </tr>
            <tr>
                <td><span id="detailNamaCustomer"></span></td>
                <td><span id="detailNamaObat"></span></td>
                <td><span id="detailTipeObat"></span></td>
                <td><span id="detailJumlahObat"></span></td>
                <td><span id="detailHargaObat"></span></td>
                <td><span id="detailTotalHarga"></span></td>
                <td></strong> <span id="detailCreatedAt"></span></td>
            </tr>
        </table>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", function () {
    const addModal = document.getElementById('addModal');
    const detailModal = document.getElementById('detailModal');
    const addButton = document.getElementById('add-button');
    const closeButtons = document.querySelectorAll('.close');
    const namaObat = document.getElementById('nama_obat');
    const tipeObat = document.getElementById('tipe_obat');
    const hargaObat = document.getElementById('harga_obat');
    const jumlahObat = document.getElementById('jumlah_obat');
    const totalHarga = document.getElementById('total_harga');

    // Event listener untuk tombol "TAMBAH TRANSAKSI"
    addButton.addEventListener('click', function (e) {
        e.preventDefault();
        addModal.style.display = 'flex';
    });

    // Event listener untuk tombol close modal
    closeButtons.forEach((button) => {
        button.addEventListener('click', function () {
            addModal.style.display = 'none';
            detailModal.style.display = 'none';
            confirmModal.style.display = 'none';
        });
    });

    // Event listener untuk perubahan pada dropdown nama obat
    namaObat.addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        tipeObat.value = selectedOption.dataset.tipe;
        hargaObat.value = selectedOption.dataset.harga;
        updateTotalHarga();
    });

    // Event listener untuk input jumlah obat
    jumlahObat.addEventListener('input', updateTotalHarga);

    // Fungsi untuk mengupdate total harga
    function updateTotalHarga() {
        const jumlah = parseInt(jumlahObat.value) || 0;
        const harga = parseInt(hargaObat.value) || 0;
        totalHarga.value = jumlah * harga;
    }

    //tombol "Detail"
    document.querySelectorAll('.detail-button').forEach(button => {
        button.addEventListener('click', function () {
            document.getElementById('detailNamaCustomer').textContent = this.getAttribute('data-nama_customer');
            document.getElementById('detailNamaObat').textContent = this.getAttribute('data-nama_obat');
            document.getElementById('detailTipeObat').textContent = this.getAttribute('data-tipe');
            document.getElementById('detailJumlahObat').textContent = this.getAttribute('data-jumlah');
            document.getElementById('detailHargaObat').textContent = this.getAttribute('data-harga');
            document.getElementById('detailTotalHarga').textContent = this.getAttribute('data-total');
            document.getElementById('detailCreatedAt').textContent = this.getAttribute('data-created_at');
            detailModal.style.display = 'flex';
        }); 
    });

    // Event listener untuk tombol "Konfirmasi"
    document.querySelectorAll('.confirm-button').forEach(button => {
        button.addEventListener('click', function () {
            const idTransaksi = this.getAttribute('data-id'); 
            const namaCustomer = this.getAttribute('data-nama_customer');
            const totalHarga = this.getAttribute('data-total');

            // Isi data ke dalam modal konfirmasi
            document.getElementById('confirmNamaCustomer').value = namaCustomer;
            document.getElementById('confirmTotalHarga').value = totalHarga;
            document.getElementById('confirmIdTransaksi').value = idTransaksi;

            // Tampilkan modal
            const confirmModal = document.getElementById('confirmModal');
            confirmModal.style.display = 'flex';
        });
    });

    // Event listener untuk tombol "DELETE"
    document.querySelectorAll('.delete').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const id = this.dataset.id;
            if (confirm('Yakin ingin menghapus data ini?')) {
                window.location.href = `admin/data_transaksi/delete_transaksi.php?id=${id}`;
            }
        });
    });
});
</script>
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

/* Modal styling */
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    justify-content: center;
    align-items: center;
}
button{
  background-color: #286ea7;
  color: white;
  padding: 5px 10px;
  border-radius: 5px;
  text-decoration: none;
}
.delete {
  background-color: #dc3545;
  color: white;
  padding: 5px 10px;
  border-radius: 5px;
  text-decoration: none;
}
.delete:hover {
  background-color: #c82333;
}
button:hover{
  background-color: #1a4f7f;
}

.modal-content {
    background: white;
    padding: 20px;
    border-radius: 8px;
    width: 50%;
    text-align: left;
    position: relative;
}

.close {
    position: absolute;
    top: 10px;
    right: 15px;
    font-size: 24px;
    cursor: pointer;
}
</style>

</body>
</html>
