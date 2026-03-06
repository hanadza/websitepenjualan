<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: GET");

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    http_response_code(405);
    echo json_encode(["message" => "Method tidak diizinkan."]);
    exit;
}

include_once '../config/Database.php';
include_once '../models/Penjualan.php';

$database = new Database();
$db = $database->getConnection();
$penjualan = new Penjualan($db);

$stmt = $penjualan->read();
$num = $stmt->rowCount();

if ($num > 0) {
    $data_arr = array();
    while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
        extract($row);
        $item = array(
            "id" => $id,
            "nama_produk" => $nama_produk,
            "jumlah" => $jumlah,
            "harga_satuan" => $harga_satuan,
            "total_harga" => $total_harga,
            "tanggal" => $tanggal
        );
        array_push($data_arr, $item);
    }
    http_response_code(200);
    echo json_encode($data_arr);
} else {
    http_response_code(404);
    echo json_encode(["message" => "Data tidak ditemukan."]);
}
?>