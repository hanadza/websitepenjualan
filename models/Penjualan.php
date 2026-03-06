<?php
class Penjualan {
    private $conn;
    private $table_name = "penjualan";

    public $id;
    public $nama_produk;
    public $jumlah;
    public $harga_satuan;
    // total_harga otomatis dihitung di database

    public function __construct($db) {
        $this->conn = $db;
    }

    // READ all data
    public function read() {
        $query = "SELECT * FROM " . $this->table_name . " ORDER BY id DESC";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt;
    }

    // CREATE new record
    public function create() {
        $query = "INSERT INTO " . $this->table_name . " (nama_produk, jumlah, harga_satuan) VALUES (?, ?, ?)";
        // tanggal otomatis diisi default
        $stmt = $this->conn->prepare($query);
        return $stmt->execute([$this->nama_produk, $this->jumlah, $this->harga_satuan]);
    }   

    // UPDATE record
    public function update() {
        $query = "UPDATE " . $this->table_name . " SET nama_produk = ?, jumlah = ?, harga_satuan = ? WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute([$this->nama_produk, $this->jumlah, $this->harga_satuan, $this->id])) {
            return true;
        }
        return false;
    }

    // DELETE record
    public function delete() {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        if ($stmt->execute([$this->id])) {
            return true;
        }
        return false;
    }
}
?>