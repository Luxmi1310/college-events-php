<?php
require 'db_config.php';

if(isset($_POST['submit'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $sponsor_type = $_POST['sponsor_type'];
    $website_url = mysqli_real_escape_string($conn, $_POST['website_url']);

    $target_dir = "assets/images/sponsor/";
    if (!file_exists($target_dir)) {
        mkdir($target_dir, 0777, true);
    }

    // Handle Logo Upload (Required for all)
    $logo_name = time() . "_logo_" . basename($_FILES["logo_image"]["name"]);
    move_uploaded_file($_FILES["logo_image"]["tmp_name"], $target_dir . $logo_name);

    // Handle Banner Upload (Required for Paid)
    $banner_name = "";
    if ($sponsor_type == 'paid' && !empty($_FILES["banner_image"]["name"])) {
        $banner_name = time() . "_banner_" . basename($_FILES["banner_image"]["name"]);
        move_uploaded_file($_FILES["banner_image"]["tmp_name"], $target_dir . $banner_name);
    }

    $sql = "INSERT INTO sponsors (name, logo_image, banner_image, sponsor_type, website_url) 
            VALUES ('$name', '$logo_name', '$banner_name', '$sponsor_type', '$website_url')";
    
    if(mysqli_query($conn, $sql)) {
        echo "<script>alert('Sponsor Added Successfully!'); window.location.href='add_sponsor.php';</script>";
    } else {
        echo "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Add Sponsor</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    
    <style>
        body {
            background-color: #f4f7f6;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            margin: 0;
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        
        /* This handles the layout between sidebar and content */
        .admin-wrapper {
            display: flex;
            flex: 1;
        }

        .main-content {
            flex: 1;
            padding: 40px 20px;
            /* Adjust 250px to match your actual sidebar width */
            margin-left: 250px; 
            transition: 0.3s;
        }

        .container-form {
            max-width: 700px;
            margin: 0 auto;
        }

        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
        }

        .card-header {
            background: linear-gradient(45deg, #007bff, #0056b3) !important;
            border-radius: 15px 15px 0 0 !important;
            padding: 20px;
            text-align: center;
        }

        .form-control, .form-select {
            border-radius: 8px;
            padding: 12px;
            border: 1px solid #ddd;
        }

        .btn-success {
            padding: 12px 25px;
            border-radius: 8px;
            font-weight: 600;
            width: 100%;
            margin-top: 10px;
        }

        /* Footer Adjustment */
        footer {
            margin-left: 250px;
            background: #fff;
            padding: 15px;
            text-align: center;
            border-top: 1px solid #ddd;
        }

        /* Responsive: If screen is small, remove margin */
        @media (max-width: 768px) {
            .main-content, footer {
                margin-left: 0;
            }
        }
    </style>
</head>
<body>

    <div class="admin-wrapper">
        <?php include_once("leftbar.php"); ?>

        <div class="main-content">
            <div class="container-form">
                <div class="card">
                    <div class="card-header text-white">
                        <h3>Add New Sponsor</h3>
                    </div>
                    <div class="card-body">
                        <form action="" method="POST" enctype="multipart/form-data">
    <div class="mb-3">
        <label class="form-label">Sponsor Name</label>
        <input type="text" name="name" class="form-control" required placeholder="e.g. Infosys">
    </div>

    <div class="mb-3">
        <label class="form-label">Sponsor Type</label>
        <select name="sponsor_type" id="sponsorType" class="form-select" onchange="toggleBannerField()">
            <option value="normal">Normal (Grid Logo)</option>
            <option value="paid">Paid (Top Banner)</option>
        </select>
    </div>

    <div class="mb-3">
        <label class="form-label">Upload Small Logo (For Grid)</label>
        <input type="file" name="logo_image" class="form-control" required>
    </div>

    <div class="mb-3" id="bannerField" style="display: none;">
        <label class="form-label text-primary fw-bold">Upload Wide Banner (For Top Carousel)</label>
        <input type="file" name="banner_image" class="form-control">
        <div class="form-text">Recommended size: 1920x600px</div>
    </div>

    <div class="mb-3">
        <label class="form-label">Website URL (Optional)</label>
        <input type="url" name="website_url" class="form-control" placeholder="https://example.com">
    </div>

    <button type="submit" name="submit" class="btn btn-success">Save Sponsor</button>
</form>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <?php include_once("footer.php"); ?>

</body>
</html>
<script>
function toggleBannerField() {
    var type = document.getElementById("sponsorType").value;
    var bannerField = document.getElementById("bannerField");
    if (type === "paid") {
        bannerField.style.display = "block";
    } else {
        bannerField.style.display = "none";
    }
}
</script>