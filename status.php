<?php

include_once 'sql/db_con.php';
include_once 'sql/modules.php';


if(isset($_SESSION["registration_code"])){
  $_SESSION["registration_code"] = "";
  unset($_SESSION["registration_code"]);
}

//include_once 'sql/scan.php';
if(isset($_GET["q"])){
  $rc = $_GET["q"];
  $offices = getVisitedOffices($rc);
  //var_dump($offices);

  if(count($offices) == 1){
    $offices = $offices[0];
  }
}


?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
  <title>UB Unlocked</title>
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
  <link rel="stylesheet" href="assets/css/styles.min.css">
</head>

<body>
  <div class="container mobile-container">
    <div class="row">
      <div class="col"><img class="Logo" src="assets/img/UBLipaCity.png" style="text-align: center;">
      </div>
      <div class="col text-center"><img class="onboarding" src="assets/img/onboarding.svg">
      <form action="status.php" method="GET">

        <h1 class="welcome">Check your status</h1>
        <div class="form-group transparentdiv">
          <p class="pinklabel">Registration Code:</p><input type="text" name="q" class="pinktextbox" value="<?php if(isset($_GET["q"])) { echo $rc; } ?>">

          <?php if(isset($_GET["q"])) { ?>
          <p class="pinklabel3" style="font-weight: bold;"><?php echo countVisitedOffices($rc); ?> out 6</p>
          <p class="pinklabel4">Please proceed to the following offices </br>
            to complete</p>

            <div class="form-check"><input class="form-check-input" type="radio" id="formCheck-1" <?php checkIt( $offices, "CMT"); ?>><label
              class="form-check-label pinkradio" for="formCheck-1">&nbsp;&nbsp;CMT</label></div>

            <div class="form-check"><input class="form-check-input" type="radio" id="formCheck-1" <?php checkIt( $offices, "CEAS"); ?>><label
              class="form-check-label pinkradio" for="formCheck-1">&nbsp;&nbsp;CEAS</label></div>

            <div class="form-check"><input class="form-check-input" type="radio" id="formCheck-1" <?php checkIt( $offices, "CCJE"); ?>><label
              class="form-check-label pinkradio" for="formCheck-1">&nbsp;&nbsp;CCJE</label></div>

            <div class="form-check"><input class="form-check-input" type="radio" id="formCheck-1" <?php checkIt( $offices, "CBAA"); ?>><label
              class="form-check-label pinkradio" for="formCheck-1">&nbsp;&nbsp;CBAA</label></div>

            <div class="form-check"><input class="form-check-input" type="radio" id="formCheck-1" <?php checkIt( $offices, "CITEC"); ?>><label
              class="form-check-label pinkradio" for="formCheck-1">&nbsp;&nbsp;CITEC</label></div>

            <div class="form-check"><input class="form-check-input" type="radio" id="formCheck-1" <?php checkIt( $offices, "CENAR"); ?>><label
              class="form-check-label pinkradio" for="formCheck-1">&nbsp;&nbsp;CENAR</label></div>

          <?php } ?>
          <button
            class="btn btn-primary text-center btnpink" type="submit">Check status</button>
        </div>
      </form>

      </div>
    </div>
  </div>
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>