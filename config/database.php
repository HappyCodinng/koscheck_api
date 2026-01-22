<?php
  $host = getenv("MYSQLHOST");
  $user = getenv("MYSQLUSER");
  $pass = getenv("MYSQLPASSWORD");
  $db   = getenv("MYSQLDATABASE");
  $port   = getenv("MYSQLPORT");

  $conn = new mysqli($host, $user, $pass, $db, $port);

  if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode([
      "success" => false,
      "message" => "Koneksi database gagal: ",
      "error" => $conn->connect_error
    ]);
    exit;
}

header("Content-Type: application/json");