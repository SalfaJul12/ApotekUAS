<?php
    session_start();
    if (isset($_POST['save'])) {
        include "../connection.php";

        $users_id = $_SESSION['users_id']; // Asumsi users_id disimpan dalam session setelah login
        $username = mysqli_real_escape_string($conn, $_POST['username']);
        $email = mysqli_real_escape_string($conn, $_POST['email']);
        $password_user = $_POST['password_user']; // Pastikan variabel ini ada

        // Cek jika password diubah, maka hash password baru
        if (!empty($password_user)) {
            $hashed_password = password_hash($password_user, PASSWORD_DEFAULT);
            $query = "UPDATE users SET
                      username = ?, 
                      email = ?, 
                      password_user = ?
                      WHERE users_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssss", $username, $email, $hashed_password, $users_id); // 4 parameter untuk query dengan password
        } else {
            // Jika password tidak diubah, query tanpa password
            $query = "UPDATE users SET
                      username = ?, 
                      email = ?
                      WHERE users_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssi", $username, $email, $users_id); // 3 parameter untuk query tanpa password
        }

        // Menjalankan query
        if ($stmt->execute()) {
            echo "<script>alert('User profile updated successfully!'); window.location.replace('../data_users.php');</script>";
        } else {
            echo "<script>alert('Failed to update user profile');</script>";
        }
    }
?>
