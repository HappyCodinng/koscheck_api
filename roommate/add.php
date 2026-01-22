<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST");
header("Content-Type: application/json");

require_once __DIR__ . "/../config/database.php";

$data = json_decode(file_get_contents("php://input"), true);

$nama = trim($data['nama'] ?? '');
$umur = trim($data['umur'] ?? '');
$kampus = trim($data['kampus'] ?? '');
$jenis_kelamin = trim($data['jenis_kelamin'] ?? '');
$deskripsi = trim($data['deskripsi'] ?? '');

if ($nama === '' || $umur === '' || $kampus === '' || $jenis_kelamin === '') {
  echo json_encode([
    "status" => false,
    "message" => "Semua data wajib diisi"
  ]);
  exit;
}

$stmt = $conn->prepare(
  "INSERT INTO roommate (nama, umur, kampus, jenis_kelamin, deskripsi)
   VALUES (?, ?, ?, ?, ?)"
);

$stmt->bind_param(
  "sisss",
  $nama,
  $umur,
  $kampus,
  $jenis_kelamin,
  $deskripsi
);

if ($stmt->execute()) {
  echo json_encode([
    "status" => true,
    "message" => "Roommate berhasil ditambahkan"
  ]);
} else {
  echo json_encode([
    "status" => false,
    "message" => "Gagal menambahkan data"
  ]);
}
