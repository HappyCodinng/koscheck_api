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


$jenis_kelamin = $_GET['jenis_kelamin'] ?? null;

$sql = "SELECT r.id, u.nama, u.email, u.no_hp, r.kampus, r.jenis_kelamin, r.umur, r.deskripsi 
        FROM roommate r
        LEFT JOIN user u ON r.id_user = u.id_user";

if ($jenis_kelamin && $jenis_kelamin !== "Semua") {
  $sql .= " WHERE jenis_kelamin = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $jenis_kelamin);
  $stmt->execute();
  $result = $stmt->get_result();
} else {
  $sql .= " ORDER BY r.created_at DESC";
  $result = mysqli_query($conn, $sql);
}

if (!$result) {
  echo json_encode([
    "status" => false,
    "message" => mysqli_error($conn)
  ]);
  exit;
}

$data = [];
while ($row = mysqli_fetch_assoc($result)) {
  $data[] = $row;
}

echo json_encode([
  "status" => true,
  "data" => $data
]);
