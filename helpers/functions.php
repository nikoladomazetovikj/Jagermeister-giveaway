<?php

require_once __DIR__ . "/../config/config.php";

// upload images to local folder
function uploadReceipt()
{
    if (isset($_FILES["receiptImg"])) {
        $extension = explode('.', $_FILES['receiptImg']['name']);
        $randName = rand() . '.' . $extension[1];
        $destination = '../images/' . $randName;
        move_uploaded_file($_FILES['receiptImg']['tmp_name'], $destination);
        return $randName;
    }
}

// redirect to specific page
function redirect($dir)
{
    header("Location: " . WEB_URL . "$dir");
    die();
}
