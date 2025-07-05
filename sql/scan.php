<?php

require_once "db_con.php";
require_once "modules.php";


if(isset($_SESSION['office'], $_POST['reg_code'])){
  $reg_code = post("reg_code");
  $office = $_SESSION['office'];

  $res = saveVisitedOffice($reg_code, $office);
  if($res){
    redirect("finished2.php");
  }
}else{
  $errors[] = "No registration/office found.";
}

$_SESSION["errors"] = $errors;
