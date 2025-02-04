<?php
session_start();
include '../../connection.php';

if (isset($_POST['save'])) {
    $id_obat = intval($_POST['id_obat']); 
    $nama_obat = trim($_POST['nama_obat']);
    $stock = intval($_POST['stock']);
    $tipe_obat = trim($_POST['tipe_obat']);
    $harga = floatval($_POST['harga_obat']);

    // Cek apakah ada file gambar yang diupload
    if (!empty($_FILES['foto']['name'])) {
        $foto_name = basename($_FILES["foto"]["name"]);
        $foto_path = "assets/storage/" . $foto_name; // Path yang disimpan di database
        $target_file = "../../" . $foto_path; // Path sebenarnya untuk penyimpanan

        // Pastikan direktori ada
        if (!file_exists("../../assets/storage/")) {
            mkdir("../../assets/storage/", 0777, true);
        }

        if (move_uploaded_file($_FILES["foto"]["tmp_name"], $target_file)) {
            // Jika upload berhasil, update dengan foto baru
            $query = "UPDATE obat SET nama_obat=?, stock=?, tipe_obat=?, harga_obat=?, foto=? WHERE id_obat=?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("sisdsi", $nama_obat, $stock, $tipe_obat, $harga, $foto_path, $id_obat);

            $userid = $_SESSION['users_id'];
            $activity_query = "INSERT INTO log(users_id, aksi,created_at) VALUES ('$userid', 'Telah Melakukan Update Obat', NOW())";
            $conn->query($activity_query);
        } else {
            echo "Gagal mengupload gambar.";
            exit();
        }
    } else {
        // Jika tidak ada foto baru, tetap gunakan yang lama
        $query = "UPDATE obat SET nama_obat=?, stock=?, tipe_obat=?, harga_obat=? WHERE id_obat=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sisdi", $nama_obat, $stock, $tipe_obat, $harga, $id_obat);
        
        $userid = $_SESSION['users_id'];
        $activity_query = "INSERT INTO log(users_id, aksi,created_at) VALUES ('$userid', 'Telah Melakukan Update Obat', NOW())";
        $conn->query($activity_query);
    }

    if ($stmt->execute()) {
        header("Location: ../../data_obat.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
}
$conn->close();
?>
