<?php
// save_sponsor.php
require 'db_config.php';

if(isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $sponsor_type = $_POST['sponsor_type'];
    $website_url = mysqli_real_escape_string($conn, $_POST['website_url']);

    // Image Upload Logic
    $target_dir = "assets/images/sponsor/";
    
    // Create folder if it doesn't exist
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    $file_name = time() . "_" . basename($_FILES["logo_image"]["name"]);
    $target_file = $target_dir . $file_name;

    if (move_uploaded_file($_FILES["logo_image"]["tmp_name"], $target_file)) {
        // Insert into Database
        $sql = "INSERT INTO sponsors (name, logo_image, sponsor_type, website_url) 
                VALUES ('$name', '$file_name', '$sponsor_type', '$website_url')";
        
        if(mysqli_query($conn, $sql)) {
            echo "<script>alert('Sponsor Added Successfully!'); window.location.href='add_sponsor.php';</script>";
        } else {
            echo "Error: " . mysqli_error($conn);
        }
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
?>