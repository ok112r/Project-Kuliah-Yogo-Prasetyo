<?php
session_start();
if (!isset($_SESSION['nip']) || $_SESSION['jabatan'] !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Tambah Pegawai</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 min-h-screen flex">

  <!-- Sidebar -->
  <aside class="w-64 bg-sky-700 text-white min-h-screen p-6 shadow-lg">
    <h2 class="text-2xl font-bold mb-8">Dashboard Admin</h2>
    <nav class="flex flex-col gap-4">
      <a href="admin.php" class="hover:bg-sky-600 px-3 py-2 rounded transition">Dashboard</a>
      <a href="tambah.php" class="hover:bg-sky-600 px-3 py-2 rounded transition bg-sky-600">Tambah Pegawai</a>
      <a href="daftarIzin.php" class="hover:bg-sky-600 px-3 py-2 rounded transition">Daftar Izin Pegawai</a>
      <a href="../../controllers/logout.php" class="hover:bg-sky-600 px-3 py-2 rounded transition">Logout</a>
    </nav>
  </aside>

  <!-- Main Content -->
  <main class="flex-1 p-10">
    <div class="max-w-xl mx-auto bg-white shadow-md rounded-lg p-6">
      <h2 class="text-xl font-semibold text-sky-800 mb-6">Tambah Pegawai</h2>

      <form method="post" action="../../controllers/UserController.php" class="space-y-4">
        <div>
          <label class="block font-medium text-gray-700 mb-1">NIP:</label>
          <input type="text" name="nip" required
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500" />
        </div>

        <div>
          <label class="block font-medium text-gray-700 mb-1">Nama:</label>
          <input type="text" name="nama" required
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500" />
        </div>

        <div>
          <label class="block font-medium text-gray-700 mb-1">Password:</label>
          <input type="password" name="password" required
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500" />
        </div>

        <div>
          <label class="block font-medium text-gray-700 mb-1">Jabatan:</label>
          <select name="jabatan"
            class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-sky-500">
            <option value="pegawai">Pegawai</option>
            <option value="admin">Admin</option>
          </select>
        </div>

        <div class="flex justify-between mt-6">
          <a href="admin.php"
            class="inline-block bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold px-4 py-2 rounded-lg transition">Kembali</a>
          <button type="submit" name="tambah"
            class="bg-sky-600 hover:bg-sky-700 text-white font-semibold px-6 py-2 rounded-lg transition">
            Tambah
          </button>
        </div>
      </form>
    </div>
  </main>

</body>

</html>
