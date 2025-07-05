<?php
require_once "sql/db_con.php";
require_once "sql/modules.php";

if (empty($_SESSION['office'])) {
  redirect("scan.php");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['export'])) {
  $visitors = getVisitors();
  exportToCsv($visitors);
  exit;
}

//Gets visitors with visits more than or equal to 5
$visitors = getVisitors();

?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>UBBC Bestination</title>
  <link rel="stylesheet" href="assets/bootstrap/css/bootstrap.min.css">
  <link rel="stylesheet" href="assets/css/styles.min.css">
  <link rel="stylesheet" href="assets/css/table.css">
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
</head>

<body>
  <div class="col-12" style="text-align: center;margin-top: 40px;"><img
        src="assets/img/UBestinationLogo1.svg" width="300px" height="100px">
  
      <h2>Report</h2>
      <div class="col text-center" style="margin-top: 10px;"><a href="scan.php" class="btn btn-primary registerbtn"
      type="submit">Back to Scan</a></div>
      <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">


        <div class="col text-center" style="margin-top: 10px;">
          <button type="submit" name="export" class="btn btn-primary registerbtn">Export to CSV</button>
        </div>
    </form>
  </div>
  <div class="table-wrapper">
    <br>

    <table class="fl-table">
      <thead>
        <tr>
          <th>First Name</th>
          <th>Last Name</th>
          <th>Middle Name</th>
          <th>Email</th>
          <th>Pref. Course</th>
          <th>Pref. Strand</th>
          <th>Registration Code</th>
          <th>Visits</th>
        </tr>
      </thead>
      <tbody>

        <?php
        $x = 1;
        foreach ($visitors as $visitor) {

        ?>
          <tr>
            <td><?php echo $visitor["first_name"]; ?></td>
            <td><?php echo $visitor["last_name"]; ?></td>
            <td><?php echo $visitor["middle_name"]; ?></td>
            <td><?php echo $visitor["email"]; ?></td>
            <td><?php echo $visitor["preferred_course"]; ?></td>
            <td><?php echo $visitor["preferred_strand"]; ?></td>
            <td><?php echo $visitor["registration_code"]; ?></td>
            <td><?php echo $visitor["cnt"]; ?></td>
          </tr>
        <?php $x++;
        } ?>

      <tbody>
    </table>
  </div>
</body>

</html>