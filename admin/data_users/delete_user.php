<?php
    if (isset($_GET['id'])) {
        include "../../connection.php";
    
        $query = "DELETE FROM users WHERE users_id = '$_GET[id]'";
        
        $delete = mysqli_query($conn, $query);
    
        if ($delete) {
            echo "<script>alert('Users Delete Successfully!')</script>";
        } else {
            echo "<script>alert('Delete Users Failed')</script>";
        }
    }
    
?>

<script>window.location.replace("../../data_users.php");</script>