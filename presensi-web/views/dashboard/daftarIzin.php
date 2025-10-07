<?php
require_once '../../config/Database.php';
require_once '../../models/Izin.php';

$db = (new Database())->getConnection();
$izinModel = new Izin($db);
$izinList = $izinModel->getSemuaIzin();
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Daftar Izin Pegawai</title>
  <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100 font-sans min-h-screen">

  <!-- Kotak Navigasi Kembali -->
  <div class="max-w-5xl mx-auto mt-6">
    <div class="bg-white shadow-md rounded-lg px-4 py-3 w-fit">
      <a href="admin.php" class="text-sky-600 font-medium hover:underline flex items-center">
        &larr; Kembali ke Dashboard
      </a>
    </div>
  </div>

  <!-- Judul -->
  <h3 class="text-2xl font-semibold text-center text-sky-800 mt-8 mb-6">Data Izin Pegawai</h3>

  <!-- Tabel Izin -->
  <div class="overflow-x-auto bg-white shadow-md rounded-lg w-full max-w-5xl mx-auto">
    <table class="min-w-full divide-y divide-gray-200 text-sm">
      <thead class="bg-sky-500 text-white">
        <tr>
          <th class="px-6 py-3 text-left font-medium">NIP</th>
          <th class="px-6 py-3 text-left font-medium">Tanggal</th>
          <th class="px-6 py-3 text-left font-medium">Keterangan</th>
          <th class="px-6 py-3 text-left font-medium">Status</th>
          <th class="px-6 py-3 text-left font-medium">Aksi</th>
        </tr>
      </thead>
      <tbody class="bg-white divide-y divide-gray-100">
        <?php while ($izin = $izinList->fetch(PDO::FETCH_ASSOC)) : ?>
          <tr class="hover:bg-sky-50 transition">
            <td class="px-6 py-4"><?= htmlspecialchars($izin['nip']) ?></td>
            <td class="px-6 py-4"><?= htmlspecialchars($izin['tanggal']) ?></td>
            <td class="px-6 py-4"><?= htmlspecialchars($izin['keterangan']) ?></td>
            <td class="px-6 py-4"><?= htmlspecialchars($izin['status']) ?></td>
            <td class="px-6 py-4">
              <form method="POST" action="../../controllers/IzinController.php" class="flex flex-col sm:flex-row gap-2">
                <input type="hidden" name="id" value="<?= $izin['id'] ?>" />
                <?php if ($izin['status'] === 'pending') : ?>
                  <input type="hidden" name="aksi" value="disetujui">
                  <button type="submit"
                    class="bg-green-500 text-white px-3 py-1 rounded hover:bg-green-600 text-sm">Terima</button>
                  <input type="hidden" name="aksi" value="ditolak">
                  <button type="submit"
                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 text-sm">Tolak</button>
                <?php else : ?>
                  <select name="aksi"
                    class="border border-gray-300 rounded px-2 py-1 text-sm focus:ring-sky-500 focus:border-sky-500">
                    <option value="disetujui" <?= $izin['status'] === 'disetujui' ? 'selected' : '' ?>>Disetujui</option>
                    <option value="ditolak" <?= $izin['status'] === 'ditolak' ? 'selected' : '' ?>>Ditolak</option>
                    <option value="pending" <?= $izin['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                  </select>
                  <button type="submit"
                    class="bg-sky-500 text-white px-3 py-1 rounded hover:bg-sky-600 text-sm">Ubah</button>
                <?php endif; ?>
              </form>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

</body>

</html>
