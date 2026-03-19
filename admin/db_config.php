<?php
$host = "localhost";
$db_user = "root"; 
$db_pass = ""; 
$db_name = "event"; // <--- CHANGE THIS from 'campus_db' to 'event'

$conn = new mysqli($host, $db_user, $db_pass, $db_name);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>