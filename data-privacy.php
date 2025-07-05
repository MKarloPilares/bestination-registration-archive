<?php

include_once 'sql/db_con.php';
include_once 'sql/modules.php';

include_once 'sql/register.php';


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
      <div class="col text-center"><img class="Logo" src="assets/img/UBLipaCity.png"></div>
      <div class="col text-center">
        <h1 class="welcome">Registration</h1>

        <h6>Data Privacy Statement</h6>
        <p>
        By providing your personal information in this form, you hereby understand and agree that the information is true and correct, 
        and you are giving your consent that the information provided shall be used only for the purposes related to UBLC BESTINATION; 
        in accordance with RA 10173 (Data Privacy Act of 2012) and other relevant Philippine laws.
        </p>
        <i>All fields are required.</i>

    
      </div>
    </div>
    <div class="row">
      <div class="col-md-1"></div>
      <div class="col-md-10">
        <div class="form-group whitediv">
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">
            <p class="pinklabel">First Name:</p><input type="text" name="first_name" class="pinktextbox" required>
            <p class="pinklabel">Last Name:</p><input type="text" name="last_name" class="pinktextbox" required>
            <p class="pinklabel">Email:</p><input type="email" name="email" class="pinktextbox" required>
            <p class="pinklabel">Mobile Number:</p><input type="text" name="mobile_no" class="pinktextbox" required>
            <p class="pinklabel">Sex:</p><select type="text" name="gender" class="pinktextbox" required>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
          </select>
            <p class="pinklabel">Name of your school:</p><input type="text" name="school_name" class="pinktextbox" required>
            <p class="pinklabel">Preferred Course (for incoming College)</p><input type="text" name="preferred_course" class="pinktextbox"><p class="pinklabel">Preferred Strand (for incoming SHS)</p><input type="text" name="preferred_strand" class="pinktextbox"><button
              class="btn text-center btnpink" type="submit">Finished</button>
          </form>
        </div>
      </div>
      <div class="col-md-1"></div>
    </div>
  </div>
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
</body>

</html>