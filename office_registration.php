<?php

include_once 'sql/db_con.php';
include_once 'sql/modules.php';

include_once 'sql/office_register.php';

$departments = [["dept_code" => "CBAHM"],["dept_code" => "CIT"], ["dept_code" => "CAS"],
                ["dept_code" => "CEDU"],["dept_code" => "CCJE"],["dept_code" => "CNM"],
                ["dept_code" => "CAMS"],["dept_code" => "CENG"],["dept_code" => "CICT "]];

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
        <h1 class="welcome">Welcome</h1>
        <div class="form-group transparentform">
          <form action="" method="post">
          <p class="pinklabel">Username:</p><input type="text" name="username" class="pinktextbox" required>
          <p class="pinklabel">Password:</p><input type="password" name="conf_pass" class="pinktextbox" required>
          <p class="pinklabel">Confirm Password:</p><input type="password" name="password" class="pinktextbox" required>

          <p class="pinklabel">Office:</p><br>

          <select name="office" id="" class="pinktextbox" required>
            <?php foreach($departments as $department): ?>
              <option value="<?php echo $department['dept_code']; ?>"><?php echo $department['dept_code']; ?></option>
            <?php endforeach; ?>
          </select>


          <button
            class="btn btn-primary text-center btnpink" type="submit">Register</button>
            
            <br>
            <br>  
            <a href='login.php'>Already have an account? Login</a>
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