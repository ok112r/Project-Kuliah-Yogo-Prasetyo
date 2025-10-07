<?php
session_start();
require_once '../../config/Database.php';
require_once '../../models/User.php';
require_once '../../models/Izin.php';

if (!isset($_SESSION['nip']) || $_SESSION['jabatan'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

$db = (new Database())->getConnection();
$userModel = new User($db);
$users = $userModel->getAllPegawai();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Dashboard Admin</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans min-h-screen flex">

  <!-- Sidebar -->
  <aside class="w-64 bg-sky-700 text-white min-h-screen p-6 shadow-lg">
    <h2 class="text-2xl font-bold mb-8">Dashboard Admin</h2>
    <nav class="flex flex-col gap-4">
      <a href="admin.php" class="hover:bg-sky-600 px-3 py-2 rounded transition">Dashboard</a>
      <a href="tambah.php" class="hover:bg-sky-600 px-3 py-2 rounded transition">Tambah Pegawai</a>
      <a href="daftarIzin.php" class="hover:bg-sky-600 px-3 py-2 rounded transition">Daftar Izin Pegawai</a>
      <a href="../../controllers/logout.php" class="hover:bg-sky-600 px-3 py-2 rounded transition">Logout</a>
    </nav>
  </aside>

  <!-- Main Content -->
  <main class="flex-1 p-6">
    <!-- Greeting -->
    <div class="bg-white shadow-md rounded-lg px-6 py-4 mb-6">
      <h2 class="text-xl font-semibold text-sky-700">Selamat Datang, <?= $_SESSION['nama'] ?></h2>
    </div>

    <!-- Error Notification -->
    <?php if (isset($_GET['error']) && $_GET['error'] === 'nip_terdaftar') : ?>
      <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-4">
        NIP sudah terdaftar. Silakan gunakan NIP lain.
      </div>
    <?php endif; ?>

    <!-- JS Notification -->
    <?php if (isset($_SESSION['notif'])) : ?>
      <script>
        alert("<?= $_SESSION['notif']; ?>");
      </script>
      <?php unset($_SESSION['notif']); ?>
    <?php endif; ?>

    <!-- Tabel Daftar Pegawai -->
    <div class="bg-white shadow-md rounded-lg overflow-x-auto mt-4 max-w-5xl mx-auto">
      <h3 class="text-lg font-semibold text-center text-sky-800 py-4">Daftar Pegawai</h3>
      <table class="min-w-full divide-y divide-gray-200 text-sm">
        <thead class="bg-sky-500 text-white">
          <tr>
            <th class="px-6 py-3 text-left font-medium">NIP</th>
            <th class="px-6 py-3 text-left font-medium">Nama</th>
            <th class="px-6 py-3 text-left font-medium">Jabatan</th>
            <th class="px-6 py-3 text-left font-medium">Aksi</th>
          </tr>
        </thead>
        <tbody class="bg-white divide-y divide-gray-100">
          <?php while ($row = $users->fetch(PDO::FETCH_ASSOC)) : ?>
            <tr class="hover:bg-gray-50 transition">
              <td class="px-6 py-4"><?= $row['nip'] ?></td>
              <td class="px-6 py-4"><?= $row['nama'] ?></td>
              <td class="px-6 py-4"><?= $row['jabatan'] ?></td>
              <td class="px-6 py-4 space-x-2">
                <form method="post" action="../../controllers/UserController.php" class="inline">
                  <input type="hidden" name="nip" value="<?= $row['nip'] ?>">
                  <input type="submit" name="hapus" value="Hapus"
                    onclick="return confirm('Yakin?')"
                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-sm" />
                </form>
                <form method="get" action="../../controllers/UserController.php" class="inline">
                  <input type="hidden" name="edit" value="<?= $row['nip'] ?>">
                  <input type="submit" value="Edit"
                    class="bg-yellow-400 text-white px-3 py-1 rounded hover:bg-yellow-500 text-sm" />
                </form>
              </td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  </main>

</body>

</html>
