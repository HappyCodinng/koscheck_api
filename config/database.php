<?php

$host = getenv("MYSQLHOST");
$user = getenv("MYSQLUSER");
$password = getenv("MYSQLPASSWORD");
$db = getenv("MYSQLDATABASE");
$port = getenv("MYSQLPORT");

  $conn = new mysqli($host, $user, $password, $db, $port);
  $conn -> set_charset("utf8mb4");

  if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode([
      "success" => false,
      "message" => "Koneksi database gagal: ",
    ]);
    exit;
}