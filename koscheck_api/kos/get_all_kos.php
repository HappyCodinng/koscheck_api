<?php
require_once __DIR__ . '/../config/database.php';

$result = $conn->query("SELECT * FROM kos ORDER BY id_kos DESC");

$data = [];
while ($row = $result->fetch_assoc()) {
    $data[] = $row;
}

echo json_encode([
    "status" => true,
    "data" => $data
]);