<?php
session_start();

require_once '../../config/Database.php';
require_once '../../models/Absensi.php';
require_once '../../models/Izin.php';


if (!isset($_SESSION['nip']) || $_SESSION['jabatan'] !== 'pegawai') {
    header("Location: ../auth/login.php");
    exit();
}

$db = (new Database())->getConnection();
$absensiModel = new Absensi($db);
$riwayat = $absensiModel->getByNip($_SESSION['nip']);

// UNTUK IZIN PEGAWAI
$izinModel = new Izin($db);
$izinSaya = $izinModel->getIzinByNip($_SESSION['nip']);

?>
<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />

  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
  </style>

  <?php if (isset($_SESSION['notif'])): ?>
    <script>alert("<?= $_SESSION['notif']; ?>");</script>
    <?php unset($_SESSION['notif']); ?>
  <?php endif; ?>

  <title>Dashboard Pegawai</title>
</head>

<body class="bg-blue-50 min-h-screen flex">

  <!-- Sidebar -->
  <aside class="w-64 min-h-screen bg-blue-600 text-white hidden md:flex flex-col justify-between">
    <div>
      <div class="p-6 text-center font-bold text-xl">Absensi Pegawai</div>
      <nav class="px-4 flex flex-col gap-2">
        <div class="text-sm mb-4">Halo, <span class="font-semibold"><?= $_SESSION['nama'] ?></span></div>
        <a href="#" class="px-4 py-2 rounded-lg hover:bg-blue-700">Dashboard</a>
        <a href="formIzin.php" class="px-4 py-2 rounded-lg hover:bg-blue-700">Izin</a>
        <a href="rekap.php" class="px-4 py-2 rounded-lg hover:bg-blue-700">Lihat Rekap</a>
      </nav>
    </div>
    <div class="p-4">
      <a href="../../controllers/logout.php"
        class="flex items-center gap-2 text-sm text-red-200 hover:text-white transition">
        <i data-feather="log-out" class="w-4 h-4"></i> Logout
      </a>
    </div>
  </aside>

  <!-- Main Content -->
  <div class="flex-1 p-6">
    <!-- Header Mobile -->
    <div class="md:hidden mb-4">
      <h1 class="text-xl font-bold text-blue-700">Dashboard Pegawai</h1>
      <p class="text-sm">Halo, <strong><?= $_SESSION['nama'] ?></strong></p>
    </div>

    <!-- Waktu -->
    <div class="mb-6">
      <h2 class="text-xl font-semibold text-blue-700 mb-2">Selamat Datang 👋</h2>
      <p class="text-sm">Waktu Saat Ini: <span id="clock" class="font-bold"></span></p>
    </div>

    <!-- Aksi Absensi -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-10">
      <form method="post" action="../../controllers/AbsensiController.php">
        <button type="submit"
          class="w-full bg-blue-500 text-white py-3 rounded-xl hover:bg-blue-600 transition font-semibold">
          Absen Masuk
        </button>
      </form>
      <form method="post" action="../../controllers/AbsenKeluarController.php" onsubmit="return confirmCheckout();">
        <button type="submit"
          class="w-full bg-blue-500 text-white py-3 rounded-xl hover:bg-blue-600 transition font-semibold">
          Absen Keluar
        </button>
      </form>
      <a href="formIzin.php"
        class="w-full block bg-blue-500 text-white text-center py-3 rounded-xl hover:bg-blue-600 transition font-semibold">
        Ajukan Izin
      </a>
    </div>

    <!-- Tabel Riwayat -->
    <div class="bg-white shadow rounded-lg p-4 overflow-x-auto">
      <h3 class="text-lg font-semibold text-blue-700 mb-4">Riwayat Absensi</h3>
      <table class="w-full table-auto text-sm">
        <thead class="bg-blue-100 text-blue-800">
          <tr>
            <th class="px-4 py-2 text-left">Tanggal</th>
            <th class="px-4 py-2 text-left">Jam Masuk</th>
            <th class="px-4 py-2 text-left">Jam Keluar</th>
          </tr>
        </thead>
        <tbody class="divide-y">
          <?php while ($row = $riwayat->fetch(PDO::FETCH_ASSOC)) : ?>
            <tr class="hover:bg-blue-50">
              <td class="px-4 py-2"><?= $row['tanggal'] ?></td>
              <td class="px-4 py-2"><?= $row['jamMasuk'] ?></td>
              <td class="px-4 py-2"><?= $row['jamKeluar'] ?: '-' ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </div>

  <script src="../../public/js/clock.js"></script>
  <script src="https://unpkg.com/feather-icons"></script>
  <script>
    feather.replace();

    function confirmCheckout() {
      const now = new Date();
      const jam = now.getHours();
      if (jam < 16) {
        return confirm("Anda mencoba absen keluar sebelum pukul 16:00. Lanjutkan?");
      }
      return true;
    }
  </script>
</body>

</html>
