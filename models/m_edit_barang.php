<?php

//  ajax perlu require lagi
require_once('../config/koneksi.php');
require_once('../models/database.php');
include "../models/m_barang.php";

$connect = new Database($host, $username, $password, $database);
$brg = new Barang($connect);

$id_brg = $_POST['id_brg'];
$nama_brg = $connect->conn->real_escape_string($_POST['nama_brg']);
$harga_brg = $connect->conn->real_escape_string($_POST['harga_brg']);
$stok_brg = $connect->conn->real_escape_string($_POST['stok_brg']);

// kondisi ada gambar baru
$pict = $_FILES['gambar_brg']['name'];

// fungsi rename gambar yang diupload
$ekstensi = explode(".", $_FILES['gambar_brg']['name']);
$gambar_brg = "brg-" . round(microtime(true)) . "." . end($ekstensi);
$sumber = $_FILES['gambar_brg']['tmp_name'];

if ($pict == '') {
    $brg->edit("UPDATE tbl_barang SET nama_brg = '$nama_brg', harga_brg='$harga_brg', stok_brg='$stok_brg' WHERE id_brg='$id_brg'");

    // jika header tidak bisa maka pakai
    // window location javascript
    echo "<script>window.location='?page=barang'</script>";
} else {
    $gambar_awal = $brg->tampil($id_brg)->fetch_object()->gambar_brg;
    unlink("../assets/img/barang/" . $gambar_awal);

    $upload = move_uploaded_file($sumber, "../assets/img/barang/" . $gambar_brg);

    if ($upload) {
        $brg->edit("UPDATE tbl_barang SET nama_brg = '$nama_brg', harga_brg='$harga_brg', stok_brg='$stok_brg', gambar_brg='$gambar_brg' WHERE id_brg='$id_brg'");

        // redirect
        echo "<script>window.location='?page=barang'</script>";
    } else {
        echo "<script>alert('Upload gambar gagal!')</script>";
    }
}
