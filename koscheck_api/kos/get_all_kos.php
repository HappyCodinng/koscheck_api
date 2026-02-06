<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

require_once __DIR__ . "/../config/database.php";

$search     = $_GET['search']     ?? '';
$fasilitas  = $_GET['fasilitas']  ?? '';
$maxHarga   = $_GET['max_harga']  ?? '';
$maxJarak   = $_GET['max_jarak']  ?? '';

$sql = "SELECT * FROM kos WHERE 1=1";
$params = [];
$types = "";

/* SEARCH nama kos & alamat */
if (!empty($search)) {
    $sql .= " AND (nama_kos LIKE ? OR alamat LIKE ?)";
    $keyword = "%$search%";
    $params[] = $keyword;
    $params[] = $keyword;
    $types .= "ss";
}

/* FILTER fasilitas */
if (!empty($fasilitas)) {
    $sql .= " AND fasilitas LIKE ?";
    $params[] = "%$fasilitas%";
    $types .= "s";
}

/* FILTER harga (slider) */
if (!empty($maxHarga)) {
    $sql .= " AND harga <= ?";
    $params[] = (int)$maxHarga;
    $types .= "i";
}

/* FILTER jarak (slider) */
if (!empty($maxJarak)) {
    $sql .= " AND jarak <= ?";
    $params[] = (int)$maxJarak;
    $types .= "i";
}

/* Default sorting: terdekat dulu */
$sql .= " ORDER BY jarak ASC";

$stmt = $conn->prepare($sql);

if (!empty($params)) {
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
