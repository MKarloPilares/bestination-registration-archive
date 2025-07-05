<?php


if($_SERVER["REQUEST_METHOD"] == "POST"){
  if(isset($_POST["username"],$_POST["conf_pass"],$_POST["password"],$_POST["office"]) and !empty($_POST["office"]) and !empty($_POST["username"]) and !empty($_POST["password"])){
    $username = post("username");
    $conf_pass = post("conf_pass");
    $password = post("password");
    $office = post("office");

    if($conf_pass != $password){
      $errors[] = "Password didn't match.";
      redirect("login.php");
    }

    $passHash = password_hash($password, PASSWORD_BCRYPT);

    $res = officeRegistration($username, $passHash, $office);
    if($res == true){
      redirect("login.php");
    }
  }else{
    redirect("office_registration.php");
  }
}
