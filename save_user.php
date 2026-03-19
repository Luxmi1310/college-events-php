<?php
session_start();
require 'db_config.php';

if (!isset($_SESSION['temp_user'], $_SESSION['otp_verified'])) {
    header("Location: signup.php");
    exit();
}

if ($_POST['password'] !== $_POST['confirm']) {
    die("Passwords do not match");
}

$name  = mysqli_real_escape_string($conn, $_SESSION['temp_user']['fullname']);
$email = mysqli_real_escape_string($conn, $_SESSION['temp_user']['email']);
$phone = mysqli_real_escape_string($conn, $_SESSION['temp_user']['phone']);

$pass = md5($_POST['password']); // replace with password_hash later

$sql = "INSERT INTO student (Name, Email, Phone, Password)
        VALUES ('$name','$email','$phone','$pass')";

if (mysqli_query($conn, $sql)) {
	
	//print_r($_SESSION);
    session_destroy();
    echo "Account created successfully";
} else {
    echo mysqli_error($conn);
}
?>