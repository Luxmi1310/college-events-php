<?php include_once("include/header.php"); ?>
<?php
// MUST be first
require 'db_config.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $name  = mysqli_real_escape_string($conn, $_POST['fullname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    // Generate ONE OTP only
    $otp = rand(100000, 999999);

    // Check if already registered
    $checkQuery  = "SELECT id FROM student WHERE Email = '$email' OR Phone = '$phone'";
    $checkResult = mysqli_query($conn, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {

        $_SESSION['error'] = "You are already registered with this email or phone number.";

    } else {

        $sql = "INSERT INTO student (Name, Email, Phone, OTP)
                VALUES ('$name', '$email', '$phone', '$otp')";

        if (mysqli_query($conn, $sql)) {

            // Store correct session values
            $_SESSION['temp_user_email'] = $email;
            $_SESSION['temp_user_name']  = $name;
            $_SESSION['otp']             = $otp;
            $_SESSION['otp_expiry']      = time() + 300; // 5 minutes
            $_SESSION['otp_attempts']    = 0;
            unset($_SESSION['otp_sent']); // allow fresh send

            header("Location: send-otp.php");
            exit;

        } else {
            die("Database Error: " . mysqli_error($conn));
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<!-- Mirrored from templates.hibotheme.com/nestu/default/my-account.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 19 Jan 2026 09:56:40 GMT -->
<head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">

       <!--=== Link Of CSS Files ===-->
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

        <!--=== Title & Favicon ===-->
        <title>Nestu - Event Conference & Reunion HTML Template</title>
        <link rel="icon" type="image/png" href="assets/images/favicon.png">
    
    <style>
        

        span.error-msg {
            color: red;
            font-size: 13px;
            display: block;
            margin-bottom: 10px;
            margin-top: -10px;
        }
    </style>
</head>
<body>
    
			<?php include_once("include/navbar.php");  ?>

    <div class="col-md-6 mx-auto signup-container">
        <div style="background:#f8f9fa; padding:30px; border-radius:10px; box-shadow:0 0 10px rgba(0,0,0,0.1);">
		<?php
if (isset($_SESSION['error'])) {
    echo '<div class="alert alert-danger">'.$_SESSION['error'].'</div>';
    unset($_SESSION['error']);
}
?>

            <form method="POST" onsubmit="return valid()">
                <h2 class="mb-4">Sign Up</h2>

                <input type="text" name="fullname" class="form-control mb-3" placeholder="Full Name" id="user">
                <span id="usernameError" class="error-msg"></span>

                <input type="email" name="email" class="form-control mb-3" placeholder="Email Address" id="email">
                <span id="useremail" class="error-msg"></span>

                <input type="tel" name="phone" class="form-control mb-3" placeholder="Phone Number" id="Number">
                <span id="number" class="error-msg"></span>

                <button type="submit" class="btn btn-primary w-100">Create account</button>
            </form>
        </div>
    </div>
<br>
<br>
<br>

    <?php include_once("include/footer.php"); ?>
 <script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/meanmenu.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script> 
        <script src="assets/js/bootstrap-datepicker.min.js"></script>
        <script src="assets/js/downCount.js"></script>
        <script src="assets/js/scrollCue.min.js"></script>
        <script src="assets/js/fancybox.min.js"></script>
        <script src="assets/js/appear.min.js"></script>
        <script src="assets/js/odometer.min.js"></script>
        <script src="assets/js/magnific-popup.min.js"></script>
        <script src="assets/js/owl.carousel.min.js"></script>
        <script src="assets/js/parallax.min.js"></script>
        <script src="assets/js/ajaxchimp.min.js"></script>
        <script src="assets/js/form-validator.min.js"></script>
        <script src="assets/js/subscribe-custom.js"></script>
        <script src="assets/js/contact-form-script.js"></script>
        <script src="assets/js/custom.js"></script>
     
    
    <script>
    document.getElementById("Number").addEventListener("input", function () {
        let value = this.value.replace(/\D/g, '');
        if (value.length > 10) value = value.slice(0, 10);
        this.value = value;
        if (value.length === 10) {
            document.getElementById("number").innerText = "";
            this.style.borderColor = "";
        }
    });

    function valid() {
        let isValid = true;
        const username = document.getElementById("user");
        const email = document.getElementById("email");
        const phoneNumber = document.getElementById("Number");
        const emailRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/;

        if (username.value.trim() === "") {
            document.getElementById("usernameError").innerText = "Please enter your name.";
            username.style.borderColor = "red";
            isValid = false;
        } else {
            document.getElementById("usernameError").innerText = "";
            username.style.borderColor = "";
        }

        if (!emailRegex.test(email.value.trim())) {
            document.getElementById("useremail").innerText = "Valid email is required.";
            email.style.borderColor = "red";
            isValid = false;
        } else {
            document.getElementById("useremail").innerText = "";
            email.style.borderColor = "";
        }

        if (phoneNumber.value.length !== 10) {
            document.getElementById("number").innerText = "10 digits required.";
            phoneNumber.style.borderColor = "red";
            isValid = false;
        } else {
            document.getElementById("number").innerText = "";
            phoneNumber.style.borderColor = "";
        }

        return isValid;
    }
    </script>
</body>
</html>