<?php

//export report to excel file

require_once __DIR__ . "/../database/db.php";

$data = '';
$sql = "SELECT users.id as receiptID, users.email,users.status, awards.name as award FROM users LEFT JOIN awards ON users.awards_id=awards.id";

$stmt = $pdo->prepare($sql);

$stmt->execute();

$data .= '
   <table border="1" cellspacing="5" cellpadding="5">  
                    <tr>  
                         <th>ReceiptID</th>  
                         <th>Email</th>  
                         <th>Status</th>  
                        <th>Award</th>
                    </tr>
  ';
while ($row = $stmt->fetch()) {
    $data .= '
    <tr>  
                         <td>' . $row["receiptID"] . '</td>  
                         <td>' . $row["email"] . '</td>  
                         <td>' . $row["status"] . '</td>  
                        <td>' . $row["award"] . '</td>  
                    </tr>
   ';
}
$data .= '</table>';

header('Content-Type: application/xls');
header('Content-Disposition: attachment; filename=report.xls');
echo $data;
