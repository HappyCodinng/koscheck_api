<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: Content-Type");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Content-Type: application/json");

if($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  http_response_code(200);
  exit;
}

require_once __DIR__ . "/../config/database.php";

$data = json_decode(file_get_contents("php://input"), true);

/*if (!data) {
  echo json_encode([
    "success" => false,
    "message" => "Data JSON tidak valid"
  ]);
  exit;
}*/


$nama = trim($data['nama'] ?? '');
$email = trim($data['email'] ?? '');
$nohp = trim($data['no_hp'] ?? '');
$password = trim($data['password'] ?? '');

if ($nama === '' || $email === '' || $nohp === '' || $password === '') {
  echo json_encode([
    "success" => false,
    "message" => "Semua field wajib diisi"
  ]);
  exit;
}

if(strlen($password) < 6) {
  echo json_encode([
    "success" => false,
    "message" => "Password minimal 6 karakter"
  ]);
  exit;
}

$check = $conn->prepare("SELECT id_user FROM `user` WHERE email=?");
$check->bind_param("s", $email);
$check->execute();
$check->store_result();

if($check->num_rows > 0) {
  echo json_encode([
    "success" => false,
    "message" => "Email sudah terdaftar"
  ]);
  exit;
}

$hash = password_hash($password, PASSWORD_DEFAULT);

$stmt = $conn->prepare(
  "INSERT INTO user (nama, email, no_hp, password, created_at)
  VALUES (?, ?, ?, ?, NOW())"
);

$stmt->bind_param("ssss", $nama, $email, $nohp, $hash);

if($stmt->execute()) {
  echo json_encode([
    "success" => true,
    "message" => "Registrasi berhasil"
  ]);
} else {
  echo json_encode([
    "success" => false,
    "message" => "Registrasi gagal"
  ]);
}