<?php

require_once __DIR__ . "/../database/db.php";

// print awards in option tag
$awards = "";
$awardsOption = "SELECT * FROM awards";
$stmt = $pdo->query($awardsOption);
if ($stmt->rowCount() == 0) {
    echo " <option value=''>No awards</option>";
} else {
    while ($award = $stmt->fetch()) {
        if ($award['amount'] != 0) {
            $awards .=  " <option value='{$award['id']}'> {$award['name']}  | amount: {$award['amount']}  </option>";
        }
    }
}
