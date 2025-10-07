<!DOCTYPE html>
<html lang="id">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Feather Icon -->
  <script src="https://unpkg.com/feather-icons"></script>

  <!-- Tailwind CSS -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Font Poppins -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet" />

  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
  </style>

  <title>Form Izin</title>
</head>

<body class="bg-blue-50 min-h-screen flex flex-col">

  <!-- Tombol Kembali -->
  <div class="p-6">
    <a href="pegawai.php"
      class="inline-flex items-center gap-2 text-white bg-blue-600 hover:bg-blue-700 px-4 py-2 rounded-xl transition">
      <i data-feather="arrow-left" class="w-4 h-4"></i> Kembali
    </a>
  </div>

  <!-- Form -->
  <main class="flex-1 flex justify-center items-start px-4">
    <form method="POST" action="../../controllers/IzinController.php"
      class="bg-white shadow-lg rounded-2xl p-8 w-full max-w-xl mt-4">
      <h1 class="text-blue-700 font-bold text-2xl text-center mb-6">Form Izin Pegawai</h1>

      <!-- Input Tanggal -->
      <div class="mb-6">
        <label for="tanggal" class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
        <input type="date" name="tanggal" required
          class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500" />
      </div>

      <!-- Input Keterangan -->
      <div class="mb-6">
        <label for="keterangan" class="block text-sm font-medium text-gray-700 mb-1">Keterangan</label>
        <textarea name="keterangan" rows="4" required
          class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
      </div>

      <!-- Tombol Submit -->
      <div class="text-center">
        <button type="submit"
          class="bg-blue-600 text-white px-6 py-2 rounded-xl font-semibold hover:bg-blue-700 transition">
          Ajukan Izin
        </button>
      </div>
    </form>
  </main>

  <!-- Feather Icons -->
  <script>
    feather.replace();
  </script>

</body>

</html>
