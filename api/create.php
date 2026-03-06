<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
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

if (!empty($data->nama_produk) && !empty($data->jumlah) && !empty($data->harga_satuan)) {
    $penjualan->nama_produk = $data->nama_produk;
    $penjualan->jumlah = $data->jumlah;
    $penjualan->harga_satuan = $data->harga_satuan;

    if ($penjualan->create()) {
        http_response_code(201);
        echo json_encode(["message" => "Data penjualan berhasil ditambahkan."]);
    } else {
        http_response_code(503);
        echo json_encode(["message" => "Gagal menambahkan data."]);
    }
} else {
    http_response_code(400);
    echo json_encode(["message" => "Data tidak lengkap."]);
}
?>