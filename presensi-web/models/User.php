<?php
class User {
    private $conn;
    private $table = "users";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function login($nip, $password) {
        $query = "SELECT * FROM " . $this->table . " WHERE nip = :nip LIMIT 1";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(":nip", $nip);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }
        return false;
    }

    public function getAllPegawai() {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " WHERE jabatan = 'pegawai'");
        $stmt->execute();
        return $stmt;
    }

    public function getByNip($nip) {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " WHERE nip = ? LIMIT 1");
        $stmt->execute([$nip]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($nip, $nama, $password, $jabatan) {
    // Cek apakah NIP sudah ada
    $cek = $this->conn->prepare("SELECT nip FROM " . $this->table . " WHERE nip = ?");
    $cek->execute([$nip]);
    if ($cek->rowCount() > 0) {
        return false; // NIP sudah ada
    }

    // Jika belum ada, lanjut insert
    $hashed = password_hash($password, PASSWORD_DEFAULT);
    $stmt = $this->conn->prepare("INSERT INTO " . $this->table . " (nip, nama, password, jabatan) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$nip, $nama, $hashed, $jabatan]);
}


    public function update($nip, $nama, $jabatan) {
        $stmt = $this->conn->prepare("UPDATE " . $this->table . " SET nama = ?, jabatan = ? WHERE nip = ?");
        return $stmt->execute([$nama, $jabatan, $nip]);
    }

    public function delete($nip) {
        $stmt = $this->conn->prepare("DELETE FROM " . $this->table . " WHERE nip = ?");
        return $stmt->execute([$nip]);
    }
}
?>