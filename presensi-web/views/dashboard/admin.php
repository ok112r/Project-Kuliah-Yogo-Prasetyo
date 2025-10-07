<?php
session_start();
require_once '../../config/Database.php';
require_once '../../models/User.php';
require_once '../../models/Izin.php';
require_once '../../models/Absensi.php';


if (!isset($_SESSION['nip']) || $_SESSION['jabatan'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

$db = (new Database())->getConnection();
$userModel = new User($db);
$absensiModel = new Absensi($db);
$absensi = $absensiModel->getAllAbsensi();
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet" />
  <script src="https://unpkg.com/feather-icons"></script>
  <title>Dashboard Admin</title>
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
  </style>
</head>

<body class="bg-gray-100">

  <!-- CONTAINER -->
  <div class="min-h-screen flex">

    <!-- SIDEBAR -->
    <aside id="sidebar"
      class="w-64 bg-sky-600 text-white flex-shrink-0 px-6 py-8 hidden md:block transition-all duration-300 z-50 fixed md:static inset-y-0 left-0">
      <div class="text-2xl font-bold mb-10">Dashboard Admin</div>
      <nav class="flex flex-col space-y-4 text-sm">
        <a href="tambah.php" class="hover:bg-sky-500 rounded-md px-3 py-2 transition">Tambah Pegawai</a>
        <a href="daftarPegawai.php" class="hover:bg-sky-500 rounded-md px-3 py-2 transition">Daftar Pegawai</a>
        <a href="daftarIzin.php" class="hover:bg-sky-500 rounded-md px-3 py-2 transition">Daftar Izin Pegawai</a>
        <a href="../../controllers/logout.php"
          class="hover:bg-sky-500 rounded-md px-3 py-2 transition font-semibold">Logout</a>
      </nav>
    </aside>

    <!-- MAIN CONTENT -->
    <div class="flex-1 flex flex-col ml-0 md:ml-64">

      <!-- TOPBAR -->
      <header class="bg-white shadow px-6 py-4 flex justify-between items-center md:hidden">
        <div class="text-lg font-semibold text-sky-700">Dashboard</div>
        <button onclick="toggleSidebar()" class="focus:outline-none">
          <i data-feather="menu" class="w-6 h-6 text-sky-700"></i>
        </button>
      </header>

      <!-- CONTENT -->
      <main class="p-6">
        <!-- WELCOME -->
        <section class="mb-8">
          <h2 class="text-4xl font-bold text-sky-700 text-center">Selamat Datang, <?= $_SESSION['nama'] ?></h2>
        </section>

        <?php if (isset($_GET['error']) && $_GET['error'] === 'nip_terdaftar') : ?>
          <p class="text-red-600 font-semibold">NIP sudah terdaftar. Silakan gunakan NIP lain.</p>
        <?php endif; ?>

        <?php if (isset($_SESSION['notif'])): ?>
          <script>
            alert("<?= $_SESSION['notif']; ?>");
          </script>
          <?php unset($_SESSION['notif']); ?>
        <?php endif; ?>

        <!-- TABEL ABSENSI -->
      <!-- TABEL ABSENSI -->
<section class="flex justify-center items-center flex-col mt-6 px-4">
  <h3 class="text-lg font-semibold mb-4 text-center text-sky-700">Riwayat Absensi Pegawai</h3>
  <div class="w-full max-w-5xl bg-white shadow-md rounded-lg overflow-x-auto">
    <table class="min-w-full divide-y divide-gray-200 text-sm">
      <thead class="bg-sky-500 text-white">
        <tr>
          <th class="px-6 py-3 text-left font-medium">Nama</th>
          <th class="px-6 py-3 text-left font-medium">Tanggal</th>
          <th class="px-6 py-3 text-left font-medium">Jam Masuk</th>
          <th class="px-6 py-3 text-left font-medium">Jam Keluar</th>
          <th class="px-6 py-3 text-left font-medium">Status</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-100">
        <?php while ($row = $absensi->fetch(PDO::FETCH_ASSOC)) : ?>
          <tr class="hover:bg-sky-50 transition">
            <td class="px-6 py-4"><?= $row['nama'] ?></td>
            <td class="px-6 py-4"><?= $row['tanggal'] ?></td>
            <td class="px-6 py-4"><?= $row['jamMasuk'] ?? '-' ?></td>
            <td class="px-6 py-4"><?= $row['jamKeluar'] ?? '-' ?></td>
            <td class="px-6 py-4"><?= $row['status'] ?></td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
</section>


  <!-- SCRIPT -->
  <script>
    feather.replace();
    function toggleSidebar() {
      const sidebar = document.getElementById('sidebar');
      sidebar.classList.toggle('hidden');
    }
  </script>

</body>

</html>
