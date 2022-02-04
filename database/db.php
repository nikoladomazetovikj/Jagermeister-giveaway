<?php

require_once __DIR__ . "/../config/config.php";

try {
    $pdo = new PDO("mysql:dbname=" . DB_NAME . ";host=" . DB_HOST, DB_USER, DB_PASS);
} catch (PDOException $e) {
    file_put_contents(__DIR__ . "/../fileerr/err.txt", "[" . date("Y-m-d H:i:s") . "]: " . $e->getMessage() . PHP_EOL, FILE_APPEND);
    echo "Can not connect to database";
    die();
}
