<?php
require_once __DIR__ . "/../config/database.php";

$data = json_decode(file_get_contents("php://input"), true);

$id_user = $data['id_user'];
$umur = $data['umur'];
$kampus = $data['kampus'];
$jenis_kelamin = $data['jenis_kelamin'];
$deskripsi = $data['deskripsi'];

$cek = $conn->prepare("SELECT id FROM roommate WHERE id_user = ?");
$cek->bind_param("i", $id_user);
$cek->execute();
$res = $cek->get_result();

if ($res->num_rows > 0) {
    $stmt = $conn->prepare("
        UPDATE roommate 
        SET umur=?, kampus=?, jenis_kelamin=?, deskripsi=?
        WHERE id_user=?
    ");
    $stmt->bind_param(
        "isssi",
        $umur,
        $kampus,
        $jenis_kelamin,
        $deskripsi,
        $id_user
    );
} else {
    $stmt = $conn->prepare("
        INSERT INTO roommate 
        (umur, kampus, jenis_kelamin, deskripsi, id_user, created_at)
        VALUES (?, ?, ?, ?, ?, NOW())
    ");
    $stmt->bind_param(
        "isssi",
        $umur,
        $kampus,
        $jenis_kelamin,
        $deskripsi,
        $id_user
    );
}

$stmt->execute();

echo json_encode([
    "status" => true,
    "message" => "Profil berhasil disimpan"
]);
