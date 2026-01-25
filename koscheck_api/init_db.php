<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
header("Content-Type: text/plain");

$conn = new mysqli(
  getenv("MYSQLHOST"),
  getenv("MYSQLUSER"),
  getenv("MYSQLPASSWORD"),
  getenv("MYSQLDATABASE"),
  getenv("MYSQLPORT")
);

echo "Connected\n";

$conn->query("
CREATE TABLE IF NOT EXISTS user (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100),
  email VARCHAR(100) UNIQUE,
  no_hp VARCHAR(15),
  password VARCHAR(255),
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)
");

$conn->query("
CREATE TABLE IF NOT EXISTS roommate (
  id INT AUTO_INCREMENT PRIMARY KEY,
  nama VARCHAR(100),
  umur INT,
  kampus VARCHAR(150),
  jenis_kelamin ENUM('Laki-laki','Perempuan'),
  deskripsi TEXT,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)
");

echo "TABLE CREATED SUCCESSFULLY";
