    <?php include_once("include/header.php"); ?>

<?php 
require 'db_config.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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
    <title>Nestu - Event Conference & Reunion</title>
    <link rel="icon" type="image/png" href="assets/images/favicon.png">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Nestu - Dynamic Sponsors</title>
    <style>
        /* Ensures the carousel images look good in the banner */
        .banner-carousel-img {
            max-height: 120px;
            width: auto !important;
            margin: 20px auto;
            display: block;
        }
        .single-page-banner-content h1 {
            margin-bottom: 10px;
        }
    /* Force the carousel to be full width and remove any default padding */
    .premium-sponsor-carousel .item {
        width: 100vw;
    }
    .page-banner-area {
        overflow: hidden;
    }
	/* Highlighted border for sponsor logos */
.sponsor-logo-card {
    background:#fff ;
    border: 1px solid rgba(0, 0, 0, 0.05); /* Very light border */
    border-radius: 12px; /* Rounded corners */
    padding: 20px;
    margin-bottom: 30px;
    transition: all 0.3s ease-in-out;
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05); /* Subtle shadow */
    display: flex;
    align-items: center;
    justify-content: center;
    height: 150px; /* Ensures all boxes are uniform */
}

/* Hover effect for a "beautifully highlighted" look */
.sponsor-logo-card:hover {
    transform: translateY(-5px);
    border-color: #007bff; /* Change this to your primary theme color */
    box-shadow: 0 10px 25px rgba(0, 123, 255, 0.2); /* Soft blue glow */
}

.sponsor-logo-card img {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain;
    filter: grayscale(20%); /* Optional: slightly desaturate */
    transition: filter 0.3s ease;
}

.sponsor-logo-card:hover img {
    filter: grayscale(0%); /* Full color on hover */
}
    </style>
</head>
<body>
    <?php include_once("include/navbar.php"); ?>
<div class="page-banner-area p-0"> 
    <div class="owl-carousel owl-theme premium-sponsor-carousel">
        <?php
        // Fetch PAID sponsors
        $banner_query = mysqli_query($conn, "SELECT * FROM sponsors WHERE sponsor_type = 'paid' ORDER BY id DESC");
        if(mysqli_num_rows($banner_query) > 0) {
            while($banner = mysqli_fetch_assoc($banner_query)) {
        ?>
            <div class="item" style="background-image: url('assets/uploads/<?php echo $banner['banner_image']; ?>'); ...">
                
                <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.4);"></div>
                
                <div class="container" style="position: relative; z-index: 2; height: 100%;">
                    <div class="single-page-banner-content d-flex flex-column align-items-center justify-content-center" style="height: 100%;">
                        
                        
                    </div>
                </div>
            </div>
        <?php 
            }
        } 
        ?>
    </div>
</div>



    <div class="sponsor-pages-area pt-100 pb-100">
        <div class="container">
            <div class="section-title">
                <span class="top-title">Best Sponsor</span>
                <h2>Our Best Promoter And Global Sponsor</h2>
				<br>
				
            </div>
            
            <div class="row align-items-center justify-content-center"> 
    <?php 
    $all_sponsors = mysqli_query($conn, "SELECT * FROM sponsors ORDER BY id DESC");
    while($row = mysqli_fetch_assoc($all_sponsors)) { 
    ?>
        <div class="col-lg-3 col-6 col-sm-4 col-md-4">
            <div class="sponsor-logo-card">
                <img src="assets/uploads/<?php echo $row['logo_image']; ?>" alt="Sponsor Logo">
            </div>
        </div>
    <?php } ?>
</div>
        </div>
    </div> 

    <?php include_once("include/footer.php"); ?>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script> 
    <script src="assets/js/owl.carousel.min.js"></script>
    <script src="assets/js/custom.js"></script>

    

<script>
    $(document).ready(function(){
        $(".premium-sponsor-carousel").owlCarousel({
            items: 1,            // This ensures only 1 image shows at a time
            loop: true,          // Infinite loop
            margin: 0,           // No space between slides
            nav: true,           // Show arrows
            dots: true,          // Show dots
            autoplay: true,      // Auto slide
            autoplayTimeout: 5000, 
            smartSpeed: 1000,
            animateOut: 'fadeOut', // Smooth fading effect
            animateIn: 'fadeIn',
            responsive: {
                0: { items: 1 },
                600: { items: 1 },
                1000: { items: 1 }
            }
        });
    });
</script>
</body>
</html>