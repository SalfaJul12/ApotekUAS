<?php 
$no_medicine_query = "SELECT COUNT(*) AS total_obat FROM `obat`";
$no_medicine_result = $conn->query($no_medicine_query);

$no_report_query = "SELECT COUNT(*) AS total_jual FROM `laporan_transaksi`";
$no_report_result = $conn->query($no_report_query);
if ($no_report_result) {
    $row = $no_report_result->fetch_assoc();
    $no_laporan = $row['total_jual'];
}
if ($no_medicine_result) {
    $row = $no_medicine_result->fetch_assoc();
    $no_obat = $row['total_obat'];
}
?>
<div class="dashboard">
    <h1>Dashboard Admin</h1>
    <div class="stats">
        <div class="stat-box">
            <h2>Total Obat</h2>
            <p><?php echo $no_obat?> Obat</p>
        </div>
        <div class="stat-box">
            <h2>Total Obat Terjual</h2>
            <p> <?php echo $no_laporan?> Obat</p>
        </div>
        <div class="stat-box">
        </div>
    </div>

    <div class="data-section">
        <h2>Activiy Log</h2>
        <div class="table_container">
            <table class="data-table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Aksi</th>
                        <th>Waktu</th>
                    </tr>
                </thead>
                <tbody>
                <?php 
                $i = 1;

                $query = "SELECT log.log_id, users.username, log.aksi, log.created_at
                FROM log
                INNER JOIN users ON log.users_id=users.users_id";

                $result = $conn->query($query);
                while ($row = $result->fetch_assoc()) { ?>
                    <tr>
                        <td><?php echo $i++; ?></td>
                        <td><?php echo $row['username']; ?></td>
                        <td><?php echo $row['aksi']; ?></td>
                        <td><?php echo date('d F Y H:i', strtotime($row['created_at'])); ?></td>
                    </tr>
                </tbody>
                <?php } ?>
            </table>
        </div>
    </div>
</div>

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