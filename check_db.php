<?php
$conn = new mysqli(
  getenv("MYSQLHOST"),
  getenv("MYSQLUSER"),
  getenv("MYSQLPASSWORD"),
  getenv("MYSQLDATABASE"),
  getenv("MYSQLPORT")
);

$result = $conn->query("SHOW TABLES");

while ($row = $result->fetch_array()) {
  echo $row[0] . "<br>";
}
