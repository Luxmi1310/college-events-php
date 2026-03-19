<?php include_once("include/header.php"); ?>
<?php
// MUST be first
error_reporting(E_ALL);
ini_set('display_errors', 1);

// PHPMailer includes
require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


// --------------------
// 1️⃣ Check Required Session Data
// --------------------
if (!isset($_SESSION['temp_user_email']) || !isset($_SESSION['otp'])) {
    die("Session expired or OTP not set. Go back to signup page.");
}

$email = $_SESSION['temp_user_email'];
$otp   = $_SESSION['otp'];


// --------------------
// 2️⃣ Send OTP Email (Only Once)
// --------------------
if (!isset($_SESSION['otp_sent'])) {

    $mail = new PHPMailer(true);

    try {
        // SMTP SETTINGS
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'singhluxmi86@gmail.com';  // 🔴 PUT YOUR GMAIL
        $mail->Password   = 'kzltspyzmkstuvwu'; // 🔴 PUT APP PASSWORD
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        // Optional: Uncomment to debug
        // $mail->SMTPDebug = 2;
        // $mail->Debugoutput = 'html';

        $mail->setFrom('yourgmail@gmail.com', 'AMR-ERU System');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Your OTP Verification Code';
        $mail->Body    = "
            <h3>Your Identity Verification Code</h3>
            <p>Your OTP is: <b style='font-size:24px;color:#0d6efd;'>$otp</b></p>
            <p>This code expires in 5 minutes.</p>
        ";
        $mail->AltBody = "Your OTP is: $otp";

        if (!$mail->send()) {
            die("Mailer Error: " . $mail->ErrorInfo);
        }

        $_SESSION['otp_sent'] = true;
        $success = "OTP sent successfully to your email.";

    } catch (Exception $e) {
        die("Message could not be sent. Error: " . $mail->ErrorInfo);
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $enteredOtp = $_POST['otp_input'];

    if (!isset($_SESSION['otp'])) {
        die("Session expired.");
    }

    // Check expiry
    if (time() > $_SESSION['otp_expiry']) {
        die("OTP expired. Please resend.");
    }

    // Check OTP match
    // Check OTP match
if ($enteredOtp == $_SESSION['otp']) {

    // ✅ 1. CREATE THE "ACCESS KEY" (Crucial for create_pass.php)
    $_SESSION['otp_verified'] = true;

    // ✅ 2. FORMAT THE EMAIL ARRAY (Crucial for the UPDATE query)
    $_SESSION['temp_user'] = [
        'email' => $_SESSION['temp_user_email']
    ];

    // 3. Success cleanup
    unset($_SESSION['otp']);
    unset($_SESSION['otp_sent']);

    // ✅ 4. REDIRECT WITHOUT EXTRA ECHO
    header("Location: create_pass.php");
    exit(); // Always use exit after header!

} else {
    echo "<h3 style='color:red;text-align:center;'>Invalid OTP</h3>";
}
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="stylesheet" href="assets/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="assets/css/animate.min.css"> 
    <link rel="stylesheet" href="assets/css/boxicons.min.css">  
    <link rel="stylesheet" href="assets/css/magnific-popup.min.css">
    <link rel="stylesheet" href="assets/css/fancybox.min.css"> 
    <link rel="stylesheet" href="assets/css/meanmenu.min.css"> 
    <link rel="stylesheet" href="assets/css/flaticon.css"> 
    <link rel="stylesheet" href="assets/css/odometer.min.css"> 
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css"> 
    <link rel="stylesheet" href="assets/css/owl.theme.default.min.css"> 
    <link rel="stylesheet" href="assets/css/scrollCue.css"> 
    <link rel="stylesheet" href="assets/css/style.css"> 
    <link rel="stylesheet" href="assets/css/responsive.css"> 
    <link rel="stylesheet" href="assets/css/dark.css"> 

    <title>Nestu - Login</title>
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
</head>
    
       <style>
        /* OTP Box Styling */
        .otp-wrapper { display: flex; gap: 10px; justify-content: center; margin: 20px 0; }
        .otp-box {
            width: 50px; height: 60px; text-align: center; font-size: 24px;
            font-weight: bold; border: 2px solid #ddd; border-radius: 8px;
            background: #fff; transition: all 0.3s;
        }
        .otp-box:focus { border-color: #007bff; outline: none; box-shadow: 0 0 5px rgba(0,123,255,0.5); }
        /* Hide the actual hidden input */
        #actual_otp { position: absolute; opacity: 0; pointer-events: none; }
    </style>
<body>
    
    
    <?php include_once("include/navbar.php"); ?>
	
    
    <div class="col-md-6 mx-auto mt-5">
        <div class="section-title text-center">
            <h2>Verify OTP</h2>
        </div>

        <?php if(isset($error)): ?>
            <p style="color:red; text-align:center;"><?= $error ?></p>
        <?php endif; ?>

        <div class="wrapper-full text-center">
            <form method="POST" action="" id="otpForm">
                <input type="hidden" name="otp_input" id="actual_otp" required>

                <div class="otp-wrapper">
    <input type="text" class="otp-box" maxlength="1" oninput="moveToNext(this, 0)" onkeydown="moveBack(this, 0)">
    <input type="text" class="otp-box" maxlength="1" oninput="moveToNext(this, 1)" onkeydown="moveBack(this, 1)">
    <input type="text" class="otp-box" maxlength="1" oninput="moveToNext(this, 2)" onkeydown="moveBack(this, 2)">
    <input type="text" class="otp-box" maxlength="1" oninput="moveToNext(this, 3)" onkeydown="moveBack(this, 3)">
    <input type="text" class="otp-box" maxlength="1" oninput="moveToNext(this, 4)" onkeydown="moveBack(this, 4)">
    <input type="text" class="otp-box" maxlength="1" oninput="moveToNext(this, 5)" onkeydown="moveBack(this, 5)">
</div>

                <button type="submit" class="btn btn-primary w-100">Verify OTP</button>
                <br><br>
                <a href="?resend=1">Resend OTP</a>
            </form>
        </div>
        <br><br><br>
    </div>

    <?php include_once("include/footer.php"); ?>
<script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/meanmenu.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script> 
    <script src="assets/js/custom.js"></script>
    <script>
    const boxes = document.querySelectorAll('.otp-box');
    const hiddenInput = document.getElementById('actual_otp');

    function updateHiddenInput() {
        let fullOtp = "";
        boxes.forEach(box => fullOtp += box.value);
        hiddenInput.value = fullOtp;
    }

    function moveToNext(current, index) {
        current.value = current.value.replace(/[^0-9]/g, "");
        
        if (current.value && index < 5) {
            boxes[index + 1].focus();
        }
        updateHiddenInput();
    }

    function moveBack(current, index) {
        if (event.key === "Backspace" && !current.value && index > 0) {
            boxes[index - 1].focus();
        }
    }
    </script>
</body>
</html>