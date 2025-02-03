<?php
$current_page = basename($_SERVER['PHP_SELF']);
include '../connection.php';
include '../auth.php';

$users_id = $_SESSION['users_id'];
$query = "SELECT * FROM users WHERE users_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $users_id);
$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/profile.css">
    <title>Pengaturan Akun</title>
</head>
<body>
    <div class="container">

        <div class="settings-section">
            <fieldset>
                <legend>Profile Settings</legend>
                <div class="settings-item">
                    <a href="edit_profile.php">Edit Profile</a>
                </div>
                <div class="settings-item">
                    <label for="name">Name</label>
                    <span id="name"><?php echo htmlspecialchars($row['username']); ?></span>
                </div>
                <div class="settings-item">
                    <label for="email">Email</label>
                    <span id="email"><?php echo htmlspecialchars($row['email']); ?></span>
                </div>
                <div class="settings-item">
                    <a href="edit_password.php">Edit Password</a>
                </div>
            </fieldset>

        </div>
        <a href="../index.php"><button>BACK</button></a>
    </div>
</body>
</html>
