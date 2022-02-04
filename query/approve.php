<?php
require_once __DIR__ . "/../config/config.php";
require_once __DIR__ . "/../query/awards.php";
require_once __DIR__ . "/../helpers/functions.php";


if (isset($_POST['award'])) {
    require_once __DIR__ . "/../database/db.php";
    $sendAward = "";
    $sendMail = "";

    $cardID = $_GET['cardapprove'];
    $awardID = $_POST['award'];

    // award name to be sent in email
    $msg_award = "SELECT name FROM awards WHERE id = {$awardID}";
    $aw = $pdo->query($msg_award);
    while ($award = $aw->fetch()) {
        if ($award['name'] == 'cap_black') {
            $sendAward = "black Jagermeister cap";
        } else if ($award['name'] == 't-shirt_black') {
            $sendAward = "black Jagermeister T-shirt";
        } else if ($award['name'] == 't-shirt_white') {
            $sendAward = "white Jagermeister T-shirt";
        } else if ($award['name'] == "bottle") {
            $sendAward = "Jagermeister bottle";
        }
    }

    // send mail to
    $user_email = "SELECT email FROM users WHERE id = {$cardID}";
    $us = $pdo->query($user_email);

    while ($mail = $us->fetch()) {
        $sendMail = $mail['email'];
    }

    // update db on awarded user
    $approve = "UPDATE `users` SET `awards_id` = :awardID WHERE `users`.`id` = :cardID;
    UPDATE `awards` SET `amount` = `amount` - 1 WHERE `awards`.`id` = :awardID;
    UPDATE `users` SET `status` = 'approved' WHERE `users`.`id` = :cardID";
    $stmt = $pdo->prepare($approve);


    if ($stmt->execute([
        'cardID' => $cardID,
        'awardID' => $awardID
    ])) {
        // send mail 
        $header = "From:" . EMAIL . "\r\n";
        $header .= "MIME-Version: 1.0\r\n";
        $header .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
        $header .= "X-Priority: 1\r\n";
        $msg = "Hello," . "<br>" . "You have been awarded with {$sendAward}";
        $msg = wordwrap($msg, 70);
        mail($sendMail, "Jagermeister award", $msg, $header);
        redirect("admin/dashboard.php");
    } else {
        redirect("admin/dashboard.php?=error");
    }
}
