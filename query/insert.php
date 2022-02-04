<?php
session_start();
require_once __DIR__ . "/../config/config.php";
require_once __DIR__ . "/../helpers/functions.php";

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    // insert data to db

    require_once __DIR__ . "/../database/db.php";

    // check if email exist in db
    $email = $_POST["Email"];

    $check = "SELECT * FROM users WHERE email = :email";
    $stmt = $pdo->prepare($check);
    $stmt->execute(['email' => $email]);
    $image = "";
    if ($stmt->rowCount() == 0) {
        $img_text = "";
        if ($_FILES["receiptImg"]["name"] != '') {
            sleep(1.5);
            $image = uploadReceipt();
        }
        // api url
        $url = "https://jager.brainster.xyz/api?img={$image}";
        $data = file_get_contents($url);
        $getData = json_decode($data);
        if ($getData->img_status == 0) {
            unlink("../images/{$image}");
            // check for attemts on invalid image
            if (!isset($_SESSION['imgInvalid'])) {
                $_SESSION['imgInvalid'] = 2;
            } else {
                $_SESSION['imgInvalid']--;
            }
            if ($_SESSION['imgInvalid'] < 0) {
                $_SESSION['imgInvalid'] = 2;
                redirect("index.php?error");
            }
            redirect("index.php?error");
        }
        // get img text only if a status is 1 or 2
        if ($getData->img_status == 1 || $getData->img_status == 2) {
            $img_text = $getData->text;
        }
        // insert new row if user doesnt exist in db
        $sql = "INSERT INTO users (email,img,img_text,img_status) VALUES (:email,:img,:img_text,:img_status) ";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([
            "email" => $email,
            "img" => IMG_URL . $image,
            "img_text" => $img_text,
            "img_status" => $getData->img_status
        ])) {
            redirect("index.php?success");
        } else {
            redirect("index.php");
        }
    } else {
        redirect("index.php?exist");
    }
}
