<?php
session_start();
    if (isset($_POST['save'])) {
        include "../../connection.php";

        $hashed_password = password_hash($_POST['password_user'], PASSWORD_DEFAULT);

        $query = "UPDATE users SET
                  username = '$_POST[username]',
                  password_user = '$hashed_password',
                  role = '$_POST[role]',
                  email = '$_POST[email]'
                  WHERE users_id = '$_POST[users_id]';
                  ";

        $update = mysqli_query($conn, $query);
        $userid = $_SESSION['users_id'];
        $activity_query = "INSERT INTO log(users_id, aksi,created_at) VALUES ('$userid', 'Telah Melakukan Update User', NOW())";
        $conn->query($activity_query);

        if ($update) {
            echo "<script>alert('Users Update Successfully!')</script>";
        } else {
            echo "<script>alert('Update Users Failed')</script>";
        }
    }
?>

<script>window.location.replace("../../data_users.php");</script>
