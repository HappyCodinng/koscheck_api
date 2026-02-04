<?php
require_once __DIR__ . "/../config/database.php";

$id_user = $_GET['id_user'] ?? null;

if (!$id_user) {
    echo json_encode([
        "status" => false,
        "data" => null
    ]);
    exit;
}

$stmt = $conn->prepare("
    SELECT r.*, u.nama 
    FROM roommate r 
    JOIN user u ON r.id_user = u.id
    WHERE r.id_user = ?
    LIMIT 1
");
$stmt->bind_param("i", $id_user);
$stmt->execute();
$result = $stmt->get_result();

$data = $result->fetch_assoc();

echo json_encode([
    "status" => true,
    "data" => $data
]);
