<?php
session_start();
    if (isset($_GET['id'])) {
        include "../../connection.php";
    
        $query = "DELETE FROM users WHERE users_id = '$_GET[id]'";

        $userid = $_SESSION['users_id'];
        $activity_query = "INSERT INTO log(users_id, aksi,created_at) VALUES ('$userid', 'Telah Menghapus User', NOW())";
        $conn->query($activity_query);
        
        $delete = mysqli_query($conn, $query);
    
        if ($delete) {
            echo "<script>alert('Users Delete Successfully!')</script>";
        } else {
            echo "<script>alert('Delete Users Failed')</script>";
        }
    }
    
?>

<script>window.location.replace("../../data_users.php");</script>