document.addEventListener("DOMContentLoaded", function () {
    function updateClock() {
        const now = new Date();
        const jam = String(now.getHours()).padStart(2, '0');
        const menit = String(now.getMinutes()).padStart(2, '0');
        const detik = String(now.getSeconds()).padStart(2, '0');
        const waktu = `${jam}:${menit}:${detik}`;
        const elemen = document.getElementById("clock");
        if (elemen) {
            elemen.textContent = waktu;
        }
    }

    setInterval(updateClock, 1000);
    updateClock(); // Jalankan sekali saat halaman dimuat
});
