<?php
$current_page = basename($_SERVER['PHP_SELF']);
include 'connection.php';
include 'auth.php';
if (!isset($_SESSION['login'])) {
    header("Location: login_regis/login-form.php");
    exit();
}
$users_id = $_SESSION['users_id'];

$query = "SELECT username, role FROM users WHERE users_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $users_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
?>
<div class="sidebar">
    <div class="sidebar-header">
        <h2>Apotek Bersama</h2>
    </div>

    <div class="profile">
        <img src="assets/image/logo-apotek.png" alt="logo apotek">
        <p>
            Selamat datang <?php echo htmlspecialchars($row['username']); ?>
        </p>
        <p>(<?php echo htmlspecialchars($row['role']); ?>)</p>
        <a class="edit-btn" href="admin/pengaturan-akun.php" title="Edit Profile">Edit Profile</a>
    </div>

    <ul class="menu">
        <li class="menu-item">
            <a href="./index.php" class="<?= $current_page == 'index.php' ? 'active' : '' ?>">
                <img src="assets/icons/home.png" alt="Home Icon">
                Dashboard
            </a>
        </li>
        <li class="menu-item">
            <a href="data_obat.php" class="<?= $current_page == 'data_obat.php' ? 'active' : '' ?>">
                <img src="assets/icons/pills.png" alt="Pills Icon">
                Data Obat
            </a>
        </li>
        <li class="menu-item">
            <a href="./data_transaksi.php" class="<?= $current_page == 'data_transaksi.php' ? 'active' : '' ?>">
                <img src="assets/icons/transaction-list.png" alt="Transaction Icon">
                Transaksi
            </a>
        </li>
        <li class="menu-item">
            <a href="./data_laporan.php" class="<?= $current_page == 'data_laporan.php' ? 'active' : '' ?>">
                <img src="assets/icons/document.png" alt="Report Icon">
                Laporan
            </a>
        </li>
        <li class="menu-item">
            <a href="./data_users.php" class="<?= $current_page == 'data_users.php' ? 'active' : '' ?>">
                <img src="assets/icons/user.svg" alt="Report Icon">
                Users
            </a>
        </li>
    </ul>

    <div class="logout">
        <a href="login_regis/logout.php">Logout</a>
    </div>
</div>