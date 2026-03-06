<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: PUT");

if ($_SERVER['REQUEST_METHOD'] !== 'PUT') {
    http_response_code(405);
    echo json_encode(["message" => "Method tidak diizinkan."]);
    exit;
}

include_once '../config/Database.php';
include_once '../models/Penjualan.php';

$database = new Database();
$db = $database->getConnection();
$penjualan = new Penjualan($db);

$data = json_decode(file_get_contents("php://input"));

if (!empty($data->id) && !empty($data->nama_produk) && !empty($data->jumlah) && !empty($data->harga_satuan)) {
    $penjualan->id = $data->id;
    $penjualan->nama_produk = $data->nama_produk;
    $penjualan->jumlah = $data->jumlah;
    $penjualan->harga_satuan = $data->harga_satuan;

    if ($penjualan->update()) {
        http_response_code(200);
        echo json_encode(["message" => "Data berhasil diperbarui."]);
    } else {
        http_response_code(503);
        echo json_encode(["message" => "Gagal memperbarui data."]);
    }
} else {
    http_response_code(400);
    echo json_encode(["message" => "Data tidak lengkap."]);
}
?>