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
    <title>Edit Profile</title>
</head>
<body>
    <div class="container">
        <!-- Edit Profile Form -->
        <div class="profile-section">
            <h2>Edit Profile</h2>
            <form method="post" action="update_profile.php" enctype="multipart/form-data" class="upload-form">
                <div class="form-group">
                    <label for="username">Name</label>
                    <input type="text" name="username" id="username" value="<?php echo htmlspecialchars($row['username']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="<?php echo htmlspecialchars($row['email']); ?>" required>
                </div>

                <input type="submit" name="save" value="Update Profile">
            </form>
        </div>
        
        <!-- Link Back to Profile Settings -->
        <div class="back-link">
            <a href="pengaturan-akun.php">Back to Profile Settings</a>
        </div>
    </div>
</body>
</html>
<style>
/* Reset default styles */
* {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: 'Poppins', sans-serif;
}

/* Body Styling */
body {
    background: linear-gradient(to right, #4facfe, #00f2fe);
    display: flex;
    justify-content: center;
    align-items: center;
    height: 100vh;
}

/* Container */
.container {
    background: #ffffff;
    padding: 25px;
    width: 400px;
    border-radius: 10px;
    box-shadow: 0px 5px 15px rgba(0, 0, 0, 0.2);
    text-align: center;
}

/* Profile Section */
.profile-section h2 {
    color: #333;
    margin-bottom: 15px;
}

/* Form Styling */
.upload-form {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.form-group {
    text-align: left;
}

.form-group label {
    font-weight: bold;
    color: #555;
    display: block;
    margin-bottom: 5px;
}

.form-group input {
    width: 100%;
    padding: 10px;
    border: 1px solid #ddd;
    border-radius: 5px;
    font-size: 1em;
    transition: 0.3s;
}

.form-group input:focus {
    border-color: #007bff;
    outline: none;
    box-shadow: 0px 0px 5px rgba(0, 123, 255, 0.5);
}

/* Submit Button */
input[type="submit"] {
    background: #007bff;
    color: white;
    border: none;
    padding: 10px 15px;
    font-size: 1em;
    border-radius: 5px;
    cursor: pointer;
    transition: 0.3s;
    margin-top: 10px;
}

input[type="submit"]:hover {
    background: #0056b3;
}

/* Back Link */
.back-link {
    margin-top: 15px;
}

.back-link a {
    text-decoration: none;
    color: #007bff;
    font-weight: bold;
    transition: 0.3s;
}

.back-link a:hover {
    color: #0056b3;
    text-decoration: underline;
}

</style>