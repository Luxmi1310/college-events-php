<?php
require 'db_config.php';

// Check for name to ensure it's a valid submission
if (isset($_POST['name'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $msg = mysqli_real_escape_string($conn, $_POST['message']);

    $full_message = "Subject: $subject | Message: $msg";

    $sql = "INSERT INTO contact (name, email, message) VALUES ('$name', '$email', '$full_message')";

    if (mysqli_query($conn, $sql)) {
        // The AJAX script looks for the word "success"
        echo "success";
    } else {
        echo "Error inserting data.";
    }
} else {
    echo "invalid";
}
?>