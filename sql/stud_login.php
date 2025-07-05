<?php

require_once "db_con.php";
require_once "modules.php";


if(isset($_POST['password'])){
  $password = post("password");
  //if(login($password)){

    $student_no = post("student_no");

    if(empty($student_no)){
      redirect("../index.php");
    }

    $data = getStudentLogs($student_no);
    if(count($data) == 0){
      $word = 1;
    }else{
      $word = $data[0]["last_word_no"]  + 1;
    }

    // var_dump($word);
    // exit();

    $_SESSION["student_no"] = $student_no;
    $_SESSION["word"] = $word;
    $_SESSION["user_type"] = "student";

    redirect("../dashboard_tagged.php");
  // }else{
  //   $errors[] = "Password is incorrect.";
  // }
}

$_SESSION["errors"] = $errors;
redirect(("../index.php"));