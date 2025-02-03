<?php 
if (isset($_POST['login'])) {
    include "../connection.php";

    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = $_POST['password_user'];

    $query = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        // Verify password
        if (password_verify($password, $user['password_user'])) {
            // Set session
            session_start();
            $_SESSION['login'] = true;
            $_SESSION['users_id'] = $user['users_id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['password_user'] = $user['password_user'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['email'] = $user['email'];

            echo "<script>alert('Login successful!'); window.location.replace('../index.php');</script>";
            exit();
        } else {
            echo "<script>alert('Login failed: Incorrect password!'); window.location.replace('login-form.php');</script>";
            exit();
        }
    } else {
        echo "<script>alert('Login failed: User not found!'); window.location.replace('login-form.php');</script>";
        exit();
    }
}
?>
