<?php
header("Access-Control-Allow-Origin: *");
header('Content-Type: application/json');

require_once __DIR__ . "/../config/database.php";

$search = $_GET['search'] ?? '';

$sql = "select * from kos";
$params = [];
$types = "";

if(!empty($search)) {
    $sql .= "where nama_kos like ? or alamat like ?";
    $keyword = "%" . $search . "%";
    $params[] = $keyword;
    $params[] = $keyword;
    $types = "ss";
}

$sql .= " order by jarak asc";

$stmt->$conn->prepare($sql);

if(!empty($params)) {
    $stmt->bind_param($types, ...$params);
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