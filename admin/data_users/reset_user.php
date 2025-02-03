<?php
if(isset($_GET['id'])){
    include "../../connection.php";
    $password = password_hash($_GET['type'], PASSWORD_DEFAULT);
    $query="UPDATE users SET password_user='$password' WHERE users_id='$_GET[id]'";
    $update=mysqli_query($conn,$query);
    if($update) {
        echo"<script> alert (Password has ben Reset!)</script>";
    }else{
        echo"<script> alert (Action Failed!)</script>";
    }
}

?>
<script>window.location.replace("../../data_users.php");</script>
