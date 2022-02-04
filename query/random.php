<?php

require_once __DIR__ . "/../database/db.php";

// select random pending receipt
$random = "SELECT id FROM users WHERE status = 'pending'";

$stmt = $pdo->query($random);
$arr = [];

while ($random = $stmt->fetch()) {

    array_push($arr, (int)$random['id']);
}

if (count($arr) >= 1) {
    $_GET['random'] = $arr[mt_rand(0, count($arr) - 1)];
}
