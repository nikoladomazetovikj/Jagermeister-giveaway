<?php

require_once __DIR__ . "/../helpers/functions.php";


if (isset($_GET['carddecline'])) {
    // update db on decline
    require_once __DIR__ . "/../database/db.php";
    $id = $_GET['carddecline'];
    $decline = "UPDATE `users` SET `status` = 'declined' WHERE `users`.`id` = :id";
    $stmt = $pdo->prepare($decline);

    if ($stmt->execute([
        'id' => $id
    ])) {
        redirect("admin/dashboard.php");
    } else {
        redirect("admin/dashboard.php?=error");
    }
}
