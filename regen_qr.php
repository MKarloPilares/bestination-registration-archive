<?php
session_start();
$_SESSION["registration_code"] = "A01";

if($_SERVER["REQUEST_METHOD"] == "POST"){
  $_SESSION["registration_code"] = $_POST["appid"];
}

// Generate the QR code image
$registration_code = $_SESSION["registration_code"];
$qr_code_file = 'qr_code_' . $registration_code . '.png';

// Check if the QR code image file already exists
if (!file_exists($qr_code_file)) {
    // If not, generate a new one
    $qr_code_url = 'http://api.qrserver.com/v1/create-qr-code/?data=' . urlencode($registration_code) . '&choe=UTF-8';
    file_put_contents($qr_code_file, file_get_contents($qr_code_url));
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
    <div class="row">
      <div class="col"><img class="Logo" src="assets/img/UBLipaCity.png" style="text-align: center;">
      </div>
      <div class="col-xl-12 text-center"><img class="doneimage" id="my-element" src="assets/img/done.svg">
      <?PHP if($_SERVER["REQUEST_METHOD"] != "POST"){ ?>
        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post">
          <h1 class="welcome">Regenerate QR</h1>
          <input class="pinktextbox" type="text" name="appid" id="appid" placeholder="Enter registration code" required>
          <br>
          <br>
          <button class="btn btn-primary registerbtn" type="submit">Regenerate</button>
        </form>

      <?PHP } ?>
      <?PHP if($_SERVER["REQUEST_METHOD"] == "POST"){ ?>
        <h1 class="welcome">Well Done!</h1>
        <p class="blacklabel2">Please take a screenshot of this QR Code.</p>


      </div>
      <div class="col text-center">
      <img src="http://api.qrserver.com/v1/create-qr-code/?data=<?php echo $_SESSION["registration_code"]; ?>&size=300x300" title="View profile" />

        <p class="blacklabel3">Registration No. <?php echo $_SESSION["registration_code"]; ?></p>
        <a href="<?php echo $qr_code_file; ?>" download="qr-code.png">Download QR Code</a>
      </div>
      <?PHP } ?>
      <div class="col text-center"><a href="registrations.php"><button class="btn exitbtn" type="button">Exit</button></a></div>
    </div>
  </div>
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>



<script>
function downloadQRCode() {
    // Get the QR code image element
    let qrCodeImg = document.getElementById('qrCodeImg');

    // Create a new canvas element
    let canvas = document.createElement('canvas');
    canvas.width = qrCodeImg.width;
    canvas.height = qrCodeImg.height;

    // Get the canvas context
    let context = canvas.getContext('2d');

    // Draw the QR code image onto the canvas
    context.drawImage(qrCodeImg, 0, 0);

    // Convert the canvas to a PNG data URL
    let dataUrl = canvas.toDataURL('image/png');

    // Create a download link and click it to download the PNG file
    let downloadLink = document.createElement('a');
    downloadLink.href = dataUrl;
    downloadLink.download = 'qr-code.png';
    downloadLink.click();
}
</script>
</body>

</html>