<?php
session_start();
require_once '../../config/Database.php';
require_once '../../models/User.php';

if (!isset($_SESSION['edit_nip']) || $_SESSION['jabatan'] !== 'admin') {
    header("Location: admin.php");
    exit();
}

$db = (new Database())->getConnection();
$userModel = new User($db);
$user = $userModel->getByNip($_SESSION['edit_nip']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Pegawai</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 flex min-h-screen">

  <!-- Sidebar -->
  <aside class="w-64 bg-sky-700 text-white min-h-screen p-6 shadow-lg">
    <h2 class="text-2xl font-bold mb-10">Dashboard Admin</h2>
    <nav class="flex flex-col gap-4 text-base">
      <a href="admin.php" class="hover:bg-sky-600 px-4 py-2 rounded transition">Dashboard</a>
      <a href="tambah.php" class="hover:bg-sky-600 px-4 py-2 rounded transition">Tambah Pegawai</a>
      <a href="daftarIzin.php" class="hover:bg-sky-600 px-4 py-2 rounded transition">Daftar Izin Pegawai</a>
      <a href="../../controllers/logout.php" class="hover:bg-sky-600 px-4 py-2 rounded transition">Logout</a>
    </nav>
  </aside>

  <!-- Main Content -->
  <main class="flex-1 p-10">
    <div class="max-w-2xl mx-auto bg-white shadow-lg rounded-xl p-8">
      <h2 class="text-2xl font-bold text-sky-800 mb-6">Edit Pegawai</h2>

      <form method="post" action="../../controllers/UserController.php" class="space-y-5">
        <input type="hidden" name="nip" value="<?= $user['nip'] ?>">

        <div>
          <label class="block font-medium text-gray-700 mb-1">Nama</label>
          <input type="text" name="nama" value="<?= $user['nama'] ?>" required
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 outline-none" />
        </div>

        <div>
          <label class="block font-medium text-gray-700 mb-1">Jabatan</label>
          <select name="jabatan"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-sky-500 outline-none">
            <option value="pegawai" <?= $user['jabatan'] == 'pegawai' ? 'selected' : '' ?>>Pegawai</option>
            <option value="admin" <?= $user['jabatan'] == 'admin' ? 'selected' : '' ?>>Admin</option>
          </select>
        </div>

        <div class="flex justify-end gap-4 pt-4">
          <a href="admin.php"
            class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-5 py-2 rounded-lg transition">Kembali</a>
          <button type="submit" name="update"
            class="bg-sky-600 hover:bg-sky-700 text-white font-semibold px-6 py-2 rounded-lg transition">
            Update
          </button>
        </div>
      </form>
    </div>
  </main>

</body>

</html>
