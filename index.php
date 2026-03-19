<?php include_once("include/header.php"); ?>

<?php
include 'db_config.php';
date_default_timezone_set('Asia/Kolkata');
$current_time = date('Y-m-d H:i:s');
$now_ts = time();

/**
 * Renders an event card for the GRID view (Upcoming Events)
 */
function renderEventCard($row, $conn) {
    $current_timestamp = time(); 
    $eventStart = strtotime($row['start_date']);
    $eventEnd = strtotime($row['end_date']);
    $regDeadline = strtotime($row['registration_deadline']); 
    
    $reg_sql = "SELECT id FROM event_register WHERE event_id='".$row['id']."'";
    $reg_query = mysqli_query($conn, $reg_sql);
    $current_count = mysqli_num_rows($reg_query);

    // Default Status
    $status_type = "open"; 
    
    if ($current_count >= $row['capacity']) { 
        $status_type = "full"; 
    } elseif ($current_timestamp < $regDeadline) {
        $status_type = "waiting"; 
    } elseif ($current_timestamp > $eventStart) { 
        $status_type = "closed"; 
    }

    $url = (!isset($_SESSION['logged_memebers'])) ? "login.php" : "event_register.php?eid=" . $row['id'];
    ?>
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="event-grid-card bg-white d-flex flex-column h-100 shadow-sm border">
            <img src="admin/uploads/<?= htmlspecialchars($row['event_image']) ?>" class="w-100" style="height:160px; object-fit:cover;">
            <div class="p-3 d-flex flex-column flex-grow-1">
                <h6 class="fw-bold mb-1"><?= htmlspecialchars($row['event_type']) ?></h6>
                <small class="text-muted mb-2"><i class="bi bi-geo-alt"></i> <?= htmlspecialchars($row['vanue']) ?></small>
                
                <div class="bg-light p-2 rounded mb-3" style="font-size: 0.75rem;">
                    <i class="bi bi-calendar-event"></i> Event Date: <?= date('M j, Y g:i A', $eventStart) ?>
                </div>

                <div class="mt-auto">
                    <?php if($status_type == "waiting"): ?>
                        <div class="timer-box mb-2 text-center text-danger">
                            <small class="d-block text-muted mb-1">Registration starts in:</small>
                            <ul class="countdown list-inline m-0 d-flex justify-content-center" data-date="<?= date('m/d/Y H:i:s', $regDeadline) ?>" style="list-style:none; padding:0; gap:5px;">
                                <li class="bg-danger text-white rounded p-1" style="min-width:35px;"><span class="days d-block fw-bold">00</span><small style="font-size:9px;">Days</small></li>
                                <li class="bg-danger text-white rounded p-1" style="min-width:35px;"><span class="hours d-block fw-bold">00</span><small style="font-size:9px;">Hrs</small></li>
                                <li class="bg-danger text-white rounded p-1" style="min-width:35px;"><span class="minutes d-block fw-bold">00</span><small style="font-size:9px;">Min</small></li>
                                <li class="bg-danger text-white rounded p-1" style="min-width:35px;"><span class="seconds d-block fw-bold">00</span><small style="font-size:9px;">Sec</small></li>
                            </ul>
                        </div>
                        <button class="btn btn-secondary btn-sm w-100" disabled>Join Soon</button>
                    
                    <?php elseif($status_type == "full"): ?>
                        <button class="btn btn-warning btn-sm w-100" disabled>Event Full</button>

                    <?php elseif($row['start_date'] == $row['registration_deadline'] && $current_timestamp >= $eventStart): ?>
                        <button class="btn btn-danger btn-sm w-100" disabled>Registration Ended</button>
                    
                    <?php elseif($status_type == "closed"): ?>
                        <button class="btn btn-dark btn-sm w-100" disabled>Closed</button>
                    
                    <?php else: ?>
                        <a href="<?= $url ?>" class="btn btn-primary btn-sm w-100">Join Now</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php
}

$upcoming_sql = "SELECT * FROM create_events WHERE end_date > '$current_time' ORDER BY start_date ASC";
$upcoming_result = mysqli_query($conn, $upcoming_sql);

$all_sql = "SELECT * FROM create_events WHERE end_date <= '$current_time' ORDER BY start_date DESC";
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
        .timer-box { font-size: 0.8rem; font-weight: bold; color: #ff4d4d; margin-bottom: 5px; }
        .countdown li span { font-size: 14px; line-height: 1; }
        .btn-disabled { background-color: #6c757d !important; border-color: #6c757d !important; cursor: not-allowed; opacity: 0.65; 
		
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
        <?php 
        if ($banner_result && mysqli_num_rows($banner_result) > 0):
            while($banner = mysqli_fetch_assoc($banner_result)): 
        ?>
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
        <?php 
            endwhile; 
        else: 
        ?>
            <div class="hero-slider-item" style="background: #333; height: 600px;">
                <div class="container h-100 d-flex align-items-center">
                    <h1 class="text-white">Welcome to Nestu</h1>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<div class="pt-100 pb-70 bg-light">
    <div class="container">
        <div class="section-title text-center mb-5">
            <span class="top-title">Live Now</span>
            <h2>🚀 Upcoming Events</h2>
        </div>
        <div class="row g-4">
            <?php 
            if ($upcoming_result && mysqli_num_rows($upcoming_result) > 0) {
                while($row = mysqli_fetch_array($upcoming_result)) { renderEventCard($row, $conn); }
            } else {
                echo "<div class='col-12 text-center'><p class='text-muted'>No upcoming events.</p></div>";
            }
            ?>
        </div>
    </div>
</div>

<div class="pt-0 pb-100"> 
    <div class="container">
        <div class="section-title text-center mb-5">
            <span class="top-title">History</span>
            <h2>All Events Archive</h2>
        </div>
        <div class="conference-schedules-content">
            <?php 
            if ($all_result && mysqli_num_rows($all_result) > 0) {
                while($row = mysqli_fetch_array($all_result)) { 
                    $eventEnd = strtotime($row['end_date']);
            ?>
                <div class="row align-items-center mb-4 p-3 border rounded shadow-sm bg-white mx-0">
                    <div class="col-lg-3">
                        <img src="admin/uploads/<?= htmlspecialchars($row['event_image']) ?>" class="img-fluid rounded" style="max-height: 150px; width: 100%; object-fit: cover;">
                    </div>
                    <div class="col-lg-6">
                        <h4 class="mb-1"><?= htmlspecialchars($row['event_type']) ?></h4>
                        <p class="text-muted mb-2"><i class="bi bi-geo-alt-fill text-danger"></i> <?= htmlspecialchars($row['vanue']) ?></p>
                        <span class="badge bg-secondary">Ended on <?= date('M j, Y', $eventEnd) ?></span>
                    </div>
                    <div class="col-lg-3 text-center">
                        <button class="btn btn-dark w-100" disabled>Closed</button>
                    </div>
                </div>
            <?php 
                }
            }
            ?>
        </div>
    </div>
</div>

<?php include_once("include/footer.php");  ?>

<div class="go-top"><i class="flaticon-up-arrows"></i><i class="flaticon-up-arrows"></i></div>

<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/meanmenu.min.js"></script>
<script src="assets/js/bootstrap.bundle.min.js"></script> 
<script src="assets/js/downCount.js"></script>
<script src="assets/js/owl.carousel.min.js"></script>
<script src="assets/js/custom.js"></script>

<script>
$(document).ready(function() {
    // 1. Initialize Countdowns
    $('.countdown').each(function() {
        var $this = $(this);
        var finalDate = $this.data('date');
        if($.fn.downCount) {
            $this.downCount({
                date: finalDate,
                offset: +5.5 
            }, function () {
                location.reload();
            });
        }
    });

    // 2. SweetAlert logic
    const urlParams = new URLSearchParams(window.location.search);
    const myMsg = urlParams.get('msg');
    if (myMsg) {
        let title = '', text = '', icon = 'success';
        if (myMsg === 'signup_success') {
            title = 'Welcome!'; text = 'Registration successful!';
        } else if (myMsg === 'thankyou') {
            title = 'Seat Reserved!'; text = 'See you at the event!';
        } else if (myMsg === 'already_reg') {
            title = 'Note'; text = 'You are already registered.'; icon = 'info';
        }

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