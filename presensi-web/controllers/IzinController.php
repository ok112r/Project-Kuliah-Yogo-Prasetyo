<?php
session_start();
require_once '../config/Database.php';
require_once '../models/Izin.php';

$db = (new Database())->getConnection();
$izinModel = new Izin($db);

// NOTIF

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['aksi'], $_POST['id']) && $_SESSION['jabatan'] === 'admin') {
        $id = $_POST['id'];
        $statusBaru = $_POST['aksi'] === 'terima' ? 'disetujui' : ($_POST['aksi'] === 'tolak' ? 'ditolak' : $_POST['aksi']);

        // Ambil status lama
        $statusLama = $izinModel->getStatusById($id);

        if ($statusLama !== $statusBaru) {
            $izinModel->ubahStatus($id, $statusBaru);
            $_SESSION['notif'] = "Status izin berhasil diubah.";
        }

        header("Location: ../views/dashboard/admin.php");
        exit();
    }


    if (!isset($_SESSION['nip']) || $_SESSION['jabatan'] !== 'pegawai') {
        header("Location: ../auth/login.php");
        exit();
    }

    $tanggal = $_POST['tanggal'];
    $keterangan = $_POST['keterangan'];
    $izinModel->ajukanIzin($_SESSION['nip'], $tanggal, $keterangan);
    header("Location: ../views/dashboard/pegawai.php");
    exit();
}
