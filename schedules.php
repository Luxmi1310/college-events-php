<?php include_once("include/header.php"); ?>

<?php
include 'db_config.php';
date_default_timezone_set('Asia/Kolkata');
$current_time = date('Y-m-d H:i:s');

// 1. Query for Upcoming Events Only
$upcoming_sql = "SELECT * FROM create_events WHERE end_date > '$current_time' ORDER BY start_date ASC";
$upcoming_result = mysqli_query($conn, $upcoming_sql);

// 2. Query for Archive Only (Past events)
$all_sql = "SELECT * FROM create_events WHERE end_date <= '$current_time' ORDER BY end_date DESC";
$all_result = mysqli_query($conn, $all_sql);
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
    <style>
        .timer-box { font-size: 0.8rem; font-weight: bold; margin-bottom: 5px; }
        .text-starts { color: #ff4d4d; } /* Red for starting soon */
        .text-ends { color: #ffc107; }   /* Yellow for ending soon */
        .btn-disabled { background-color: #6c757d !important; border-color: #6c757d !important; cursor: not-allowed; opacity: 0.65; }
        .section-separator { border-bottom: 2px dashed #eee; margin: 50px 0; }
    </style>
</head>
<body>
    <?php include_once("include/navbar.php"); ?>

    <?php 
    $banner_sql = "SELECT event_image, event_type FROM create_events WHERE end_date > '$current_time' ORDER BY start_date ASC LIMIT 3";
    $banner_result = mysqli_query($conn, $banner_sql);
    ?>
    <div class="hero-area">
        <div class="hero-auto-slider owl-carousel owl-theme">
            <?php if ($banner_result && mysqli_num_rows($banner_result) > 0): 
                while($banner = mysqli_fetch_assoc($banner_result)): ?>
                <div class="hero-slider-item" style="background-image: url('admin/uploads/<?= htmlspecialchars($banner['event_image']) ?>'); background-size: cover; background-position: center; height: 100vh; position: relative;">
                    <div style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5);"></div>
                    <div class="container" style="position: relative; z-index: 2; height: 100%;">
                        <div class="d-flex align-items-center" style="height: 100%;">
                            <div class="hero-content text-white">
                                <h1 class="display-3 fw-bold" data-cue="slideInLeft"><?= htmlspecialchars($banner['event_type']) ?></h1>
                                <p class="lead" data-cue="slideInLeft">Don't miss out on our upcoming events. Join us for an unforgettable experience!</p>
                                <div class="hero-bottom" data-cue="slideInLeft">
                                    <a href="login.php" class="default-btn btn-primary">Register Now <i class='bx bx-plus'></i></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endwhile; else: ?>
                <div class="hero-slider-item" style="background: #333; height: 600px;">
                    <div class="container h-100 d-flex align-items-center"><h1 class="text-white">Welcome to Nestu</h1></div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <div class="pt-100 pb-70">
        <div class="container">
            <div class="section-title text-center mb-5">
                <span class="top-title">Live Now</span>
                <h2>🚀 Upcoming Events</h2>
            </div>
            <div class="row g-4">
                <?php 
                if (mysqli_num_rows($upcoming_result) > 0) {
                    while($row = mysqli_fetch_array($upcoming_result)) { renderEventCard($row, $conn); }
                } else {
                    echo "<div class='col-12 text-center'><p class='text-muted'>No upcoming events at the moment.</p></div>";
                }
                ?>
            </div>
        </div>
    </div>

    <div class="container"><div class="section-separator"></div></div>

    <div class="pb-70">
        <div class="container">
            <div class="section-title text-center mb-5">
                <span class="top-title">History</span>
                <h2>All Events Archive</h2>
            </div>
            <div class="row g-4">
                <?php 
                if (mysqli_num_rows($all_result) > 0) {
                    while($row = mysqli_fetch_array($all_result)) { renderEventCard($row, $conn, true); }
                } else {
                    echo "<div class='col-12 text-center'><p class='text-muted'>No past events in archive.</p></div>";
                }
                ?>
            </div>
        </div>
    </div>

    <?php
    function renderEventCard($row, $conn, $isArchive = false) {
        $reg_sql = "SELECT id FROM event_register WHERE event_id='".$row['id']."'";
        $reg_query = mysqli_query($conn, $reg_sql);
        $current_count = mysqli_num_rows($reg_query);
        
        $now = time(); 
        $eventStart = strtotime($row['start_date']); 
        $eventEnd   = strtotime($row['end_date']);
        $regDead    = strtotime($row['registration_deadline']);   
        $capacity   = (int)$row['capacity'];

        // Same Logic for "Registration End" countdown
        $is_urgent_deadline = ($row['start_date'] == $row['registration_deadline']);

        $url = !isset($_SESSION['logged_memebers']) ? "login.php" : "event_register.php?eid=" . $row['id'];
        ?>
        <div class="col-lg-4 col-md-6 mb-4">
            <div class="event-grid-card bg-white d-flex flex-column h-100 shadow-sm border">
                <img src="admin/uploads/<?= htmlspecialchars($row['event_image']) ?>" class="w-100" style="height:160px; object-fit:cover;">
                <div class="p-3 d-flex flex-column flex-grow-1">
                    <h6 class="fw-bold mb-1"><?= htmlspecialchars($row['event_type']) ?></h6>
                    <small class="text-muted mb-2"><i class="bi bi-geo-alt"></i> <?= htmlspecialchars($row['vanue']) ?></small>
                    
                    <div class="bg-light p-2 rounded mb-3" style="font-size: 0.75rem;">
                        <i class="bi bi-calendar-event"></i> Date: <?= date('M j, Y g:i A', $eventStart) ?>
                    </div>

                    <div class="mt-auto">
                        <?php if ($now < $regDead): ?>
                            <div class="timer-box mb-2 text-center text-starts">
                                <small class="d-block text-muted">Starts in:</small>
                                <span class="countdown" data-time="<?= $row['registration_deadline'] ?>"></span>
                            </div>
                            <button class="btn btn-secondary btn-sm w-100" disabled>Join Soon</button>

                        <?php elseif ($now >= $regDead && $now < $eventStart && $is_urgent_deadline): ?>
                            <div class="timer-box mb-2 text-center text-ends">
                                <small class="d-block text-muted">Ends in:</small>
                                <span class="countdown" data-time="<?= $row['start_date'] ?>"></span>
                            </div>
                            <a href="<?= $url ?>" class="btn btn-primary btn-sm w-100">Join Now</a>

                        <?php elseif ($current_count >= $capacity && $now < $eventEnd): ?>
                            <button class="btn btn-warning btn-sm w-100" disabled>House Full</button>

                        <?php elseif ($now >= $eventStart && $now <= $eventEnd): ?>
                            <button class="btn btn-info btn-sm w-100 text-white" disabled>Ongoing</button>

                        <?php elseif ($now > $eventEnd): ?>
                            <button class="btn btn-dark btn-sm w-100" disabled>Finished</button>

                        <?php else: ?>
                            <a href="<?= $url ?>" class="btn btn-primary btn-sm w-100">Join Now</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php
    }
    ?>

    <?php include_once("include/footer.php"); ?>

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
        function updateCountdowns() {
            document.querySelectorAll('.countdown').forEach(timer => {
                const targetStr = timer.getAttribute('data-time');
                if(!targetStr) return;
                const target = new Date(targetStr.replace(/-/g, "/")).getTime(); // Cross-browser date fix
                const now = new Date().getTime();
                const gap = target - now;

                if (gap <= 0) {
                    timer.innerHTML = "00d 00h 00m 00s";
                    // Optional: location.reload(); to flip the button automatically
                    return;
                }

                const d = Math.floor(gap / (1000 * 60 * 60 * 24));
                const h = Math.floor((gap % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const m = Math.floor((gap % (1000 * 60 * 60)) / (1000 * 60));
                const s = Math.floor((gap % (1000 * 60)) / 1000);
                
                timer.innerHTML = `${d}d ${h}h ${m}m ${s}s`;
            });
        }
        setInterval(updateCountdowns, 1000);
        updateCountdowns();

        $(document).ready(function() {
            const urlParams = new URLSearchParams(window.location.search);
            const myMsg = urlParams.get('msg');
            if (myMsg) {
                let title = '', text = '', icon = 'success';
                if (myMsg === 'signup_success') { title = 'Welcome!'; text = 'Registration successful!'; } 
                else if (myMsg === 'thankyou') { title = 'Seat Reserved!'; text = 'Thank you for joining!'; }
                else if (myMsg === 'already_reg') { title = 'Note'; text = 'Already registered.'; icon = 'info'; }

                if (title !== '') {
                    Swal.fire({ title: title, text: text, icon: icon, confirmButtonColor: '#3085d6' }).then(() => {
                        window.history.replaceState({}, document.title, window.location.pathname);
                    });
                }
            }
        });
    </script>
</body>
</html>