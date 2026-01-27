<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json; charset=UTF-8");

if($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
  http_response_code(200);
  exit;
}

require_once __DIR__ . "/../config/database.php";

$id_user_login = $_GET['id'] ?? 0;
$jenis_kelamin = $_GET['jenis_kelamin'] ?? null;

$sql = "SELECT u.id, u.nama, r.umur, r.kampus, r.jenis_kelamin, r.deskripsi 
        FROM users u
        INNER JOIN roommate r ON u.id = r.id_user
        WHERE u.id != ?";

if ($jenis_kelamin && $jenis_kelamin !== "Semua") {
  $sql .= " AND r.jenis_kelamin = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("is", $id_user_login, $jenis_kelamin);
} else {
  $stmt = $conn->prepare($sql);
  $stmt -> bind_param("i", $id_user_login);
}

$stmt->execute();
$result = $stmt->get_result();

$data = [];
while ($row = $result->fetch_assoc()) {
  $data[] = $row;
}

echo json_encode([
  "status" => true,
  "data" => $data
]);
