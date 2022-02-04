<?php
session_start();
require_once __DIR__ . "/../config/config.php";
require_once __DIR__ . "/../helpers/functions.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    // /check for admins

    require_once __DIR__ . "/../database/db.php";
    $email = $_POST['emailAdmin'];
    $password = $_POST['password'];

    $sql =  "SELECT * FROM admins WHERE email = :emailAdmin";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(['emailAdmin' => $email]);

    if ($stmt->rowCount() == 1) {

        $admin = $stmt->fetch();
        if ($password == $admin['password']) {
            $_SESSION['admin'] = $admin['email'];
            redirect("admin/dashboard.php");
        } else if ($password != $admin['password']) {
            $_SESSION['err'] = "Wrong password";
            redirect("admin/login.php?emailAdmin=$email");
            die();
        }
    } else {
        $_SESSION['err'] = "Wrong email address";
        redirect("admin/login.php");
        die();
    }
}
