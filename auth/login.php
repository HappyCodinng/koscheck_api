<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . "/../config/database.php";

$data = json_decode(file_get_contents("php://input"), true);

$email    = $data['email'] ?? '';
$password = $data['password'] ?? '';

if ($email === '' || $password === '') {
    echo json_encode([
        "success" => false,
        "message" => "Email dan password wajib diisi",
        "data"    => null
    ]);
    exit;
}

$stmt = $conn->prepare("SELECT * FROM `user` WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();

$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user) {
    echo json_encode([
        "success" => false,
        "message" => "Email tidak ditemukan",
        "data"    => null
    ]);
    exit;
}

if (!password_verify($password, $user['password'])) {
    echo json_encode([
        "success" => false,
        "message" => "Password salah",
        "data"    => null
    ]);
    exit;
}

unset($user['password']);

echo json_encode([
    "success" => true,
    "message" => "Login berhasil",
    "data"    => $user
]);
