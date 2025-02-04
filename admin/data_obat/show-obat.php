<?php
include 'connection.php';

$no_medicine_query = "SELECT COUNT(*) AS total_obat FROM `obat`";
$no_medicine_result = $conn->query($no_medicine_query);
if ($no_medicine_result) {
    $row = $no_medicine_result->fetch_assoc();
    $no_obat = $row['total_obat'];
}

$no_stock_query = "SELECT SUM(stock) AS total_pcs FROM `obat`";
$no_stock_result = $conn->query($no_stock_query);
if ($no_stock_result) {
    $row = $no_stock_result->fetch_assoc();
    $no_pcs = $row['total_pcs'];
}

$query = "SELECT * FROM `users`";
$result = $conn->query($query);
$no = 1;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Obat</title>
    <link rel="stylesheet" href="assets/css/medicine.css">
</head>
<body>
<div class="data_obat">
    <h2>DATA OBAT</h2>
    <div class="stats">
        <div class="stat-box">
            <h2>Total Obat</h2>
            <p><?php echo $no_obat?> Obat</p>
        </div>
        <div class="stat-box">
            <h2>Total Semua PCS</h2>
            <p><?php echo $no_pcs?> Obat</p>
        </div>
        <div class="stat-box">
        </div>
    </div>
    <div class="data-section">
        <div class="title2">
            <h2 class="title2">List Obat</h2>
            <button id="add-button" class="add-button">TAMBAH OBAT</button>
        </div>
        <form method="" action="">
            <div class="table_container">
                <table>
                    <tr>
                        <th>No</th>
                        <th>Nama Obat</th>
                        <th>stock</th>
                        <th>Tipe Obat</th>
                        <th>Photo</th>
                        <th>Harga</th>
                        <th>Created at</th>
                        <th colspan="2">Action</th>
                    </tr>
                    <?php $i = 1;
                    $query = "SELECT * FROM obat";
                    $result = $conn->query($query);
                    while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $row['nama_obat']; ?></td>
                        <td><?php echo $row['stock']; ?> pcs</td>
                        <td><?php echo $row['tipe_obat']; ?></td>
                        <td>
                            <img src="<?php echo $row['foto']; ?>" alt="Foto Obat" width="100px">
                        </td>
                        <td>Rp <?php echo $row['harga_obat']; ?></td>
                        <td><?php echo $row['created']; ?></td>
                        <td><a href="#" class="edit" 
                            data-id="<?php echo $row['id_obat']; ?>"
                            data-nama="<?php echo $row['nama_obat']; ?>"
                            data-stock="<?php echo $row['stock']; ?>"
                            data-tipe="<?php echo $row['tipe_obat']; ?>"
                            data-harga="<?php echo $row['harga_obat']; ?>"
                            data-foto="<?php echo $row['foto']; ?>"
                            >
                            <button id="edit-button" class="btn-edit">EDIT</button>
                            </a>
                        </td>
                        <td>
                            <button class="delete" data-id="<?=$row['id_obat'];?>">DELETE</button>
                        </td>
                    </tr>
                    <?php } ?>
                </table>
            </div>
        </form>
    </div>

    <!-- Modal ADD -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h1>FORM ADD OBAT</h1>
            <form method="post" action="admin/data_obat/add-obat.php" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="nama_obat">Nama Obat</label>
                    <input type="text" id="nama_obat" name="nama_obat" required>
                </div>
                <div class="form-group">
                    <label for="stock">stock (Jumlah Obat)</label>
                    <input type="text" id="stock" name="stock" required>
                </div>
                <div class="form-group">
                    <label for="foto">Photo</label>
                    <input type="file" id="foto" name="foto" accept="image/*" required>
                </div>
                <div class="form-group">
                    <label for="tipe_obat">Tipe Obat</label>
                    <select name="tipe_obat" id="tipe_obat" required>
                        <option value="" selected disabled hidden>Choose here</option>
                        <option value="pill">PILL</option>
                        <option value="kapsul">Kapsul</option>
                        <option value="sirup">Sirup</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="harga">Harga</label>
                    <input type="number" id="harga" name="harga_obat" required>
                </div>
                <div class="form-actions">
                    <input type="submit" name="save" value="SAVE">
                    <input type="reset" name="reset" value="RESET">
                </div>
            </form>
        </div>
    </div>
    
    <!-- Modal EDIT -->
    <div id="editModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h1>FORM EDIT OBAT</h1>
            <form method="post" action="admin/data_obat/edit-obat.php" enctype="multipart/form-data" >
                <div class="form-group">
                    <label for="edit_nama_obat">Nama Obat</label>
                    <input type="text" id="edit_nama_obat" name="nama_obat" required>
                </div>
                <div class="form-group">
                    <label for="edit_stock">stock (Jumlah Obat)</label>
                    <input type="text" id="edit_stock" name="stock" required>
                </div>
                <div class="form-group">
                    <label for="foto">Photo</label>
                    <input type="file" id="edit_foto" name="foto" accept="image/*">
                </div>
                <div class="form-group">
                    <label for="edit_tipe_obat">Tipe Obat</label>
                    <select name="tipe_obat" id="edit_tipe_obat" required>
                        <option value="" selected disabled hidden>Choose here</option>
                        <option value="pill">PILL</option>
                        <option value="kapsul">Kapsul</option>
                        <option value="sirup">Sirup</option>
                    </select>
                </div>                                          
                <div class="form-group">
                    <label for="edit_harga">Harga</label>
                    <input type="text" id="edit_harga" name="harga_obat" required>
                </div>
                <div class="form-actions">
                    <input type="hidden" id="id_obat" name="id_obat">
                    <input type="submit" name="save" value="SAVE">
                    <input type="reset" name="reset" value="RESET">
                </div>
            </form>
        </div>
    </div>

    <script>
    // Fungsi modal (Add & Edit)
    const addModal = document.getElementById('addModal');
    const editModal = document.getElementById('editModal');
    const addButton = document.getElementById('add-button');
    const closeButtons = document.querySelectorAll('.close');

    // Membuka modal Tambah Obat
    addButton.addEventListener('click', function (e) {
        e.preventDefault();
        addModal.style.display = 'flex';
    });

    // Menutup modal
    closeButtons.forEach((button) => {
        button.addEventListener('click', function () {
            addModal.style.display = 'none';
            editModal.style.display = 'none';
        });
    });

    // Fungsi Edit (pada tombol edit)
    document.querySelectorAll('.edit').forEach(button => {
    button.addEventListener('click', function (e) {
            e.preventDefault();
            const id = this.dataset.id;
            const nama = this.dataset.nama;
            const stock = this.dataset.stock;
            const tipe = this.dataset.tipe;
            const harga = this.dataset.harga;
            const foto = this.dataset.foto;

            document.getElementById('id_obat').value = id;
            document.getElementById('edit_nama_obat').value = nama;
            document.getElementById('edit_stock').value = stock;
            document.getElementById('edit_tipe_obat').value = tipe;
            document.getElementById('edit_harga').value = harga;
            document.getElementById('edit_foto').src = foto;

            editModal.style.display = 'flex';
        });
    });

    // Fungsi DELETE dengan konfirmasi
    document.querySelectorAll('.delete').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault();
            const id = this.dataset.id;

            if (confirm('Yakin ingin menghapus data ini?')) {
                window.location.href = `admin/data_obat/delete-obat.php?id=${id}`;
            }
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

.dashboard {
    font-family: 'Roboto', sans-serif;
}

.dashboard h1 {
    font-size: 24px;
    margin-bottom: 20px;
}

.add-button {
    background-color: #2d98da;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 16px;
    font-weight: bold;
    transition: background-color 0.3s ease;
}

.add-button:hover {
    background-color: #1e7bb6;
}

.btn-edit{
  background-color: #286ea7;
  color: white;
  padding: 5px 10px;
  border-radius: 5px;
  text-decoration: none;
}
.delete:hover {
  background-color: #c82333;
}
.btn-edit:hover{
  background-color: #1a4f7f;
}
.title2 {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 20px;
}

.title2 h2 {
    margin: 0;
    font-size: 20px;
    font-weight: bold;
}

.stats {
    display: flex;
    justify-content: space-around;
    margin-bottom: 10px;
}

.stat-box {
    background-color: #2d98da;
    color: white;
    text-align: center;
    padding: 10px;
    border-radius: 8px;
    width: 30%;
}

.stat-box h2 {
    font-size: 20px;
    margin-bottom: 10px;
}

.stat-box p {
    font-size: 18px;
    font-weight: bold;
}

.data-section {
    margin-top: 20px;
}

.data-section h2 {
    font-size: 20px;
    margin-bottom: 10px;
}

.data-table {
    width: 100%;
    border-collapse: collapse;
}

.data-table th, .data-table td {
    border: 1px solid #ddd;
    padding: 10px;
    text-align: left;
}

.data-table th {
    background-color: #f4f4f4;
    font-weight: bold;
}

.data-table tr:nth-child(even) {
    background-color: #f9f9f9;
}

.data-table tr:hover {
    background-color: #f1f1f1;
}
</style>
</body>
</html>
