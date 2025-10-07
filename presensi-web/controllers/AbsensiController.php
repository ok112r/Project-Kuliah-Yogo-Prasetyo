<?php
session_start();
require_once '../config/Database.php';
require_once '../models/Absensi.php';

date_default_timezone_set('Asia/Jakarta');

if (!isset($_SESSION['nip']) || $_SESSION['jabatan'] !== 'pegawai') {
    header("Location: ../auth/login.php");
    exit();
}

$db = (new Database())->getConnection();
$absensiModel = new Absensi($db);

if (!$absensiModel->absenMasuk($_SESSION['nip'])) {
    echo "<script>alert('Anda sudah absen masuk hari ini.'); window.location.href = '../views/dashboard/pegawai.php';</script>";
    exit();
}

header("Location: ../views/dashboard/pegawai.php");
exit();
?>