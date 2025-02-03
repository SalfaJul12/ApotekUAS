<?php
session_start();
    if (isset($_POST['save'])) {
        include "../../connection.php";

        $password = password_hash($_POST['role'], PASSWORD_DEFAULT);
    
        $query = "INSERT INTO users (username, password_user, role, email) 
        VALUES ('$_POST[username]', '$password', '$_POST[role]', '$_POST[email]')";

        $userid = $_SESSION['users_id'];
        $activity_query = "INSERT INTO log(users_id, aksi) VALUES ('$userid', 'Telah Menambahkan User')";
        $conn->query($activity_query);
    
        $create = mysqli_query($conn, $query);
    
        if ($create) {
            echo "<script>alert('Users Added Successfully!')</script>";
        } else {
            echo "<script>alert('Users Pet Failed')</script>";
        }
    }
    
?>

<script>window.location.replace("../../data_users.php");</script>