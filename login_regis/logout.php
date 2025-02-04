<?php
session_start();
include '../connection.php';

$users_id = $_SESSION['users_id'];

// Hapus user_id dari session
unset($_SESSION['users_id']);
session_destroy();

// Redirect ke halaman login
header('Location: login-form.php');
exit;
?>