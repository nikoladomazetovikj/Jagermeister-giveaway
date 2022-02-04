<?php
require_once __DIR__ . "/../config/config.php";
require_once __DIR__ . "/../query/admins.php";
require_once __DIR__ . "/../database/db.php";
require_once __DIR__ . "/../query/awards.php";
require_once __DIR__ . "/../query/decline.php";
require_once __DIR__ . "/../query/random.php";

if (!isset($_SESSION['admin'])) {
  redirect("admin/login.php");
}
$link = WEB_URL;
$status = '';
$class = "";

// print img status in card header
function img_status($var)
{
  if ($var['img_status'] == 1) {
    $status = "<b class ='text-success'>Receipt</b>";
  } else if ($var['img_status'] == 2) {
    $status =  "<b class ='text-danger'>Maybe Receipt</b>";
  }
  return $status;
}

// add img status class for filtering
function img_status_class($var)
{
  if ($var['img_status'] == 1) {
    $statusClass = "receipt";
  } else if ($var['img_status'] == 2) {
    $statusClass =  "maybeReceipt";
  }
  return $statusClass;
}

?>
<?php require_once __DIR__ . "/header.php" ?>

<body>
  <div class="container-fluid">
    <div class="row">
      <div class="col-lg-2 col-md-3 bg-dark panel-h">
        <h1 class="text-white py-4">Admin Panel</h1>
        <p class="text-white py-lg-3 py-md-0 ">
          Admin:
          <b><?= $_SESSION['admin'] ?></b>
        </p>
        <h3 class="text-white">Receipts</h3>
        <hr class="bg-secondary" />
        <!-- checkboxes -->
        <div class="btn-group btn-group-toggle" data-toggle="buttons">
          <label class="btn btn-secondary my-lg-2 ml-lg-2">
            <input type="checkbox" name="options" id="allCards" autocomplete="off" checked> All Receipts
          </label>
          <label class="btn btn-secondary my-lg-2 ml-lg-2">
            <input type="checkbox" name="options" id="pendingR" autocomplete="off"> Pending
          </label>
          <label class="btn btn-secondary my-lg-2 ml-lg-2">
            <input type="checkbox" name="options" id="approvedR" autocomplete="off"> Approved
          </label>
          <label class="btn btn-secondary my-lg-2 ml-lg-2">
            <input type="checkbox" name="options" id="declinedR" autocomplete="off">Declined
          </label>
          <!-- status boxes -->
          <h3 class="text-white">Status</h3>
          <hr class="bg-secondary">
          <label class="btn btn-secondary   my-lg-2 ml-lg-2">
            <input type="checkbox" name="options" id="receiptsR" autocomplete="off"> Receipts
          </label>
          <label class="btn btn-secondary  my-lg-2 ml-lg-2">
            <input type="checkbox" name="options" id="maybeReceiptsR" autocomplete="off"> Maybe Receipts
          </label>

        </div>
        <hr class="bg-secondary" />
        <div class="my-2">
          <!-- report button -->
          <form method="post" action="<?= WEB_URL ?>/query/export.php">
            <input type="submit" name="export" class="btn btn-success" value="Get Report" />
          </form>
        </div>
        <!-- log out button -->
        <div class="my-3">
          <a href="logout.php"><button type="button" class="btn btn-light">Log out</button></a>
        </div>
      </div>
      <div class="col-lg-9 col-md-8 my-5 card-margin">
        <!-- random button -->
        <?php if (isset($_GET['random'])) { ?>
          <div id="random" class="hide">
            <button type="button" class="btn btn-info " data-toggle="modal" data-target="#card<?= $_GET['random'] ?>">Select Random</button>
          </div>
        <?php } ?>
        <div class="row">
          <!-- pending cards start -->
          <?php

          $all = "SELECT * FROM users where status = 'pending'";
          $stmt = $pdo->query($all);

          if ($stmt->rowCount() == 0) {
            echo "";
          } else {
            while ($card = $stmt->fetch()) {
              $status = img_status($card);
              $class = img_status_class($card);
              echo "
              <div class='col-lg-3 col-md-8 my-3 d-flex align-items-stretch {$card['status']} {$class}'>
                <div class='card rounded' style='width: 15rem;'>
                  <h5 class='card-header'>{$status} <i class= 'text-muted float-right fas fa-ellipsis-h'></i> </h5>
                    <img class='card-img-top img-fluid' src='{$card['img']}' alt='Card image' />
                  <div class='card-body'>  
                      <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#card{$card['id']}'>
                        Preview
                      </button>
                    </div>
                    
                  

                <div class='modal fade' id='card{$card['id']}' tabindex='-1' role='dialog' aria-labelledby='exampleModalLongTitle' 
                  aria-hidden='true' href='{$card['id']}'>
                  <div class='modal-dialog' role='document'>
                    <div class='modal-content'>
                      <div class='modal-header'>
                        <h5 class='modal-title' id='exampleModalLongTitle'>
                          Receipt N. {$card['id']}
                        </h5>
                        <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                          <span aria-hidden='true'>&times;</span>
                        </button>
                      </div>
                      <div class='modal-body'>
                        <img class='card-img-top' src='{$card['img']}' alt='Card image' />
                        <p>E-mail: {$card['email']} </p>
                        <p>
                        {$card['img_text']}
                        </p>
                        <form action='{$link}query/approve.php?cardapprove={$card['id']}' method='POST' id='awards'>
                          <h5>Select award</h5>
                          <div class = 'row my-4'>
                            <div class = 'col-7 ml-3'>
                              <select name='award' id='award' class='form-control'>
                                  {$awards}
                                </select>
                              </div>
                            <div class = 'col-4 ml-4'> 
                            <button type='submit' class='btn btn-success ' name = 'approve'>
                                    Approve
                                </button>
                            </div>
                          </div>
                        </form>
                        <div class='modal-footer'>
                        <a href = '{$link}query/decline.php?carddecline={$card['id']}'><button name='decline' type='submit' 
                       class='btn btn-danger' >
                        Decline
                       </button></a>
                       <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                          </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>";
            }
          }
          ?>
          <!-- pending cards end -->

          <!-- awarded cards start -->
          <?php


          $awardedAll = "SELECT users.id as receiptID, users.email,users.img,users.img_text,users.img_status,users.status, awards.name FROM users LEFT JOIN awards ON users.awards_id=awards.id WHERE users.status = 'approved';";
          $stmt = $pdo->query($awardedAll);

          if ($stmt->rowCount() == 0) {
            echo "";
          } else {
            while ($awardedCards = $stmt->fetch()) {
              $status = img_status($awardedCards);
              $class = img_status_class($awardedCards);
              echo "<div class='col-lg-3  col-md-8 my-3 d-flex align-items-stretch {$awardedCards['status']} {$class}' >
              <div class='card rounded border border-success' style='width: 15rem;'>
              <h5 class='card-header '>{$status} <i class='float-right text-warning fas fa-award'></i></h5>
                <img class='card-img-top img-fluid' src='{$awardedCards['img']}' alt='Card image' />
                <div class='card-body'>
                  <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#cardAward{$awardedCards['receiptID']}'>
                    Preview
                  </button>
                  </div>
                 

                     <div class='modal fade' id='cardAward{$awardedCards['receiptID']}' tabindex='-1' role='dialog' aria-labelledby='exampleModalLongTitle
                       aria-hidden='true' href='{$awardedCards['receiptID']}'>
                   <div class='modal-dialog' role='document'>
                     <div class='modal-content'>
                       <div class='modal-header'>
                         <h5 class='modal-title' id='exampleModalLongTitle'>
                           Receipt N. {$awardedCards['receiptID']}
                         </h5>
                         <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                           <span aria-hidden='true'>&times;</span>
                         </button>
                       </div>
                       <div class='modal-body'>
                         <img class='card-img-top' src='{$awardedCards['img']}' alt='Card image' />
                         <p>E-mail: {$awardedCards['email']} </p>
                         <p>
                         {$awardedCards['img_text']}
                         </p>
                         <p>Award: {$awardedCards['name']}</p>
                         <div class='modal-footer'>
                        <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                           </div>
                       </div>
                     </div>
                   </div>
                 </div>
               </div>
             </div>";
            }
          }
          ?>
          <!-- awarded end -->

          <!-- declined cards start -->
          <?php
          $allDeclined = "SELECT * FROM users where status = 'declined'";
          $stmt = $pdo->query($allDeclined);
          if ($stmt->rowCount() == 0) {
            echo "";
          } else {
            while ($decline = $stmt->fetch()) {
              $status = img_status($decline);
              $class = img_status_class($decline);
              echo "<div class='col-lg-3 col-md-8 my-3 d-flex align-items-stretch  {$decline['status']} {$class}'>
              <div class='card rounded border border-danger' style='width: 15rem;'>
              <h5 class='card-header'>{$status} <i class='float-right text-danger far fa-window-close'></i></h5>
             <img class='card-img-top  img-fluid' src='{$decline['img']}' alt='Card image' />
             
             <div class='card-body'>
               <button type='button' class='btn btn-primary' data-toggle='modal' data-target='#decline{$decline['id']}'>
                 Preview
               </button>
             </div>
           
             <div class='modal fade' id='decline{$decline['id']}' tabindex='-1' role='dialog' aria-labelledby='exampleModalLongTitle
            aria-hidden='true' href='{$decline['id']}'>
               <div class='modal-dialog ' role='document'>
                 <div class='modal-content'>
                   <div class='modal-header'>
                     <h5 class='modal-title' id='exampleModalLongTitle'>
                       Receipt N. {$decline['id']}
                     </h5>
                     <button type='button' class='close' data-dismiss='modal' aria-label='Close'>
                       <span aria-hidden='true'>&times;</span>
                     </button>
                   </div>
                   <div class='modal-body'>
                     <img class='card-img-top' src='{$decline['img']}' alt='Card image' />
                     <p>E-mail: {$decline['email']} </p>
                     <p>
                     {$decline['img_text']}
                     </p>
                     <form action='{$link}query/approve.php?cardapprove={$decline['id']}' method='POST' id='awards'>
                       <h5>Select award</h5>
                       <div class = 'row my-4'>
                        <div class = 'col-7 ml-3'>
                          <select name='award' id='award' class='form-control'>
                              {$awards}
                            </select>
                          </div>
                        <div class = 'col-4 ml-4'> 
                        <button type='submit' class='btn btn-success ' name = 'approve'>
                                Approve
                            </button>
                        </div>
                      </div>
                     </form>
                     <div class='modal-footer'>
                     <a href = '{$link}query/decline.php?carddecline={$decline['id']}'><button name='decline' type='submit' 
                    class='btn btn-danger' >
                     Decline
                    </button></a>
                    <button type='button' class='btn btn-secondary' data-dismiss='modal'>Close</button>
                       </div>
                   </div>
                 </div>
               </div>
             </div>
           </div>
         </div>";
            }
          }
          ?>
          <!-- declined cards end -->
        </div>
      </div>
    </div>
    <?php require_once __DIR__ . "/scripts_footer.php"; ?>
    <script src="<?= WEB_URL ?>assets/src/pagination.js"></script>
</body>

</html>