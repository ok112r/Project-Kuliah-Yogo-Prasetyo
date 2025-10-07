<?php
session_start();
if (!isset($_SESSION['nip'])) {
    header("Location: login.php");
    exit;
}

require_once '../../config/Database.php';
require_once '../../models/Absensi.php';
require_once '../../models/User.php';

$db = (new Database())->getConnection();
$absensi = new Absensi($db);
$user = new User($db);

$nip = $_SESSION['nip'];
$periode = $_GET['periode'] ?? 'mingguan'; // Default rekap mingguan
$rekapData = $absensi->getRekap($nip, $periode);

$totalMasuk = 0;
$totalTerlambat = 0;
$jamMasukList = [];
$jamKeluarList = [];

while ($row = $rekapData->fetch(PDO::FETCH_ASSOC)) {
    $totalMasuk++;
    if ($row['status'] === 'terlambat') {
        $totalTerlambat++;
    }
    if ($row['jamMasuk']) {
        $jamMasukList[] = strtotime($row['jamMasuk']);
    }
    if ($row['jamKeluar'] && $row['jamKeluar'] !== '00:00:00') {
        $jamKeluarList[] = strtotime($row['jamKeluar']);
    }
}

// Hitung rata-rata jam masuk dan keluar
function averageTime($timestamps) {
    if (count($timestamps) === 0) return '-';
    $avg = array_sum($timestamps) / count($timestamps);
    return date('H:i:s', round($avg));
}

$rataMasuk = averageTime($jamMasukList);
$rataKeluar = averageTime($jamKeluarList);
$nama = $user->getByNip($nip)['nama'];
?>

<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <title>Rekap Absensi - <?= htmlspecialchars($nama) ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />
  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
  </style>
</head>

<body class="bg-blue-50 min-h-screen">
  <div class="max-w-7xl mx-auto p-6">
    
    <!-- Header & Filter -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
      <h1 class="text-3xl font-bold text-blue-700">Rekap Absensi - <?= ucfirst($periode) ?></h1>
      <div class="flex items-center space-x-3 mt-4 sm:mt-0">
        <a href="?periode=mingguan"
          class="px-4 py-2 rounded-lg text-white bg-blue-600 hover:bg-blue-700 transition <?= $periode === 'mingguan' ? 'font-bold' : '' ?>">Mingguan</a>
        <a href="?periode=bulanan"
          class="px-4 py-2 rounded-lg text-white bg-green-600 hover:bg-green-700 transition <?= $periode === 'bulanan' ? 'font-bold' : '' ?>">Bulanan</a>
        <a href="Pegawai.php"
          class="text-sm text-blue-700 underline hover:text-blue-900 ml-2">← Kembali</a>
      </div>
    </div>

    <!-- Statistik Ringkas -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-10">
      <div class="bg-white shadow rounded-2xl p-5 text-center border border-blue-100">
        <p class="text-gray-500 text-sm mb-2">Total Hari Masuk</p>
        <p class="text-2xl font-bold text-blue-700"><?= $totalMasuk ?></p>
      </div>
      <div class="bg-white shadow rounded-2xl p-5 text-center border border-blue-100">
        <p class="text-gray-500 text-sm mb-2">Jumlah Terlambat</p>
        <p class="text-2xl font-bold text-blue-700"><?= $totalTerlambat ?></p>
      </div>
      <div class="bg-white shadow rounded-2xl p-5 text-center border border-blue-100">
        <p class="text-gray-500 text-sm mb-2">Rata-rata Masuk</p>
        <p class="text-2xl font-bold text-blue-700"><?= $rataMasuk ?></p>
      </div>
      <div class="bg-white shadow rounded-2xl p-5 text-center border border-blue-100">
        <p class="text-gray-500 text-sm mb-2">Rata-rata Keluar</p>
        <p class="text-2xl font-bold text-blue-700"><?= $rataKeluar ?></p>
      </div>
    </div>

    <!-- Tabel Detail Absensi -->
    <div class="bg-white p-6 rounded-2xl shadow-lg border border-blue-100">
      <h2 class="text-xl font-semibold text-blue-800 mb-4">Detail Absensi</h2>
      <div class="overflow-x-auto">
        <table class="min-w-full text-sm border">
          <thead class="bg-blue-600 text-white">
            <tr>
              <th class="px-4 py-2 border">Tanggal</th>
              <th class="px-4 py-2 border">Jam Masuk</th>
              <th class="px-4 py-2 border">Jam Keluar</th>
              <th class="px-4 py-2 border">Status</th>
            </tr>
          </thead>
          <tbody class="bg-white">
            <?php
            $rekapData = $absensi->getRekap($nip, $periode);
            while ($row = $rekapData->fetch(PDO::FETCH_ASSOC)) {
              echo "<tr class='text-center even:bg-blue-50'>";
              echo "<td class='border px-4 py-2'>{$row['tanggal']}</td>";
              echo "<td class='border px-4 py-2'>{$row['jamMasuk']}</td>";
              echo "<td class='border px-4 py-2'>" . ($row['jamKeluar'] !== '00:00:00' ? $row['jamKeluar'] : '-') . "</td>";
              echo "<td class='border px-4 py-2'>" . ($row['status'] ?? '-') . "</td>";
              echo "</tr>";
            }
            ?>
          </tbody>
        </table>
      </div>
    </div>

  </div>
</body>

</html>
