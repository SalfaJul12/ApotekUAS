<?php
    session_start();
    if (isset($_POST['save'])) {
        include "../connection.php";

        $users_id = $_SESSION['users_id']; // Asumsi users_id disimpan dalam session setelah login
        $password_user = $_POST['password_user']; // Pastikan variabel ini ada

        // Cek jika password diubah, maka hash password baru
        if (!empty($password_user)) {
            $hashed_password = password_hash($password_user, PASSWORD_DEFAULT);
            $query = "UPDATE users SET password_user = ? WHERE users_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("si", $hashed_password, $users_id); // Bind parameter untuk password dan users_id
            // Menjalankan query
            if ($stmt->execute()) {
                echo "<script>alert('Password updated successfully!'); window.location.replace('../data_users.php');</script>";
            } else {
                echo "<script>alert('Failed to update password');</script>";
            }
        } else {
            echo "<script>alert('Password cannot be empty');</script>";
        }
    }
?>
