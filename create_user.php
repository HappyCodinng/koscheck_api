<?php
$conn = new mysqli(
    getenv("MYSQLHOST"),
    getenv("MYSQLUSER"),
    getenv("MYSQLPASSWORD"),
    getenv("MYSQLDATABASE"),
    getenv("MYSQLPORT")
);

if ($conn -> connect_error) {
    die($conn->connect_error);
}

$conn -> query("
    CREATE USER 'railway_user'@'%' IDENTIFIED BY 'AhmadSopian123';
");

$conn -> query("
    GRANT ALL PRIVILEGES ON koscheck.* TO 'railway_user'@'%';
");

$conn -> query("FLUSH PRIVILEGES");

echo "User created";