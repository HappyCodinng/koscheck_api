<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header("Content-Type: text/plain");

echo"Mulai...\n";

$host = getenv("MYSQLHOST");
$user = getenv("MYSQLUSER");
$password = getenv("MYSQLPASSWORD");
$db = getenv("MYSQLDATABASE");
$port = getenv("MYSQLPORT");


var_dump($host, $user, $password, $db, $port);

$conn = new mysqli($host, $user, $password, $db, $port);

echo "Connected\n";

$result = $conn->query("SHOW TABLES");

while ($row = $result->fetch_array()) {
  echo $row[0] . "<br>";
}
