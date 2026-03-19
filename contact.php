<?php include_once("include/header.php"); ?>
<?php 
require 'db_config.php';

$message_sent = false;

// 1. Move logic to the absolute top of the file
if (isset($_POST['submit_contact'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $subject = mysqli_real_escape_string($conn, $_POST['subject']);
    $msg = mysqli_real_escape_string($conn, $_POST['message']);

    $full_message = "Subject: $subject | Message: $msg";

    $sql = "INSERT INTO contact (name, email, message) VALUES ('$name', '$email', '$full_message')";

    if (mysqli_query($conn, $sql)) {
        $message_sent = true;
    }
}
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
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
	
    <style>
        .timer-box { font-size: 0.8rem; font-weight: bold; color: #ff4d4d; margin-bottom: 5px; }
        .countdown li span { font-size: 14px; line-height: 1; }
        .btn-disabled { background-color: #6c757d !important; border-color: #6c757d !important; cursor: not-allowed; opacity: 0.65; }
    </style>
</head>
<body>
    <?php include_once("include/navbar.php"); ?>
        <!-- End Menubar Area -->
                                    <img src="admin/uploads/contact.webp" alt="images" style="width:100%; height:600px;">

        <!-- Start Page Banner Area -->
            
           <?php if ($message_sent): ?>
    <script>
        Swal.fire({
            title: 'Success!',
            text: 'Your Query is Succesfully sent.',
            icon: 'success',
            confirmButtonText: 'OK'
        });
    </script>
    <?php endif; ?> 
        <!-- End Page Banner Area -->

        <!-- Start Contact Us Area -->
        <div class="contact-area pt-100 pb-100">
            <div class="container">
                <div class="row">
                    <div class="col-lg-8" data-cue="slideInRight" data-duration="1500">
                        <div class="contact-form-content">
                            <div class="section-title left-title">
                                <span class="top-title">Get In Touch</span>
                                <h2>Feel Free To Contact And Reach Us !</h2>
								<p>For any queries regarding the event, feel free to reach out to us.
								</p>
                            </div>
                            	<form id="directContactForm" method="POST" action=""> 
                    <div class="row">
                        <div class="col-lg-6">
                            <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                        </div>
                        <div class="col-lg-6">
                            <input type="email" name="email" placeholder="Your Email" required class="form-control">
                        </div>
                        <div class="col-lg-12 mt-3">
                            <input type="text" name="subject" class="form-control" placeholder="Subject" required>
                        </div>
						<div class="col-lg-12 mt-3">
                            <textarea name="message" class="form-control" rows="5" placeholder="Message" required></textarea>
                        </div>
                        <div class="col-lg-12 mt-3">
                            <button type="submit" name="submit_contact" class="default-btn">
                                Send Message <i class="bx bx-plus"></i>
                            </button>
                        </div>
                    </div>
                </form>
                        </div>
                    </div>
                    <div class="col-lg-4" data-cue="slideInRight" data-duration="1500">
    <div class="single-contact-card">
        
        <div class="contact-box" style="display: flex; flex-direction: column; align-items: center; text-align: center; justify-content: center; gap: 5px;">
            <i class='bx bxs-map' style="color: #ffc107; font-size: 36px; line-height: 1; display: inline-flex; align-items: center;"></i>
            <h3>Address</h3>
            <p style="margin: 0; padding: 0; line-height: 1.5;">Kidwai Nagar, Suffian Chowk,<br>Ludhiana, Punjab</p>
        </div>

        <div class="contact-box" style="display: flex; flex-direction: column; align-items: center; text-align: center; justify-content: center; gap: 5px;">
            <i class='bx bxs-phone-call' style="color: #ffc107; font-size: 36px; line-height: 1; display: inline-flex; align-items: center;"></i>
            <h3>Phone</h3>
            <ul style="list-style: none; padding: 0; margin: 0; line-height: 1.5;">
                <li><a href="tel:+917973642515" style="color: inherit;">0161-2224682</a></li>
                <li><a href="tel:01612345678" style="color: inherit;">0161-5017716</a></li>
            </ul>
        </div>

        <div class="contact-box" style="display: flex; flex-direction: column; align-items: center; text-align: center; justify-content: center; gap: 5px;">
            <i class='bx bxs-envelope' style="color: #ffc107; font-size: 36px; line-height: 1; display: inline-flex; align-items: center;"></i>
            <h3>Email Us Directly</h3>
            <ul style="list-style: none; padding: 0; margin: 0; line-height: 1.5;">
                <li><a href="mailto:ddjainldh@rediffmail.com" style="color: inherit;">ddjainldh@rediffmail.com</a></li>
                <li><a href="mailto:ddjaincollege.org" style="color: inherit;"> ddjaincollege.org </a></li>
            </ul>
        </div>

        
    </div>
</div>
					
					
					
                </div>
            </div>
        </div>
        <!-- End Contact Us Area -->

        <!-- Start Contact Map area -->
		<div class="contact-map-area pb-100">
    <div class="container-fluid">
        <div class="contact-map">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3423.3566760575436!2d75.86436877558714!3d30.904652974501698!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x391a83106eab5d65%3A0x3fa15bb757bd15d!2sDevki%20Devi%20Jain%20Memorial%20College%20for%20Women!5e0!3m2!1sen!2sin!4v1773312976445!5m2!1sen!2sin" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade" 
                width="100%" 
                height="450" 
                style="border:0; border-radius: 15px;" 
                allowfullscreen="" 
                loading="lazy" 
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>
</div>
        <!-- End Contact Map area -->

        <!-- Start Footer Area -->
			<?php include_once("include/footer.php");  ?>
        
        <!-- End Footer Area --> 

        <!-- Start Go Top Area -->
        <div class="go-top">
            <i class="flaticon-up-arrows"></i>
            <i class="flaticon-up-arrows"></i>
        </div>
        <!-- End Go Top Area -->


        <!--=== Link Of JS Files ===-->
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

    <script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"version":"2024.11.0","token":"5fe684bbe2954c839d4575e6915100ba","r":1,"server_timing":{"name":{"cfCacheStatus":true,"cfEdge":true,"cfExtPri":true,"cfL4":true,"cfOrigin":true,"cfSpeedBrain":true},"location_startswith":null}}' crossorigin="anonymous"></script>
</body>

<!-- Mirrored from templates.hibotheme.com/nestu/default/contact.html by HTTrack Website Copier/3.x [XR&CO'2014], Mon, 19 Jan 2026 09:56:49 GMT -->
</html>