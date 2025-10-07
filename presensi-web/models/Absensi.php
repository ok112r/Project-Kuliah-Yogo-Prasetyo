<?php
// ======== models/Absensi.php ========
date_default_timezone_set('Asia/Jakarta');

class Absensi {
    private $conn;
    private $table = "absensi";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function absenMasuk($nip) {
        $tanggal = date("Y-m-d");

        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " WHERE nipUsers = ? AND tanggal = ?");
        $stmt->execute([$nip, $tanggal]);
        if ($stmt->rowCount() > 0) {
            return false; // Sudah absen hari ini
        }

        $waktu = date("H:i:s");
        $status = (strtotime($waktu) > strtotime("08:00:00")) ? 'terlambat' : 'tepat waktu';

         // Simpan ke session untuk notifikasi jika terlambat
        if ($status === 'terlambat') {
            $_SESSION['notif'] = "Anda terlambat melakukan absen masuk.";
        }
        $stmt = $this->conn->prepare("INSERT INTO " . $this->table . " (nipUsers, tanggal, jamMasuk, status) VALUES (?, ?, ?, ?)");
        return $stmt->execute([$nip, $tanggal, $waktu, $status]);
    }

    public function absenKeluar($nip) {
        $tanggal = date("Y-m-d");
        $jam_keluar = date("H:i:s");

        $jam_keluar_now = strtotime($jam_keluar);

        // Tidak bisa absen keluar sebelum jam 16:00:00
        if ($jam_keluar_now < strtotime("16:00:00")) {
            $_SESSION['notif'] = "Absen keluar hanya dapat dilakukan setelah pukul 16:00.";
            return false;
        }

        $stmt = $this->conn->prepare("UPDATE " . $this->table . " SET jamKeluar = ? WHERE nipUsers = ? AND tanggal = ?");
        return $stmt->execute([$jam_keluar, $nip, $tanggal]);
    }

    public function getByNip($nip) {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " WHERE nipUsers = ? ORDER BY tanggal DESC");
        $stmt->execute([$nip]);
        return $stmt;
    }

    public function getRekap($nip, $periode = 'mingguan') {
        $where = $periode === 'bulanan' ? 'DATE_FORMAT(tanggal, "%Y-%m") = DATE_FORMAT(NOW(), "%Y-%m")' : 'YEARWEEK(tanggal, 1) = YEARWEEK(NOW(), 1)';
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " WHERE nipUsers = ? AND $where ORDER BY tanggal DESC");
        $stmt->execute([$nip]);
        return $stmt;
    }

    public function getTerlambatAll() {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " WHERE status = 'terlambat' ORDER BY tanggal DESC");
        $stmt->execute();
        return $stmt;
    }

    public function getAllAbsensi() {
        $stmt = $this->conn->prepare("SELECT a.*, u.nama FROM " . $this->table . " a JOIN users u ON a.nipUsers = u.nip ORDER BY a.tanggal DESC");
        $stmt->execute();
        return $stmt;
    }
}

?>
