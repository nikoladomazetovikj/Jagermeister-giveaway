<?php
require_once __DIR__ . "/query/insert.php";
require_once __DIR__ . "/config/config.php";

// display attempts
$attempts = "";
if (isset($_SESSION['imgInvalid'])) {
  $attempts = "<p id='attmsg'>Please try again. You have <b id='failed'>{$_SESSION['imgInvalid']}</b> more attempts!</p>";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <title>Jagermeister</title>
  <meta charset="utf-8" />
  <meta name="keywords" content="Jagermeister, jagermeister, Jagermeister giveaway, Jagermeister prizes" />
  <meta name="description" content="Jagermeister Giveaway" />
  <meta name="author" content="Nikola Domazetovic" />
  <meta name="viewport" content="width=device-width,initial-scale=1.0" />
  <!-- Latest compiled and minified Bootstrap 4.4.1 CSS -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous" />
  <link rel="stylesheet" href="<?= WEB_URL ?>assets/fontawesome-free-5.15.3-web/fontawesome-free-5.15.3-web/css/all.min.css" />
  <link rel="stylesheet" href="<?= WEB_URL ?>assets/style/main.css" />
  <link rel="icon" href="<?= WEB_URL ?>assets/bg-Img/logo.jpg" />
</head>

<body id="body">

  <!-- respond alerts -->
  <div class="container-fluid my-5">
    <?php
    if (isset($_GET['success'])) {
      echo " <div class='alert alert-success alert-dismissible col-lg-6 col-md-12 mx-auto'>
      <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
      <h4><i class='icon fa fa-check'></i> Congratulations !</h4>
      <p>You successfully uploaded your receipt. Thank You for participation!</p>
      <p>You will be notified as soon as possible</p>
    </div>";
    }
    ?>

    <?php
    if (isset($_GET['error'])) {
      echo "<div class='alert alert-danger alert-dismissible col-lg-6 col-md-12 mx-auto'>
        <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
        <h4><i class='fas fa-times'></i> </h4>
        <p id = 'blockmsg'>The image you uploaded is not a receipt!</p>
        {$attempts}
        </div>";
    }
    ?>
    <?php
    if (isset($_GET['exist'])) {
      echo "   <div class='alert alert-warning alert-dismissible col-lg-6 col-md-12 mx-auto'>
    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
    <h4><i class=' fas fa-exclamation-triangle'></i></h4>
    <p>You have already sent your receipt!</p>
    </div>";
    }
    ?>
    <!-- main  -->
    <div class="container bg-white my-5">
      <img src="<?= WEB_URL ?>assets/bg-Img/logo.jpg" alt="logo" class="logo" />
      <h1 class="text-center py-4">
        Welcome to the biggest
        <b class="jager">Jagermeister</b>
        Giveaway
      </h1>
      <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
        <div class="carousel-inner">
          <div class="carousel-item active">
            <img class="d-block w-25 mx-auto" src="<?= WEB_URL ?>assets/bg-Img/cap_black.jpg" alt="First prize" />
            <h4 class="text-center py-4">x3000</h4>
          </div>
          <div class="carousel-item">
            <img class="d-block w-25 mx-auto" src="<?= WEB_URL ?>assets/bg-Img/t-shirt_black.jpeg" alt="Second prize" />
            <h4 class="text-center py-4">x2000</h4>
          </div>
          <div class="carousel-item">
            <img class="d-block w-25 mx-auto" src="<?= WEB_URL ?>assets/bg-Img/t-shirt_white.jpg" alt="Third prize" />
            <h4 class="text-center py-4">x5000</h4>
          </div>
          <div class="carousel-item">
            <img class="d-block w-25 mx-auto" src="<?= WEB_URL ?>assets/bg-Img/bottle.jpg" alt="Fourth prize" />
            <h4 class="text-center py-4">x100</h4>
          </div>
        </div>
        <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
          <span class="carousel-control-prev-icon" aria-hidden="true"></span>
          <!-- <span class="sr-only">Previous</span> -->
        </a>
        <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
          <span class="carousel-control-next-icon" aria-hidden="true"></span>
          <!-- <span class="sr-only">Next</span> -->
        </a>
      </div>
      <div class="text-center py-4">
        <button id="enter" type="button" class="btn btn-lg btn-outline-success" data-toggle="modal" data-target="#exampleModalCenter">
          Enter
        </button>
      </div>
    </div>
  </div>

  <!-- Modal -->
  <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="exampleModalLongTitle">
            Send Your Receipt
          </h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
          <div id="popUp">
            <form id="form" method="POST" enctype="multipart/form-data" action="<?= WEB_URL ?>query/insert.php">
              <div class="form-group">
                <label for="Email" class="col-form-label">E-mail:</label>
                <input type="email" class="form-control" id="Email" name="Email" />
                <p id="emailCheck" class="py-3 text-danger">
                </p>
              </div>
              <div class="form-group">
                <label for="receiptImg" class="btn btn-secondary">
                  Upload Receipt
                  <i class="fas fa-file-upload"></i>
                </label>
                <input type="file" id="receiptImg" name="receiptImg" style="display: none" />
                <span class="text-danger" id="fileExtension"></span>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-danger" data-dismiss="modal" id="close">
                  Close
                </button>
                <button type="submit" class="btn btn-success" id="send" name="send">
                  Send
                </button>
              </div>
            </form>
          </div>
          <div id="progressBar">
            <div id="loader" class="progress-bar progress-bar-striped bg-success" role="progressbar" style="width: 0%" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"><span id="current"></span></div>
          </div>
        </div>
      </div>
    </div>
  </div>


  <!-- jQuery library -->
  <script src="<?= WEB_URL ?>assets/jquery/jquery-3.6.0.min.js"></script>
  <!-- Latest Compiled Bootstrap JavaScript -->
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.min.js" integrity="sha384-+YQ4JLhjyBLPDQt//I+STsc9iw4uQqACwlvpslubQzn4u2UU2UFM80nGisd026JF" crossorigin="anonymous"></script>
  <script>
    // upload button style
    $("#receiptImg").change(function() {
      let i = $(this).prev("label").clone();
      let file = $("#receiptImg")[0].files[0].name;
      $(this).prev("label").text(file);
    });
  </script>
  <script src="<?= WEB_URL ?>assets/src/validation.js"></script>
  <script src="<?= WEB_URL ?>assets/src/main.js"></script>
</body>

</html>