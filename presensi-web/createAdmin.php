<?php
require_once 'config/Database.php';
require_once 'models/User.php';

$db = (new Database())->getConnection();
$user = new User($db);

// Tambahkan admin (ganti NIP jika sudah ada yang pakai)
$nip = 1;
$nama = "Admin";
$password = "admin123";
$jabatan = "admin";

if ($user->create($nip, $nama, $password, $jabatan)) {
    echo "Admin berhasil ditambahkan!";
} else {
    echo "Gagal menambahkan admin. Mungkin NIP sudah digunakan.";
}
