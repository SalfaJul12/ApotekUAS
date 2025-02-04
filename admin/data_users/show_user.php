<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="assets/css/medicine.css">
</head>
<body>
<?php
include 'connection.php';
$no_user_query = "SELECT COUNT(*) AS total_users FROM `users`";
$no_user_result = $conn->query($no_user_query);

$query = "SELECT * FROM `users`";
$result = $conn->query($query);
if ($no_user_result) {
    $row = $no_user_result->fetch_assoc();
    $no_user = $row['total_users'];
}
$no = 1;
?>
<div class="data_users">
    <h2>DATA USERS</h2>
    <div class="stats">
        <div class="stat-box">
        </div>
        <div class="stat-box">
            <h2>Total User</h2>
            <p> <?php echo $no_user?> User</p>
        </div>
        <div class="stat-box">
        </div>
    </div>
    <div class="data-section">
        <div class="title2">
            <h2 class="title2">List Users</h2>
            <button id="add-button" class="add-button">TAMBAH USERS</button>
        </div>
        <form method="" action="">
            <div class="table_container">
                <table>
                    <tr>
                        <th>No</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Role</th>
                        <th colspan="3">Action</th>
                    </tr>
                    <?php
                    while ($row = $result->fetch_assoc()) {
                        ?>
                        <tr>
                            <td><?php echo $no++?></td>
                            <td><?php echo htmlspecialchars($row['username']); ?></td>
                            <td><?php echo htmlspecialchars($row['email']); ?></td>
                            <td><?php echo htmlspecialchars($row['role']); ?></td>
                            <td>
                                <a href="#" class="edit" 
                                data-id="<?php echo $row['users_id']; ?>"
                                data-username="<?php echo htmlspecialchars($row['username']); ?>"
                                data-email="<?php echo htmlspecialchars($row['email']); ?>"
                                data-role="<?php echo htmlspecialchars($row['role']); ?>"
                                data-password_user="<?php echo htmlspecialchars($row['password_user']); ?>">
                                <button id="edit-button" class="btn-edit">EDIT</button>
                                </a>
                            </td>
                            <td>
                                <button class="delete" data-id="<?php echo $row['users_id']; ?>">DELETE</button>
                            </td>
                            <td>
                                <a href="admin/data_users/reset_user.php?id=<?= urlencode($row['users_id']) ?>&type=<?= urlencode($row['role']) ?>"
                                onclick="return confirm('Are you sure you want to reset the password?')">
                                    <button type="button">RESET</button>
                                </a>
                            </td>
                        </tr>
                        <?php
                    }
                    ?>
                </table>
            </div>
        </form>
    </div>

    <!-- Modal ADD -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h1>FORM ADD USER</h1>
            <form method="post" action="admin/data_users/add_user.php">
                <div class="form-group">
                    <label for="username">Username</label>
                    <input type="text" id="username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="role">Role</label>
                    <select name="role" id="role" required>
                        <option value="" selected disabled hidden>Choose here</option>
                        <option value="Manager">Manager</option>
                        <option value="Staff">Staff</option>
                    </select>
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
            <h1>FORM EDIT USER</h1>
            <form method="post" action="admin/data_users/edit_user.php">
                <div class="form-group">
                    <label for="edit_username">Username</label>
                    <input type="text" id="edit_username" name="username" required>
                </div>
                <div class="form-group">
                    <label for="edit_email">Email</label>
                    <input type="text" id="edit_email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="edit_password">Password</label>
                    <input type="password" id="edit_password" name="password_user" placeholder="New Password">
                </div>
                <div class="form-group">
                    <label for="edit_role">Role</label>
                    <select name="role" id="edit_role" required>
                        <option value="" selected disabled hidden>Choose here</option>
                        <option value="Manager">Manager</option>
                        <option value="Staff">Staff</option>
                    </select>
                </div>
                <div class="form-actions">
                    <input type="hidden" id="users_id" name="users_id">
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
            const username = this.dataset.username;
            const email = this.dataset.email;
            const role = this.dataset.role;
            const password = this.dataset.password;

            // Set nilai untuk input dan select
            document.getElementById('users_id').value = id;
            document.getElementById('edit_username').value = username;
            document.getElementById('edit_email').value = email;
            document.getElementById('edit_role').value = role;

            // Tampilkan modal
            editModal.style.display = 'flex';
        });
    });

    // Fungsi DELETE dengan konfirmasi
    document.querySelectorAll('.delete').forEach(button => {
        button.addEventListener('click', function (e) {
            e.preventDefault(); // Mencegah pengalihan default (karena ini link)
            const id = this.dataset.id; // Ambil id dari tombol yang diklik

            // Tampilkan konfirmasi
            if (confirm('Yakin ingin menghapus data ini?')) {
                // Jika konfirmasi diterima, arahkan ke halaman delete
                window.location.href = `admin/data_users/delete_user.php?id=${id}`;
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
