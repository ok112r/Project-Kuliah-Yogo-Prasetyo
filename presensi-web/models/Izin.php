<?php
class Izin {
    private $conn;
    private $table = "izin";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function ajukanIzin($nip, $tanggal, $keterangan) {
        $stmt = $this->conn->prepare("INSERT INTO " . $this->table . " (nip, tanggal, keterangan) VALUES (?, ?, ?)");
        return $stmt->execute([$nip, $tanggal, $keterangan]);
    }

    public function getIzinByNip($nip) {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " WHERE nip = ? ORDER BY tanggal DESC");
        $stmt->execute([$nip]);
        return $stmt;
    }

    public function getSemuaIzin() {
        $stmt = $this->conn->prepare("SELECT * FROM " . $this->table . " ORDER BY tanggal DESC");
        $stmt->execute();
        return $stmt;
    }

    public function ubahStatus($id, $status) {
        $stmt = $this->conn->prepare("UPDATE " . $this->table . " SET status = ? WHERE id = ?");
        return $stmt->execute([$status, $id]);
    }

    public function getStatusById($id) {
    $stmt = $this->conn->prepare("SELECT status FROM " . $this->table . " WHERE id = ?");
    $stmt->execute([$id]);
    return $stmt->fetchColumn();
}

}?>