<?php
require_once "sql/db_con.php";
require_once "sql/modules.php";

if(isset($_GET['office']) and !empty($_GET['office'])){
  $key = get("office");
  $students = searchRegistrationByOffice($key);
}elseif(isset($_GET['key']) and !empty($_GET['key'])){
  $key = get("key");
  $students = searchRegistration($key);
}else{
  $students = getRegistrations();
}
// var_dump($results);
// exit();

if (isset($_GET['export'])) {
  exportToCsvAttendance($students);
}
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
        <h2>Registrations</h2>

        <div class="col text-center" style="margin-top: 10px;"><a href="scan.php" class="btn btn-primary registerbtn"
        type="submit">Back to Scan</a></div>
  </div>

  <form method="GET">
    <?php if (isset($_GET['office']) && !empty($_GET['office'])): ?>
      <input type="hidden" name="office" value="<?php echo htmlspecialchars($_GET['office']); ?>">
    <?php endif; ?>
    <?php if (isset($_GET['key']) && !empty($_GET['key'])): ?>
      <input type="hidden" name="key" value="<?php echo htmlspecialchars($_GET['key']); ?>">
    <?php endif; ?>
    <div class="col text-center" style="margin-top: 10px;">
      <button value="export" type="submit" name="export" class="btn btn-primary registerbtn">Export to CSV</button>
    </div>
  </form>

<div class="table-wrapper">

  <form method="GET">
    <select name="office" id=""  onchange="this.form.submit();">
        <option value="">All</option>
            <option value="CBAHM" <?php echo (isset($_GET['office']) && $_GET['office'] == 'CBAHM') ? 'selected' : ''; ?>>CBAHM</option>
            <option value="CIT" <?php echo (isset($_GET['office']) && $_GET['office'] == 'CIT') ? 'selected' : ''; ?>>CIT</option>
            <option value="CAS" <?php echo (isset($_GET['office']) && $_GET['office'] == 'CAS') ? 'selected' : ''; ?>>CAS</option>
            <option value="CEDU" <?php echo (isset($_GET['office']) && $_GET['office'] == 'CEDU') ? 'selected' : ''; ?>>CEDU</option>
            <option value="CCJE" <?php echo (isset($_GET['office']) && $_GET['office'] == 'CCJE') ? 'selected' : ''; ?>>CCJE</option>
            <option value="CNM" <?php echo (isset($_GET['office']) && $_GET['office'] == 'CNM') ? 'selected' : ''; ?>>CNM</option>
            <option value="CAMS" <?php echo (isset($_GET['office']) && $_GET['office'] == 'CAMS') ? 'selected' : ''; ?>>CAMS</option>
            <option value="CENG" <?php echo (isset($_GET['office']) && $_GET['office'] == 'CENG') ? 'selected' : ''; ?>>CENG</option>
            <option value="CICT" <?php echo (isset($_GET['office']) && $_GET['office'] == 'CICT') ? 'selected' : ''; ?>>CICT</option>
          </select>
    <input type="text" placeholder="Search by last or first name" name="key" onchange="this.form.submit();">

    <a href="regen_qr.php">Regenerate QR</a>
  </form>
  <br>

  <?php if(isset($_GET['office']) and !empty($_GET['office'])){ ?>
    <h3><?php echo $key; ?></h3>
  <?php } ?>
    <table class="fl-table">
        <thead>
        <tr>
            <th>ID</th>
            <th>Registration Code</th>
            <th>Last name</th>
            <th>First name</th>
            <th>Email</th>
            <th>Mobile</th>
            <th>Sex</th>
            <th>School name</th>
            <th>Preferred Course</th>
            <th>Preferred Strand</th>
            <?php if(isset($_GET['office']) and !empty($_GET['office'])){ ?>
              <th>Date</th>
            <?php }else{  ?>
              <th>Registered at</th>
            <?php } ?>

        </tr>
        </thead>
        <tbody>

        <?php
        $x = 1;
        foreach($students as $student) {
          ?>
        <tr>
            <td><?php echo $x; ?></td>
            <td><?php echo $student["registration_code"]; ?></td>
            <td><?php echo ucwords($student["last_name"]); ?></td>
            <td><?php echo ucwords($student["first_name"]); ?></td>
            <td><?php echo $student["email"]; ?></td>
            <td><?php echo $student["mobile_no"]; ?></td>
            <td><?php echo $student["gender"]; ?></td>
            <td><?php echo $student["school_name"]; ?></td>
            <td><?php echo $student["preferred_course"]; ?></td>
            <td><?php echo $student["preferred_strand"]; ?></td>
            <td><?php
            if(isset($_GET['office']) and !empty($_GET['office'])){
              echo $student["vdate"];
            }else{
              echo $student["created_at"];
            }
            ?></td>
        </tr>
        <?php $x++; } ?>

        <tbody>
    </table>
</div>
</body>
</html>