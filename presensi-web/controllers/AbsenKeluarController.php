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
$absensiModel->absenKeluar($_SESSION['nip']);

header("Location: ../views/dashboard/pegawai.php");
exit();
?>