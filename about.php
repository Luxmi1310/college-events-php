<?php include_once("include/header.php"); ?>
<?php
include 'db_config.php';
date_default_timezone_set('Asia/Kolkata');
$current_time = date('Y-m-d H:i:s');

// Fetch nearest event
$timer_sql = "SELECT id, registration_deadline FROM create_events WHERE registration_deadline > '$current_time' ORDER BY registration_deadline ASC LIMIT 1";
$timer_result = mysqli_query($conn, $timer_sql);
$timer_row = mysqli_fetch_assoc($timer_result);

if ($timer_row) {
    // Format MUST be Month/Day/Year for downCount.js to be stable
    $countdown_date = date('m/d/Y H:i:s', strtotime($timer_row['registration_deadline']));
    $register_url = "event_register.php?eid=" . $timer_row['id'];
} else {
    $countdown_date = "12/31/2026 23:59:59"; // Fallback
    $register_url = "login.php";
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
    <title>About Us - Nestu</title>
</head>
<body>
    <?php include_once("include/navbar.php"); ?>
                                    <img src="admin/uploads/staff.jpg" alt="images" style="width:100%; height:600px;">
            
		 <div class="why-the-conference-area pt-100">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
                        <div class="why-the-conference-image about-page-conference">
                            <img src="admin/uploads/clg.jpg" alt="images" style="width:450px; height:350px;"data-cue="slideInDown">
                        </div>
                    </div>
                    <div class="col-lg-6" data-cue="slideInRight">
                        <div class="why-the-conference-content about-conference-content">
                            <div class="section-title left-title">
                                <h4>Devki Devi Jain Memorial Collage For Women</h4>
                            </div>
                            <ul>
                                <li>
                                   <img src="assets/images/conference/why-the-conference-icon.svg" alt="images"> It offers a supportive and inclusive learning environment for students.

                                </li>
                                <li>
                                    <img src="assets/images/conference/why-the-conference-icon.svg" alt="images"> Academic programs are designed to promote critical thinking and professional skills..
                                </li>
                                <li>
                                    <img src="assets/images/conference/why-the-conference-icon.svg" alt="images"> The institution encourages leadership, creativity, and social responsibility.
                                </li>
                                <li>
                                    <img src="assets/images/conference/why-the-conference-icon.svg" alt="images">Experienced faculty and modern facilities support holistic development .
                                </li>
                                <li>
                                    <img src="assets/images/conference/why-the-conference-icon.svg" alt="images">The college aims to empower women to become confident and capable leaders of society .
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
		<div class="team-area pt-100 pb-70">
            <div class="container">
                <div class="section-title">
                    <h2>Experience With The Knowledge Of Our Staff Members</h2>
                </div>
                <div class="row">
                    <div class="col-lg-3 col-sm-6 col-md-6" data-cue="slideInLeft">
                        <div class="team-card">
                            <div class="team-images">
                                    <img src="admin/uploads/pr1.jpeg" alt="images" style="width:298px; height:290px;">
                            </div>
                            
                            <h3>Dr.Sarita Behl</h3>
                            <p>Prinicipal</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-md-6" data-cue="slideInDown">
                        <div class="team-card">
                            <div class="team-images">
                                    <img src="admin/uploads/president.jpeg" alt="images" style="width:298px; height:290px;">
                            </div>
                            
                            <h3>Sh.Nand Kumar Jain</h3>
                            <p>President</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-md-6" data-cue="slideInUp">
                        <div class="team-card">
                            <div class="team-images">
                                    <img src="assets/images/team/team-3.jpg" alt="images">
                            </div>
                            
                            <h3>Hitseh Ahuja</h3>
                            <p>IT Department Head</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-sm-6 col-md-6" data-cue="slideInRight">
                        <div class="team-card">
                            <div class="team-images">
                                    <img src="admin/uploads/lect.jpeg" alt="images" style="width:298px; height:290px;">
                            </div>
                            <h3>Manpreet Kaur</h3>
                            <p>Lecturer</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
    <div class="upcoming-area pt-100 pb-100 jarallax" data-jarallax='{"speed": 0.3}'>
        <div class="container">
            <div class="section-title">
                <h2>Counting Time & Not Yet Registered? Hurry Up!</h2>
            </div>
            <div class="upcoming-list">
                <ul class="live-auctions-countdown countdown flex-wrap d-flex justify-content-center" data-date="<?= $countdown_date ?>">
                    <li class="align-items-center flex-column d-flex justify-content-center" data-cue="slideInRight">
                        <span class="days">00</span>
                        Days
                    </li>
                    <li class="align-items-center bgs-border-10 flex-column d-flex justify-content-center" data-cue="slideInRight">
                        <span class="hours">00</span>
                        Hours
                    </li>
                    <li class="align-items-center flex-column d-flex justify-content-center" data-cue="slideInRight">
                        <span class="minutes">00</span>
                        Minutes
                    </li>
                    <li class="align-items-center bgs-border-10 flex-column d-flex justify-content-center" data-cue="slideInRight">
                        <span class="seconds">00</span>
                        Seconds
                    </li>
                </ul>
                <div class="upcoming-btn">
                    <a href="<?= $register_url ?>" class="default-btn">Register Now <i class='bx bx-plus' ></i></a>
                </div>
            </div>
        </div>
        <div class="upcoming-shape-1">
            <img src="assets/images/upcoming-shape-1.png" alt="images">
        </div>
        <div class="upcoming-shape-2">
            <img src="assets/images/upcoming-shape-2.png" alt="images">
        </div>
    </div>
    <?php include_once("include/footer.php");?>

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
    <script>
        $(document).ready(function() {
            // Check if the downCount plugin exists and initialize
            if ($('.countdown').length > 0) {
                $('.countdown').each(function() {
                    var $this = $(this);
                    var finalDate = $this.data('date');
                    $this.downCount({
                        date: finalDate,
                        offset: +5.5 // Indian Standard Time Offset
                    }, function () {
                        // Action when countdown reaches zero
                        $('.upcoming-btn a').text('Event Started').addClass('disabled');
                    });
                });
            }
        });
    </script>
</body>
</html>