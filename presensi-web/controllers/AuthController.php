<?php
session_start();
require_once '../config/Database.php';
require_once '../models/User.php';

date_default_timezone_set('Asia/Jakarta');

$db = (new Database())->getConnection();
$userModel = new User($db);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nip = $_POST['nip'];
    $password = $_POST['password'];
    $user = $userModel->login($nip, $password);
    if ($user) {
        $_SESSION['nip'] = $user['nip'];
        $_SESSION['nama'] = $user['nama'];
        $_SESSION['jabatan'] = $user['jabatan'];

        if ($user['jabatan'] === 'admin') {
            header("Location: ../views/dashboard/admin.php");
        } else {
            header("Location: ../views/dashboard/pegawai.php");
        }
        exit();
    } else {
        echo "Login gagal. NIP atau password salah.";
    }
}
