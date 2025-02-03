<?php
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

        if ($update) {
            echo "<script>alert('Users Update Successfully!')</script>";
        } else {
            echo "<script>alert('Update Users Failed')</script>";
        }
    }
?>

<script>window.location.replace("../../data_users.php");</script>
