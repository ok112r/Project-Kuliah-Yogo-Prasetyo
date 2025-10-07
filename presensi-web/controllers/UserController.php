<?php
session_start();
require_once '../config/Database.php';
require_once '../models/User.php';

$db = (new Database())->getConnection();
$userModel = new User($db);

if (isset($_POST['tambah'])) {
    $result = $userModel->create($_POST['nip'], $_POST['nama'], $_POST['password'], $_POST['jabatan']);
    if ($result) {
        header("Location: ../views/dashboard/admin.php");
    } else {
        header("Location: ../views/dashboard/admin.php?error=nip_terdaftar");
    }
    exit();
}


if (isset($_POST['hapus'])) {
    $userModel->delete($_POST['nip']);
    header("Location: ../views/dashboard/admin.php");
    exit();
}

if (isset($_POST['update'])) {
    $userModel->update($_POST['nip'], $_POST['nama'], $_POST['jabatan']);
    header("Location: ../views/dashboard/admin.php");
    exit();
}

if (isset($_GET['edit'])) {
    $_SESSION['edit_nip'] = $_GET['edit'];
    header("Location: ../views/dashboard/edit.php");
    exit();
}

?>