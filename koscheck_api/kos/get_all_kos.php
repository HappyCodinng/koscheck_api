<?php
header('Content-Type: application/json');
require_once __DIR__ . "/../config/database.php";

$search = $_GET['search'] ?? '';

if ($search !== '') {
    $stmt = $conn->prepare ("
        SELECT * FROM kos
        WHERE nama_kos LIKE ?
        OR alamat LIKE ?
        ORDER BY Rating DESC
    ");
    $keyword = "%$search%";
    $stmt->bind_param("ss", $keyword, $keyword);
} else {
    $stmt = $conn->prepare("
        SELECT * FROM kos
        ORDER BY Rating DESC
    ");
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