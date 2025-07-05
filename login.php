<?php

include_once 'sql/db_con.php';
include_once 'sql/modules.php';

include_once 'sql/login.php';


?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>UBBC BESTINATION</title>
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
  <link rel="stylesheet" href="assets/css/styles.min.css">

</head>

<body>
  <div class="container mobile-container">
    <div class="row">
      <div class="col"><img class="Logo" src="assets/img/UBLipaCity.png" style="text-align: center;">
      </div>
      <div class="col text-center"><img class="onboarding" src="assets/img/onboarding.svg"></div>
    </div>
    <div class="row">
      <div class="col-md-1"></div>
      <div class="col-md-10">
        <form method="POST">
        <h1 class="welcome">Welcome</h1>
        <div class="form-group transparentform">
          <p class="pinklabel">Username:</p><input name="username" type="text" class="pinktextbox" required>
          <p class="pinklabel">Password:</p><input name="password" type="password" class="pinktextbox" required><button
            class="btn text-center btnpink" type="submit">Log in</button>
            <br>
            <br>
            <a href='office_registration.php'>Register as a Scanner</a>

        </div>

        </form>
      </div>
      <div class="col-md-1"></div>
    </div>
  </div>
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>