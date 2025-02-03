<?php
session_start();
include '../../connection.php';

if (isset($_POST['save'])) {
    $nama_obat = $_POST['nama_obat'];
    $stock = $_POST['stock'];
    $tipe_obat = $_POST['tipe_obat'];
    $harga_obat = $_POST['harga_obat'];

    $target_dir = "../../assets/storage/";
    $foto_name = basename($_FILES["foto"]["name"]);
    $target_file = $target_dir . $foto_name;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    $allowed_types = ['jpg', 'jpeg', 'png', 'gif'];
    if (!in_array($imageFileType, $allowed_types)) {
        echo "alert ('Error: Format file tidak didukung')";
        header("Location: ../../data_obat.php");
        exit;
    }

    // Simpan file
    if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
        $foto_path = "assets/storage/" . $foto_name;
        $query = "INSERT INTO obat (nama_obat, stock, tipe_obat, foto, harga_obat) 
                  VALUES ('$nama_obat', '$stock', '$tipe_obat', '$foto_path', '$harga_obat')";
        $userid = $_SESSION['users_id'];
        $activity_query = "INSERT INTO log(users_id, aksi) VALUES ('$userid', 'Telah Menambahkan Obat')";
        $conn->query($activity_query);
        
        if ($conn->query($query)) {
            header("Location: ../../data_obat.php");
        } else {
            echo "Error: " . $conn->error;
        }
    } else {
        echo "Error: Gagal mengupload file.";
    }
}
?>
