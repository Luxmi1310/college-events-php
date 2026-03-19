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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Add Sponsor</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css"> </head>
<body>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header bg-primary text-white">
                <h3>Add New Sponsor</h3>
            </div>
            <div class="card-body">
                <form action="" method="POST" enctype="multipart/form-data">
                    
                    <div class="mb-3">
                        <label>Sponsor Name (e.g., Infosys, AutoCAD)</label>
                        <input type="text" name="name" class="form-control" required placeholder="Enter name">
                    </div>

                    <div class="mb-3">
                        <label>Sponsor Type</label>
                        <select name="sponsor_type" class="form-control">
                            <option value="normal">Normal (Grid Logo)</option>
                            <option value="paid">Paid (Top Banner)</option>
                        </select>
                        <small class="text-muted">Paid sponsors appear in the top banner section.</small>
                    </div>

                    <div class="mb-3">
                        <label>Upload Logo/Banner</label>
                        <input type="file" name="logo_image" class="form-control" required>
                    </div>

                    <div class="mb-3">
                        <label>Website URL (Optional)</label>
                        <input type="url" name="website_url" class="form-control" placeholder="https://example.com">
                    </div>

                    <button type="submit" name="submit" class="btn btn-success">Save Sponsor</button>
                    <a href="sponsors.php" class="btn btn-secondary">View Page</a>
                </form>
            </div>
        </div>
    </div>
</body>
</html>