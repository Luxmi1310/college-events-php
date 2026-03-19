<?php
$host = "localhost";
$db_user = "root";
$db_pass = "";
$db_name = "event"; // Use your existing database name here

$conn = new mysqli($host, $db_user, $db_pass, $db_name);

// Then fetch your counts
$total_events = $conn->query("SELECT COUNT(*) as total FROM events")->fetch_assoc()['total'];
$total_users = $conn->query("SELECT COUNT(*) as total FROM user")->fetch_assoc()['total'];
?>