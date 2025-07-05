<?php
session_start();
if (!isset($_SESSION["registration_code"])) {
  header("Location: registration.php");
  exit();
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
  <script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
</head>

<body>
  <div class="container mobile-container">
    <div class="row">
      <div class="col"><img class="Logo" src="assets/img/ublogo.png" style="text-align: center;">
      </div>
      <div class="col-xl-12 text-center">
        <h1 class="greet ">THANK YOU FOR REGISTERING!</h1>
      </div>
      <div class="col-12 pt-4 text-center my-element" id="my-element">
        <img src="http://api.qrserver.com/v1/create-qr-code/?data=<?php echo $_SESSION["registration_code"]; ?>&size=300x300"
          title="View profile" />
        <p class="blacklabel3">Registration No. <span
            class="regnum"><?php echo $_SESSION["registration_code"]; ?></span>
        </p>
      </div>
      <p class="blacklabe2 mb-4 text-justify">A unique QR code has been generated for you. Please capture or
        save this
        QR code as you’ll need it to visit and check in at each department's exhibit. Please present
        your QR code at each booth to be scanned by our team for your attendance. </p>
      <div class="col-12 text-center">
        <a href="#" onclick="saveHtmlImage(document.getElementById('my-element'));">
          <button class="btn registerbtn poppins-extrabold mb-5" type="button">
            DOWNLOAD QR
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24"
              color="#ffffff" fill="none">
              <path
                d="M12 14.5L12 4.5M12 14.5C11.2998 14.5 9.99153 12.5057 9.5 12M12 14.5C12.7002 14.5 14.0085 12.5057 14.5 12"
                stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                stroke-linejoin="round" />
              <path d="M20 16.5C20 18.982 19.482 19.5 17 19.5H7C4.518 19.5 4 18.982 4 16.5"
                stroke="currentColor" stroke-width="2.5" stroke-linecap="round"
                stroke-linejoin="round" />
            </svg>
          </button>
        </a>
      </div>
    </div>
  </div>
  <script src="assets/js/jquery.min.js"></script>
  <script src="assets/bootstrap/js/bootstrap.min.js"></script>

  <script>
    function saveHtmlImage(element) {
      // Wait for QR code image to load
      const qrImage = element.querySelector('img');

      // Create a promise that resolves when the image is loaded
      const imageLoaded = new Promise((resolve) => {
        if (qrImage.complete) {
          resolve();
        } else {
          qrImage.onload = resolve;
        }
      });

      // Wait for image to load before capturing
      imageLoaded.then(() => {
        html2canvas(element, {
          useCORS: true, // Enable CORS for external images
          allowTaint: true // Allow cross-origin images
        }).then(function(canvas) {
          // Convert the canvas to a data URL
          var imgData = canvas.toDataURL('image/png');

          // Create a download link
          var link = document.createElement('a');
          link.download = 'qr-code.png';
          link.href = imgData;

          // Click the link to trigger the download
          document.body.appendChild(link);
          link.click();
          document.body.removeChild(link);
        });
      });
    }
  </script>
</body>

</html>