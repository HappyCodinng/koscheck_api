<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . "/../config/database.php";

$headers = getallheaders();
$auth = $headers['Authorization'] ?? '';

if (!$auth) {
    echo json_encode([
        "success" => false,
        "message" => "Token tidak ada"
    ]);
    exit;
}

$token = str_replace("Bearer ", "", $auth);
$user_id = intval($token);

$stmt = $conn->prepare(
    "SELECT id, nama, email, no_hp, created_at FROM user WHERE id = ?"
);
$stmt->bind_param("i", $user_id);
$stmt->execute();

$user = $stmt->get_result()->fetch_assoc();

if (!$user) {
    echo json_encode([
        "success" => false,
        "message" => "User tidak ditemukan"
    ]);
    exit;
}

echo json_encode([
    "success" => true,
    "data" => $user
]);
