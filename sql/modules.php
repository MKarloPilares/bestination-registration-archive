<?php

require_once "db_con.php";

$errors = [];

function departments(){
  $sql = "SELECT * FROM department WHERE div_code = 'VPAA' and campus = 'BC' order by dept_code";
  $result = odbc_exec($GLOBALS["connHuris"], $sql);

  $data = [];
  while($row = odbc_fetch_array($result)){
    $data[] = $row;
  }
  return $data;

}

function old($var){
  if(isset($_SESSION[$var])){
    return $_SESSION[$var];
  }
  return '';
}

function formatStrandCourse($data){
  return ucwords(strtolower(trim($data)));
}

function formatData($data){
  if(empty($data)){
    return '';
  }
  return htmlspecialchars( ucfirst(strtolower(trim($data))));
}

function dd($data){
  echo "<pre>";
  print_r($data);
  echo "</pre>";
  die();
}

function redirect($loc){
  header("Location: $loc");
  exit();
}

function get($var){
  return htmlspecialchars(trim($_GET[$var]));
}

function post($var){
  return htmlspecialchars(trim($_POST[$var]));
}

function login($user, $password){

  $sql = "SELECT * FROM users WHERE user_name = '$user'";
  $result = mysqli_query($GLOBALS["conn"], $sql);

  if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
      $_SESSION["username"] = $user;
      $_SESSION["office"] = $row["office"];
      $dbPass = $row["password"];
    }
  }else{
    return false;
  }

  if (password_verify($password, $dbPass)) {
    return true;
  } else {
    return false;
  }

}

function sanitize_url($url) {
  // Remove any potentially dangerous characters from the URL
  $url = filter_var($url, FILTER_SANITIZE_URL);

  // Encode the URL to ensure it is safe to use
  $url = urlencode($url);

  // Return the sanitized URL
  return $url;
}

function checkIt($arr, $off){
  if (in_array($off, $arr)){
    echo "checked";
  }

}

function searchRegistrationByOffice($office){
 $sql = "SELECT visitors.*, visited_offices.office_name, visited_offices.visited_date as vdate FROM visited_offices
              inner join visitors on visited_offices.registration_code = visitors.registration_code
              where visited_offices.office_name='$office' order by id DESC";
  $result = mysqli_query($GLOBALS["conn"], $sql);

  $data = [];
  if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
      $data[] = $row;
    }
  }
  return $data;

}

function getVisitors(){
  $sql = "SELECT v.first_name, v.last_name, v.middle_name, v.email,
              v.preferred_course, v.preferred_strand, v.registration_code, COUNT(DISTINCT vo.office_name) AS cnt
              FROM visited_offices vo
              INNER JOIN visitors v
              ON vo.registration_code = v.registration_code
              GROUP BY vo.registration_code
              HAVING cnt >= 9";
  $result = mysqli_query($GLOBALS["conn"], $sql);

  $data = [];
  if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
      $data[] = $row;
    }
  }
  return $data;
}

function searchRegistration($key){
  $sql = "SELECT * FROM visitors where last_name like '%$key%' OR first_name like '%$key%' order by id DESC";
  $result = mysqli_query($GLOBALS["conn"], $sql);

  $data = [];
  if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
      $data[] = $row;
    }
  }
  return $data;

}

function getVisitedOffices($rc){
  $sql = "SELECT * FROM visited_offices WHERE registration_code = '$rc'";
  $result = mysqli_query($GLOBALS["conn"], $sql);

  $data = [];
  if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
      $data[] = $row;
    }
  }
  return $data;

}

function getRegistrationsv2(){
  $sql = "SELECT * FROM visitors
              left join winners_160 on visitors.registration_code = winners_160.reg_code
              where winners_160.reg_code is null";
  $result = mysqli_query($GLOBALS["conn"], $sql);

  $data = [];
  if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
      $data[] = $row;
    }
  }
  return $data;

}

function getRegistrations(){
  $sql = "SELECT * FROM visitors order by id DESC";
  $result = mysqli_query($GLOBALS["conn"], $sql);

  $data = [];
  if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
      $data[] = $row;
    }
  }
  return $data;

}

function checkIfRegVisited($regCode, $office){
  $sql = "SELECT * FROM visited_offices WHERE registration_code = '$regCode' and office_name='$office'";
  $result = mysqli_query($GLOBALS["conn"], $sql);

  return mysqli_num_rows($result);

}

function countVisitedOffices($regCode){
  $sql = "SELECT * FROM visited_offices WHERE registration_code = '$regCode'";
  $result = mysqli_query($GLOBALS["conn"], $sql);

  return mysqli_num_rows($result);

}


function saveVisitedOffice($regCode, $office){

  if(trim($regCode) == ''){
    return false;
  }

  if(trim($office) == ''){
    return false;
  }

  if(validateRegCode($regCode) and checkIfRegVisited($regCode, $office) == 0 ){
    $sql = "INSERT INTO visited_offices (registration_code, office_name)
                                VALUES ('$regCode', '$office');";

    if (mysqli_multi_query($GLOBALS['conn'], $sql)) {
      $_SESSION["registration_code"] = $regCode;
      $_SESSION["noti"] = "Thank you for visiting $office.";
      return true;
    } else {
      $_SESSION["error"] = mysqli_error($GLOBALS['conn']);
      return false;
    }
  }else{
    $_SESSION["error"] = "Code already scanned for this department.";
    return false;
  }
}

function officeRegistration($uname, $pass, $office){
    if(empty($uname) or empty($pass) or empty($office)){
      return false;
    }

    $sql = "INSERT INTO users (user_name, password, office)
                                VALUES ('$uname', '$pass', '$office');";

    if (mysqli_multi_query($GLOBALS['conn'], $sql)) {
      $_SESSION["noti"] = "User has been successfully created.";
      return true;
    } else {
      $_SESSION["error"] = mysqli_error($GLOBALS['conn']);
      return false;
  }
}


function register($fn, $ln, $mdn, $email, $mn, $gen, $sn, $pc, $ps){
  if(checkRegistration($email) == 0){
    $registrationCode = generateRegCode();

    if(trim($registrationCode) == ''){
      return false;
    }

    $sql = "INSERT INTO visitors (registration_code, first_name, last_name, middle_name, email, mobile_no,
                                gender, school_name, preferred_course, preferred_strand)
                                VALUES ('$registrationCode', '$fn', '$ln', '$mdn', '$email', '$mn', '$gen', '$sn',
                                            '$pc', '$ps');";

      if (mysqli_multi_query($GLOBALS['conn'], $sql)) {
        $_SESSION["noti"] = "You have successfully registered to the system. Welcome to UB.";
        $_SESSION["registration_code"] = $registrationCode;
        return true;
      } else {
        $_SESSION["error"] = mysqli_error($GLOBALS['conn']);
        return false;
      }
    }else{
      $_SESSION["error"] = "Email already exists.";
      return false;
    }
}

function generateRegCode(){
  $totalData = getNoOfUsers() + 1;
  return "UB" . sprintf("%'.05d", $totalData);
}

function validateRegCode($rc){
  $sql = "SELECT * FROM visitors WHERE registration_code = '$rc'";
  $result = mysqli_query($GLOBALS["conn"], $sql);

  if(mysqli_num_rows($result) == 0){
    return FALSE;
  }

  return TRUE;

}

function checkRegistration($email){
  $sql = "SELECT * FROM visitors WHERE email = '$email'";
  $result = mysqli_query($GLOBALS["conn"], $sql);

  return mysqli_num_rows($result);

}

function saveVisit($rc){
  if(getQrCodeDetails($rc) == 0){
    $sql = "INSERT INTO visited_officer ();";

    if (mysqli_multi_query($GLOBALS['conn'], $sql)) {
      return true;
    } else {
      $_SESSION["error"] = mysqli_error($GLOBALS['conn']);
      return false;
    }
  }
}

function getQrCodeDetails($rc){
  $sql = "SELECT * FROM users WHERE registration_code = '$rc'";
  $result = mysqli_query($GLOBALS["conn"], $sql);

  $data = [];
  if (mysqli_num_rows($result) > 0) {
    // output data of each row
    while($row = mysqli_fetch_assoc($result)) {
      $data[] = $row;
    }
  }
  return $data;

}

function getNoOfUsers(){
  $sql = "SELECT id FROM visitors";
  $result = mysqli_query($GLOBALS["conn"], $sql);

  return mysqli_num_rows($result);

}

function exportToCsv($data){
$output = fopen('php://output', 'w');

fputcsv($output, ['First Name', 'Last Name', 'Middle Name',
                   'Email', 'Pref. Course', 'Pref. Strand',
                  'Registration Code', 'Visits']);

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="bestinationReport.csv"');

foreach ($data as $row) {
    fputcsv($output, $row);
}

fclose($output);
exit;
}

function exportToCsvAttendance($data){
  $output = fopen('php://output', 'w');
  
  fputcsv($output, ['ID', 'Registration Code', 'First Name', 'Last Name',
                     'Middle Name', 'Email', 'Mobile', 'Sex', 'School Name', 
                     'Pref. Course', 'Pref. Strand', 'Q1', 'Q2', 'Q3', 'Registered at',
                    'Visited Office', 'Visited at']);
  
  header('Content-Type: text/csv');
  header('Content-Disposition: attachment; filename="Bestination_Attendance.csv"');
  
  foreach ($data as $row) {
      fputcsv($output, $row);
  }
  
  fclose($output);
  exit;
  }


// function submitAnswer($studentNo, $wordNo, $answer, $isCorrect){
//   $sql = "INSERT INTO student_answers (student_no, word_no, answer, is_correct) VALUES ('$studentNo', '$wordNo', '$answer', '$isCorrect');";

//   if (mysqli_multi_query($GLOBALS['conn'], $sql)) {
//     echo "New records created successfully $wordNo <br>";
//   } else {
//     echo "Error: " . $sql . "<br>" . mysqli_error($GLOBALS['conn']);
//   }
// }

// function evaluateAnswer($data, $ans){
//   $eval = 0;
//   if (in_array($ans, $data)) {
//       $eval = 1;
//   }
//   return $eval;
// }


// function saveWord($wordNo, $word){

//   if(checkIfWordExisting($wordNo) == 0){
//     $sql = "INSERT INTO words (name, sequence_no) VALUES ('$word', '$wordNo');";


//     if (mysqli_multi_query($GLOBALS['conn'], $sql)) {
//       echo "New records created successfully $word <br>";
//     } else {
//       echo "Error: " . $sql . "<br>" . mysqli_error($GLOBALS['conn']);
//     }
//   }

// }

// function saveStudentLog($studentNo, $word){

//   if(checkIfStudentLog($studentNo, $word) == 0){
//     $sql = "INSERT INTO student_logs (student_no, last_word_no) VALUES ('$studentNo', '$word');";
//   }else{

//     $sDate = date("Y-m-d H:i:s");
//     $sql = "UPDATE student_logs SET last_word_no = '$word', updated_at='$sDate' WHERE student_no='$studentNo'";

//   }
//   if (mysqli_multi_query($GLOBALS['conn'], $sql)) {
//     echo "New records created successfully $word <br>";
//   } else {
//     echo "Error: " . $sql . "<br>" . mysqli_error($GLOBALS['conn']);
//   }

// }





// function getStudentLogs($studentNo){
//   $sql = "SELECT * FROM student_logs WHERE student_no = '$studentNo' order by last_word_no DESC";
//   $result = mysqli_query($GLOBALS["conn"], $sql);

//   $data = [];
//   if (mysqli_num_rows($result) > 0) {
//     // output data of each row
//     while($row = mysqli_fetch_assoc($result)) {
//       $data[] = $row;
//     }
//   }
//   return $data;

// }

// function getWords(){

//   $sql = "SELECT * FROM words ORDER by sequence_no ASC";
//   $result = mysqli_query($GLOBALS['conn'], $sql);

//   $data = [];
//   if (mysqli_num_rows($result) > 0) {
//     // output data of each row
//     while($row = mysqli_fetch_assoc($result)) {
//       $data[] = strtolower($row['name']);
//     }
//   }
//   return $data;

// }

// function getWordByNo($wordNo ){

//   $sql = "SELECT * FROM words WHERE sequence_no='$wordNo' ORDER BY created_at DESC";
//   $result = mysqli_query($GLOBALS['conn'], $sql);

//   $data = [];
//   if (mysqli_num_rows($result) > 0) {
//     // output data of each row
//     while($row = mysqli_fetch_assoc($result)) {
//       $data[] = strtolower($row['name']);
//     }
//   }
//   if(count($data)){
//     return $data[0];
//   }

// }


// function deleteWord($wordNo){
//   if(checkIfWordExisting($wordNo) == 0){
//     $sql = "DELETE FROM words WHERE sequence_no='$wordNo'";
//     if (mysqli_multi_query($GLOBALS['conn'], $sql)) {
//       echo "New records created successfully $wordNo <br>";
//     } else {
//       echo "Error: " . $sql . "<br>" . mysqli_error($GLOBALS['conn']);
//     }
//   }
// }

// function deleteAnswers($wordNo){
//   if(checkIfWordExisting($wordNo) > 0){
//     $sql = "DELETE FROM word_answers WHERE word_no='$wordNo'";
//     if (mysqli_multi_query($GLOBALS['conn'], $sql)) {
//       echo "Deleted records created successfully $wordNo <br>";
//     } else {
//       echo "Error: " . $sql . "<br>" . mysqli_error($GLOBALS['conn']);
//     }
//   }
// }

// function checkIfWordExisting($wordNo){
//   $sql = "SELECT name FROM words WHERE sequence_no = '$wordNo'";
//   $result = mysqli_query($GLOBALS["conn"], $sql);

//   return mysqli_num_rows($result);

// }


// function getResult(){
//   $sql = "SELECT student_no as sid, (SELECT SUM(is_correct) FROM `student_answers` WHERE student_answers.student_no = sid LIMIT 0,1) AS score, (SELECT created_at FROM `student_answers` WHERE student_answers.student_no = sid AND word_no=10 order by created_at desc limit 0,1) AS submitted_time FROM `student_answers` GROUP BY student_no ORDER by score DESC LIMIT 0, 8";
//   $result = mysqli_query($GLOBALS['conn'], $sql);

//   $data = [];
//   if (mysqli_num_rows($result) > 0) {
//     // output data of each row
//     while($row = mysqli_fetch_assoc($result)) {
//       $data[] = $row;
//     }
//   }
//   return $data;
// }

// function getResultv2(){
//   $sql = "SELECT id,student_no as sid, (SELECT SUM(is_correct) FROM `student_answers` WHERE student_answers.student_no = sid LIMIT 0,1) AS score, (SELECT created_at FROM `student_answers` WHERE student_answers.student_no = sid AND word_no=10 order by created_at desc limit 0,1) AS submitted_time FROM `student_answers` GROUP BY student_no ORDER by score DESC LIMIT 0, 7";
//   $result = mysqli_query($GLOBALS['conn'], $sql);

//   $data = [];
//   if (mysqli_num_rows($result) > 0) {
//     // output data of each row
//     while($row = mysqli_fetch_assoc($result)) {
//       $data[] = $row;
//     }
//   }
//   return $data;
// }

// function getResultPerStudentPerWord($studentNo = '' ){

//   $sql = "SELECT student_no as sid, word_no as swrd, (SELECT SUM(is_correct) FROM `student_answers` WHERE student_answers.student_no = sid and student_answers.word_no = swrd LIMIT 0,1) AS score, (SELECT created_at FROM `student_answers` WHERE student_answers.student_no = sid AND word_no=swrd order by created_at desc limit 0 ,1) AS submitted_time FROM `student_answers` WHERE student_no='$studentNo' GROUP BY student_no, swrd ORDER by sid DESC";

//   $result = mysqli_query($GLOBALS['conn'], $sql);

//   $data = [];
//   if (mysqli_num_rows($result) > 0) {
//     // output data of each row
//     while($row = mysqli_fetch_assoc($result)) {
//       $data[] = $row;
//     }
//   }
//   return $data;
// }
