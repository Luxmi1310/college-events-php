 <?php include_once("include/header.php"); ?>
   
<?php
require 'db_config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $email = mysqli_real_escape_string($conn, trim($_POST['email']));

    $sql = "SELECT * FROM student WHERE Email = '$email' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if (mysqli_num_rows($result) == 1) {

        $user = mysqli_fetch_assoc($result);

        if (password_verify($_POST['password'], $user['Password'])) {

            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_name'] = $user['Name'];

			$_SESSION['logged_memebers'] = array(
				'id' => $user['id'],
				'name' => $user['Name'],
				'email' => $user['Email']
			);
            header("Location: index.php");
            exit;

        } else {
            $error = "Incorrect email or password.";
        }

    } else {
        $error = "Incorrect email or password.";
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

        <div class="wrapper-full">
            <form action="" method="post"  class="my-account-content">
                <h2>Fill Up The Login Form</h2>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="form-group">
                            <input type="email" name="email" id="email" class="form-control" placeholder="Email Address" required>
                        </div>
                    </div>
                    <div class="col-lg-12">
                        <div class="form-group">
                            <input type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                        </div>
                    </div>
                    <?php if(isset($error)) : ?>
                    <div class="col-lg-12">
                        <div id="login-msg" style=" color: #ff4d4d; font-weight: bold; margin-bottom: 15px;">
							<?php echo $error; ?>
						</div>
                    </div>
					<?php endif; ?>
                    <div class="col-lg-6 col-sm-6 col-md-6">
                    </div>
                    <div class="col-lg-6 col-sm-6 col-md-6">
                        <div class="text-account text-end">
                            <p><a href="forgot-password.php">Forgot Password?</a> </p>
                        </div>
                    </div>
					<br>
                     <br>
                    <div class="col-lg-12">
                        <button type="submit" class="default-btn btn-style-fore">Login</button>
                    </div>
                </div>
                <p>Don’t Have an Account? <a href="signup.php">Create One</a></p>
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

</body>
</html>