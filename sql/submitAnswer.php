<?php

// student module

require_once "db_con.php";
require_once "modules.php";


if(isset($_POST['answers'])){
  $studentNo = $_SESSION["student_no"];
  $wordNo = $_SESSION["word"];

  if(empty($studentNo)){
    redirect("../index.php");
  }

  $answers = array_filter($_POST["answers"]);

  $wordAnswers = wordAnswers($wordNo);

  var_dump($wordAnswers);

  var_dump($answers);

  if(count($answers)){

    foreach($answers as $ans){
      $sanIns = htmlspecialchars(strtolower($ans));

      // evaluate
      $isCorrect = evaluateAnswer($wordAnswers, $sanIns);

      // save answer
      submitAnswer($studentNo, $wordNo, $sanIns, $isCorrect);

    }
  }

  // save answer

  $nextWord = $wordNo + 1;
  $_SESSION['word'] = $nextWord;

  saveStudentLog($studentNo, $wordNo);

  if($nextWord == 11){
    redirect("../success.php");
  }

}

mysqli_close($conn);


$_SESSION["errors"] = $errors;
//redirect(("../index.php"));

redirect("../dashboard_tagged.php");