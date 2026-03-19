<?php
session_start();
include 'db_config.php'; 

if (!isset($_SESSION['logged_memebers'])) {
    header("Location: login.php");
    exit();
}

$eventid = mysqli_real_escape_string($conn, $_GET['eid']);
$student_id = $_SESSION['logged_memebers']['id'];

// 1. Fetch Event Details
$event_res = mysqli_query($conn, "SELECT capacity, end_date FROM create_events WHERE id='$eventid'");
$event_row = mysqli_fetch_assoc($event_res);

if (!$event_row) {
    header("Location: index.php?msg=error");
    exit();
}

$max_capacity = $event_row['capacity'];
$end_date_str = $event_row['end_date']; 

// 2. Count current registrations
$count_res = mysqli_query($conn, "SELECT id FROM event_register WHERE event_id='$eventid'");
$current_registrations = mysqli_num_rows($count_res);

// 3. Check for existing registration
$check_user = mysqli_query($conn, "SELECT id FROM event_register WHERE student_id='$student_id' AND event_id='$eventid'");

// --- VALIDATION LOGIC ---
date_default_timezone_set('Asia/Kolkata');
$now = time();
$eventEnd = strtotime($end_date_str);

if (mysqli_num_rows($check_user) > 0) {
    header("Location: index.php?msg=already_reg");
} 
elseif ($now > $eventEnd) {
    header("Location: index.php?msg=date_passed");
} 
elseif ($current_registrations >= $max_capacity) {
    header("Location: index.php?msg=full");
} 
else {
    $insert = "INSERT INTO event_register (event_id, student_id, status, add_dated) VALUES ('$eventid', '$student_id', '0', NOW())";
    if (mysqli_query($conn, $insert)) {
        // Updated to 'thankyou' to trigger the special popup
        header("Location: index.php?msg=thankyou");
    } else {
        header("Location: index.php?msg=error");
    }
}
exit();
?>