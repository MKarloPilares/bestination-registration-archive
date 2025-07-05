<?php
include_once 'sql/db_con.php';
include_once 'sql/modules.php';

// if(!isset($_SESSION["username"],$_SESSION["office"])){
//   redirect("login.php");
// }


if (isset($_SESSION["registration_code"])) {
  $_SESSION["registration_code"] = "";
  unset($_SESSION["registration_code"]);
}

if (isset($_SESSION["office"])) {
  $office = $_SESSION["office"];
} else {
  redirect("login.php");
}

include_once 'sql/scan.php';


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

  <script type="text/javascript" src="https://rawgit.com/schmich/instascan-builds/master/instascan.min.js"></script>

  <style>
    video {
      width: 100%;
      height: 100%;
      object-fit: cover;
      border-radius: 20px;
    }
  </style>

  <style>
    #stch-camera {
      background-color: #6c757d;
      color: white;
      border: none;
      padding: 8px 16px;
      border-radius: 20px;
      margin-top: 10px;
    }

    #stch-camera:hover {
      background-color: #5a6268;
    }

    /* Hide button by default until we confirm multiple cameras exist */
    #switch-camera {
      margin-top: 10px;
      margin-bottom: 10px;
      display: none;
      z-index: 0;
    }
  </style>


  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="mobile-web-app-capable" content="yes">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>

<body>
  <div class="container mobile-container">
    <form id="my-form" method="post">
      <div class="row">
        <div class="col"><img class="Logo" src="assets/img/UBLipaCity.png" style="text-align: center;">
        </div>
        <div class="col-xl-12 text-center">
          <?php if (isset($_SESSION['error'])) { ?>
            <div class="alert alert-danger">
              <?php echo $_SESSION['error']; ?>
            </div>
          <?php } ?>
          <h1 class="scanheading">Scan the QR code</br></h1>
          <p class="pinklabel2" style="font-weight: bold;"><?php echo $_SESSION["office"]; ?></p>
        </div>

        <?php if (isset($_SESSION["attendance_noti"])) { ?>
          <div class="col text-center" style="margin-top: 50px;">
            <div class="alert alert-success" role="alert">
              <?php echo $_SESSION["attendance_noti"];
              unset($_SESSION["attendance_noti"]); ?>
            </div>
          </div>
        <?php } ?>

        <div class="col-xl-12 text-center">

          <video id="preview"></video>




          <button type="button" id="switch-camera" class="btn btn-secondary">
            <i class="fas fa-camera-rotate"></i> Switch Camera
          </button><br>

        </div>

      </div>

      <br>

      <div class="row" style="padding:20px">
        <div class="col">
          <p class="pinklabel">Registration:</p>
          <input type="text" name="reg_code" class="pinktextbox" id="reg_code" placeholder="Registration Code" required>

        </div>
      </div>
      <div class="col text-center" style="margin-top: 50px;"><button class="btn btn-primary registerbtn"
          type="submit">Done</button></div>

      <div class="col text-center" style="margin-top: 10px;"><a href="registrations.php" class="btn btn-primary registerbtn"
          type="button">View Attendance</a></div>
      <div class="col text-center" style="margin-top: 10px;"><a href="report.php" class="btn btn-primary registerbtn"
          type="submit">View Visits</a></div>
      <div class="col text-center" style="margin-top: 10px;"><a href="login.php" class="btn btn-primary registerbtn"
          type="submit">Log Out</a></div>
    </form>
  </div>
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>


  <script type="text/javascript">
    // Check if we're using HTTPS
    if (location.protocol !== 'https:' && location.hostname !== 'localhost') {
      alert('Camera access requires HTTPS. Please use a secure connection.');
    }

    let scanner = new Instascan.Scanner({
      video: document.getElementById('preview'),
      mirror: false
    });

    let currentCameraIndex = 0;
    let cameras = [];

    async function startCamera(cameraIndex = 0) {
      try {
        cameras = await Instascan.Camera.getCameras();

        if (cameras.length > 0) {
          await scanner.start(cameras[cameraIndex]);

          // Show switch camera button only if multiple cameras exist
          if (cameras.length > 1) {
            document.getElementById('switch-camera').style.display = 'block';
          }
        } else {
          alert('No cameras found. Please make sure you have granted camera permissions.');
        }
      } catch (error) {
        console.error('Camera access error:', error);
        alert('Could not access the camera. Please make sure you have granted camera permissions.');
      }
    }

    // Start camera when page loads
    startCamera();

    // Add switch camera functionality
    document.getElementById('switch-camera').addEventListener('click', async () => {
      currentCameraIndex = (currentCameraIndex + 1) % cameras.length;
      await scanner.stop();
      await startCamera(currentCameraIndex);
    });

    // QR code scanning listener
    scanner.addListener('scan', function(content) {
      document.getElementById("reg_code").value = content;
      let form = document.getElementById('my-form');
      form.submit();
    });
  </script>

</body>

</html>