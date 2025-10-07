<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- TAILWIND CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- POPPINS FONT -->
  <link href="https://fonts.googleapis.com/css2?family=Poppins&display=swap" rel="stylesheet">

  <style>
    body {
      font-family: 'Poppins', sans-serif;
    }
  </style>

  <title>Login</title>
</head>

<body class="min-h-screen bg-cover bg-center flex items-center justify-center px-4"
  style="background-image: url('https://images.unsplash.com/photo-1581091215367-7a625e5d6a29?ixlib=rb-4.0.3&auto=format&fit=crop&w=1650&q=80');">

  <!-- Overlay -->
  <div class="absolute inset-0 bg-black bg-opacity-40 z-0"></div>

  <!-- LOGIN FORM -->
  <form method="post" action="../../controllers/AuthController.php"
    class="relative z-10 bg-white bg-opacity-90 shadow-lg rounded-xl w-full max-w-sm p-8 space-y-6 backdrop-blur">
    <h2 class="text-center text-3xl font-bold text-blue-700">Absensi Web</h2>
    <p class="text-center text-gray-600">Silakan login untuk melanjutkan</p>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">NIP</label>
      <input type="text" name="nip" required placeholder="Masukkan NIP"
        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" />
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-1">Password</label>
      <input type="password" name="password" required placeholder="Masukkan Password"
        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition" />
    </div>

    <button type="submit"
      class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-2 rounded-lg transition">
      Login
    </button>
  </form>

</body>

</html>
