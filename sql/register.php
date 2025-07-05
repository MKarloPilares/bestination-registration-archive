<?php


if($_SERVER["REQUEST_METHOD"] == "POST"){
  if(isset($_POST["first_name"],$_POST["last_name"],$_POST["email"])){

    $fn = post("first_name");
    $ln = post("last_name");
    $mdn = post("middle_name");
    $email = post("email");
    $mn = post("mobile_no");
    $gen = post("gender");
    $sn = post("school_name");
    $pc = post("preferred_course");
    $ps = post("preferred_strand");
    if($ps === "others"){
      $ps = post("other_strand");
    }

    if(trim($fn) == '' or trim($ln) == '' or trim($email) == '' or trim($mn) == '' or trim($gen) == ''){
      $_SESSION['error'] = "Please fill up all fields";
      redirect("registration.php");
    }

    $res = register($fn, $ln, $mdn, $email, $mn, $gen, $sn, $pc, $ps);
    if($res == true){
      redirect("finished.php");
    }else{
      $_SESSION['first_name'] = $fn;
      $_SESSION['last_name'] = $ln;
      $_SESSION['middle_name'] = $mdn;
      $_SESSION['email'] = $email;
      $_SESSION['mobile_no'] = $mn;
      $_SESSION['gender'] = $gen;
      $_SESSION['school_name'] = $sn;
      $_SESSION['preferred_course'] = $pc;
      $_SESSION['preferred_strand'] = $ps;
    }
  }else{

    $_SESSION['error'] = "Please fill up all fields";
    redirect("registration.php");
  }
}
