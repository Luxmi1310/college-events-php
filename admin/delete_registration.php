<?php
include 'db_config.php';

if(isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "DELETE FROM registration_form WHERE student_id = $id";
    if ($conn->query($sql) === TRUE) {
        header("Location: registrations.php?msg=deleted"); // Go back to main page
    } else {
        echo "Error deleting record: " . $conn->error;
    }
}
?>