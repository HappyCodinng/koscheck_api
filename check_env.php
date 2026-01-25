<?php
header("Content-Type: text/plain");

echo "MYSQLHOST: " . getenv("MYSQLHOST") . PHP_EOL;
echo "MYSQLUSER: " . getenv("MYSQLUSER") . PHP_EOL;
echo "MYSQLPASSWORD: " . (getenv("MYSQLPASSWORD") ? "ADA" : "KOSONG") . PHP_EOL;
echo "MYSQLDATABASE: " . getenv("MYSQLDATABASE") . PHP_EOL;
echo "MYSQLPORT: " . getenv("MYSQLPORT") . PHP_EOL;
