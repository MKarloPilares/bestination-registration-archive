<?php

include_once 'sql/db_con.php';
include_once 'sql/modules.php';

include_once 'sql/register.php';

$sqlc = "SELECT * FROM updated_courses order by crse_desc asc";
$resultc = odbc_exec($connSlims, $sqlc);

$course_list = [];
while (odbc_fetch_row($resultc)) {
  $course = odbc_result($resultc, "crse_code");
  $course_desc = odbc_result($resultc, "crse_desc");
  $course_list[$course] = $course_desc;
}

$sqlshs = "SELECT * FROM course_K12 order by crse_desc asc";
$resultshs = odbc_exec($connSlims, $sqlshs);

$strandList = [];
while (odbc_fetch_row($resultshs)) {
  $shs = odbc_result($resultshs, "crse_code");
  $shs_desc = odbc_result($resultshs, "crse_desc");
  $strandList[$shs] = $shs_desc;
}

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
    <div class="col">
      <img class="Logo" src="assets/img/[full-color]-UB-Lipa-City.png">
      <div class="col text-center">
        <h1 class="reg">Student Registration</h1>

        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog"
          aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Data Privacy Statement</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <p style="text-align: justify">
                  By providing your personal information in this form, you hereby affirm that the
                  information is accurate and correct. By submitting this form, you grant your consent
                  for UBBC BESTINATION to use the provided information solely for purposes related to
                  the event, in accordance with RA 10173 (Data Privacy Act of 2012) and other relevant
                  Philippine laws.

                  In addition to providing your personal information, signing this form also gives
                  UBBC the right to use your image for documentation and publicity purposes. You
                  acknowledge that you have no interest or ownership in the video/photo or its
                  copyright.

                  Furthermore, you grant UBBC the right to broadcast, exhibit, market, sell, and
                  otherwise distribute the video/photo, either in whole or in parts, and either alone
                  or with other products. In consideration of all of the above, you hereby acknowledge
                  receipt of favorable and fair consideration.

                  By signing this form, you confirm your understanding and agreement with the terms
                  outlined above.</p>
              </div>
              <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="row">
      <div class="col-md-1"></div>
      <div class="col-md-10">
        <?php if (isset($_SESSION['error'])) { ?>
          <div class="alert alert-danger">
            <?php echo $_SESSION['error']; ?>
          </div>
        <?php } ?>
        <div class="form-group">
          <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="POST">


            <p class="pinklabel">Last Name:</p><input type="text" name="last_name" class="pinktextbox"
              placeholder="Enter your Last name" value="<?php echo old('last_name'); ?>" required>
            <p class="pinklabel">First Name:</p><input type="text" name="first_name" class="pinktextbox"
              placeholder="Enter your First name" value="<?php echo old('first_name'); ?>" required>
            <p class="pinklabel">Middle Name:</p><input type="text" name="middle_name" class="pinktextbox"
              placeholder="Enter your Middle name" value="<?php echo old('middle_name'); ?>" required>
            <p class="pinklabel">Email:</p><input type="email" name="email" class="pinktextbox"
              placeholder="Enter your Email Address" value="<?php echo old('email'); ?>" required>
            <p class="pinklabel">Mobile Number:</p><input type="text" name="mobile_no" class="pinktextbox"
              placeholder="Enter your Mobile Number" value="<?php echo old('mobile_no'); ?>" required>
            <p class="pinklabel">Gender:</p><select type="text" name="gender" class="pinktextbox" required>
              <option value="Male">Male</option>
              <option value="Female">Female</option>
            </select>
            <p class="pinklabel">Name of your school:</p><input type="text" name="school_name"
              class="pinktextbox" placeholder="Enter your school name"
              value="<?php echo old('school_name'); ?>" required>
            <p class="pinklabel">Grade Level</p>
            <select type="text" name="grade_level" class="pinktextbox" required id="gradeLevel">
              <option value=""> Select Grade Level </option>
              <option value="10">Grade 10</option>
              <option value="12">Grade 12</option>
            </select>
            <div id="courseSection" style="display: none;">
              <p class="pinklabel">Preferred Course (for incoming College)</p>
              <select type="text" name="preferred_course" class="pinktextbox" id="preferredCourse">
                <option value=""> Select Preferred Course </option>
                <?php foreach ($course_list as $course => $course_desc): ?>
                  <option value="<?php echo $course; ?>"><?php echo formatStrandCourse($course_desc); ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div id="strandSection" style="display: none;">
              <p class="pinklabel">Preferred Strand (for incoming Senior High School)</p>
              <select id="strand" type="text" name="preferred_strand" class="pinktextbox"
                onchange="handleStrandChange(this.value)">
                <option value=""> Select Preferred Strand </option>
                <?php foreach ($strandList as $strand => $strand_desc): ?>
                  <option value="<?php echo $strand; ?>"><?php echo formatStrandCourse($strand_desc); ?>
                  </option>
                <?php endforeach; ?>
                <option value="Sports Track">Sports Track (For Approval)</option>
                <option value="others">Others</option>
              </select>
              <div id="otherStrandInput" style="display: none;">
                <p class="pinklabel">Others:</p>
                <input type="text" name="other_strand" class="pinktextbox">
              </div>
            </div>
            <button class="btn text-center btnpink poppins-extrabold" type="submit">
              Finished
            </button>
          </form>
        </div>
      </div>
      <div class="col-md-1"></div>
    </div>
  </div>
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>
  <script>
    $(document).ready(function() {
      <?php if (!isset($_SESSION['error'])) { ?>
        $('#exampleModal').modal('show');
      <?php } ?>
    });

    document.getElementById('gradeLevel').addEventListener('change', function() {
      const courseSection = document.getElementById('courseSection');
      const strandSection = document.getElementById('strandSection');
      const preferredCourse = document.getElementById('preferredCourse');
      const strand = document.getElementById('strand');

      if (this.value === '12') {
        courseSection.style.display = 'block';
        strandSection.style.display = 'none';
        preferredCourse.required = true;
        strand.required = false;
      } else if (this.value === '10') {
        courseSection.style.display = 'none';
        strandSection.style.display = 'block';
        preferredCourse.required = false;
        strand.required = true;
      } else {
        courseSection.style.display = 'block';
        strandSection.style.display = 'block';
        preferredCourse.required = false;
        strand.required = false;
      }
    });

    function handleStrandChange(selectedValue) {
      console.log(selectedValue);
      if (selectedValue === 'others') {
        document.getElementById('otherStrandInput').style.display = 'block';
      } else {
        document.getElementById('otherStrandInput').style.display = 'none';
      }
    }
  </script>


</body>

</html>