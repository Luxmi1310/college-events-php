<?php
header('Content-Type: application/json');
error_reporting(E_ALL); 
ini_set('display_errors', 0); // Log errors but don't break JSON output

$host = "localhost";
$user = "root"; 
$pass = ""; 
$dbname = "event"; 

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Connection failed: " . $conn->connect_error]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 1. Sanitize Inputs
    $title    = $conn->real_escape_string($_POST['title']);
    $type     = $conn->real_escape_string($_POST['type']);
    $desc     = $conn->real_escape_string($_POST['description']);
    $start    = $conn->real_escape_string($_POST['start_date']);
    $end      = $conn->real_escape_string($_POST['end_date']);
    $vanue    = $conn->real_escape_string($_POST['venue']); 
    $capacity = (int)$_POST['capacity'];
    
    // Handle optional deadline
    $deadline = !empty($_POST['registration_deadline']) ? "'".$conn->real_escape_string($_POST['registration_deadline'])."'" : "NULL";

    // 2. Handle Image Upload
    $image_name = "";
    if (isset($_FILES['event_image']) && $_FILES['event_image']['error'] == 0) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) mkdir($target_dir, 0777, true);
        
        $file_ext = pathinfo($_FILES["event_image"]["name"], PATHINFO_EXTENSION);
        $image_name = time() . "_" . uniqid() . "." . $file_ext;
        move_uploaded_file($_FILES["event_image"]["tmp_name"], $target_dir . $image_name);
    }

    // 3. SQL Insert (using the 'vanue' spelling from your DB structure)
    $sql = "INSERT INTO create_events 
            (title, event_type, description, event_image, start_date, end_date, registration_deadline, vanue, capacity, status) 
            VALUES 
            ('$title', '$type', '$desc', '$image_name', '$start', '$end', $deadline, '$vanue', $capacity, 'upcoming')";

    if ($conn->query($sql) === TRUE) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "message" => "Database Error: " . $conn->error]);
    }
} else {
    echo json_encode(["success" => false, "message" => "No data submitted."]);
}

$conn->close();
?>