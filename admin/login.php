<?php

require_once __DIR__ . "/../query/admins.php";
require_once __DIR__ . "/../config/config.php";

?>

<?php require_once __DIR__ . "/header.php" ?>

<body class="bg-dark text-white">
  <div class="container-fluid my-5">
    <h1 class="py-5 text-center">LOGIN</h1>
    <!-- print error messages -->
    <?php
    if (isset($_SESSION['err'])) {
    ?>
      <div class='text-center'>
        <span class='text-center text-white my-4 bg-danger p-2 rounded '><?= $_SESSION['err'] ?></span>
      </div>
    <?php }
    session_unset();
    ?>
    <div class="container my-5">
      <div class="row">
        <div class="col-6 mx-auto">
          <form method="post" action="../query/admins.php">
            <div class="form-group">
              <label for="emailAdmin">Email address</label>
              <input type="text" class="form-control" id="emailAdmin" name="emailAdmin" aria-describedby="emailHelp" placeholder="Enter email" value="<?= isset($_GET['emailAdmin']) ? $_GET['emailAdmin'] : ''  ?>" />
            </div>
            <div class="form-group">
              <label for="password">Password</label>
              <input type="password" class="form-control" id="password" name="password" name="emailAdmin" placeholder="Password" />
            </div>
            <button type="submit" class="btn btn-primary">Login</button>
          </form>
        </div>
      </div>
    </div>
  </div>
  <?php require_once __DIR__ . "/scripts_footer.php"; ?>
</body>

</html>