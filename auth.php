<?php 
session_start();
if(!isset($_SESSION['login'])){
    echo "<script>alert('Please Login First!'); window.location.replace('login_regis/login-form.php');</script>";
}
?>