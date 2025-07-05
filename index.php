<?php
session_start();
if (isset($_SESSION["registration_code"]) and !isset($_SESSION["office"])) {
  unset($_SESSION["registration_code"]);
  session_destroy();
}
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>UBBC BESTINATION</title>
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <!-- <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto"> -->
  <link rel="stylesheet" href="assets/css/styles.min.css">
</head>

<body>
  <div class="container mobile-container bg-white">
    <div class="row">
      <div class="col"><img class="Logo" src="assets/img/UBLipaCity.png"
          style="text-align: center;">
      </div>
      <div class="col text-center "><img class="onboarding rounded w-100 h-50"
          src="assets/img/Bestination.png">
        <h1 class="welcome poppins-semibold">WELCOME</h1>
        <p class="blacklabel poppins">Be part of a whole day of fun, </br>discoveries and union.</p>
        <a href="registration.php"
          class="d-flex justify-content-center align-items-center text-decoration-none">
          <button class="btn registerbtn poppins-extrabold d-flex justify-content-center align-items-center"
            type="button">
            REGISTER NOW
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24" color="#ffff"
              fill="none">
              <path d="M9.00005 6C9.00005 6 15 10.4189 15 12C15 13.5812 9 18 9 18" stroke="currentColor"
                stroke-width="3" stroke-linecap="round" stroke-linejoin="round" />
            </svg>
          </button>
        </a>
      </div>
    </div>
  </div>
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>