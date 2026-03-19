<?php 
// 1. START SESSION IMMEDIATELY (Must be before ANY logic or HTML)
if (session_status() === PHP_SESSION_NONE) {
include_once("include/header.php"); 
	
}

// 2. THE GATEKEEPER: Check if OTP was verified
// We do this BEFORE including header.php to prevent "Headers already sent" errors
if (!isset($_SESSION['otp_verified']) || $_SESSION['otp_verified'] !== true) {
    header("Location: signup.php");
    exit();
}

// 3. Include required files (Now that we know the user is allowed here)
require 'db_config.php';

$error = "";
$success = "";

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    
    // 4. Validate that the email exists in the session
    if (!isset($_SESSION['temp_user']['email'])) {
        $error = "User session lost. Please restart the signup process.";
    } else {
        $email = $_SESSION['temp_user']['email'];
        $password = $_POST['password'];

        // Secure password hashing
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $currentDate = date('Y-m-d H:i:s');

        // 5. Update password using Prepared Statement
        $stmt = $conn->prepare("UPDATE student SET password = ?, Add_dated = ? WHERE Email = ?");
        $stmt->bind_param("sss", $hashedPassword, $currentDate, $email);

        if ($stmt->execute()) {
            // 6. Fetch the complete user data to log them in automatically
            $sqlid = "SELECT * FROM student WHERE Email = ?";
            $stmt_fetch = $conn->prepare($sqlid);
            $stmt_fetch->bind_param("s", $email);
            $stmt_fetch->execute();
            $result = $stmt_fetch->get_result();
            $user = $result->fetch_assoc();

            // 7. Setup the Login Sessions
            $_SESSION['student_id'] = $user['id']; 
            $_SESSION['logged_memebers'] = $user;

            // 8. Clear temporary security keys
            unset($_SESSION['otp_verified']);
            unset($_SESSION['temp_user']);
            unset($_SESSION['temp_user_email']);
            unset($_SESSION['otp']);

            // Redirect to index
            header("Location: index.php?msg=signup_success");
            exit();
        } else {
            $error = "Something went wrong during the update. Please try again.";
        }
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
<body>
    
    <?php include_once("include/navbar.php"); ?>
    
    <div class="col-md-6 mx-auto mt-5">
        <div class="section-title">
            <h2>Login to Your Account</h2>
        </div>
		
		<?php
if (isset($_SESSION['success_msg'])) {
    echo "<div class='alert alert-success'>" . $_SESSION['success_msg'] . "</div>";
    unset($_SESSION['success_msg']);
}
?>

	<?php if(isset($success)): ?>
        <p style="color:green"><?= $success ?></p>
    <?php endif; ?>

    <?php if(isset($error)): ?>
        <p style="color:red"><?= $error ?></p>
    <?php endif; ?>

        <div class="wrapper-full">
            <form method="POST" action="" class="p-4 shadow rounded bg-white">

    <h3 class="mb-3 text-center">Create Your Password</h3>
    <p class="text-muted text-center mb-4">
        Secure your account by creating a strong password
    </p>

    <!-- Password -->
    <div class="mb-3">
        <label class="form-label">Password</label>
        <div class="input-group">
            <input type="password" name="password" id="password"
                   class="form-control"
                   placeholder="Enter password"
                   required minlength="6">
            <span class="input-group-text" onclick="togglePassword()" style="cursor:pointer">
                <i class="bx bx-show"></i>
            </span>
        </div>
        <small class="text-muted">Minimum 6 characters</small>
    </div>

    <!-- Confirm Password -->
    <div class="mb-3">
        <label class="form-label">Confirm Password</label>
        <input type="password" id="confirm_password"
               class="form-control"
               placeholder="Re-enter password"
               required>
        <small id="matchMsg"></small>
    </div>

    <button type="submit" class="btn btn-primary w-100">
        Create Password
    </button>

</form>


        </div>
        <br><br><br><br>
    </div>

    <?php include_once("include/footer.php"); ?>

    <div class="go-top">
        <i class="flaticon-up-arrows"></i>
        <i class="flaticon-up-arrows"></i>
    </div>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/meanmenu.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script> 
    <script src="assets/js/custom.js"></script>
	<script>
function togglePassword() {
    let pwd = document.getElementById("password");
    pwd.type = pwd.type === "password" ? "text" : "password";
}

document.getElementById("confirm_password").addEventListener("input", function () {
    let pwd = document.getElementById("password").value;
    let confirmPwd = this.value;
    let msg = document.getElementById("matchMsg");

    if (pwd !== confirmPwd) {
        msg.textContent = "Passwords do not match";
        msg.style.color = "red";
    } else {
        msg.textContent = "Passwords match";
        msg.style.color = "green";
    }
});
</script>
<script>
document.querySelector('form').onsubmit = function(e) {
    let pwd = document.getElementById("password").value;
    let confirmPwd = document.getElementById("confirm_password").value;
    
    if (pwd !== confirmPwd) {
        alert("Passwords do not match!");
        e.preventDefault(); // Stop the form from submitting
        return false;
    }
};
</script>
</body>
</html>
