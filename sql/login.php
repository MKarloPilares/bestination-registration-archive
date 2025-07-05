<?php

require_once "db_con.php";
require_once "modules.php";


if(isset($_POST['username'], $_POST['password']) and !empty($_POST['username'])){
  $username = post("username");

  $password = post("password");

  if(login($username, $password)){
    redirect("scan.php");
  }else{
    $errors[] = "No records matched with our system. Please check your username and password.";
  }
}

$_SESSION["errors"] = $errors;
