<?php
include 'db_config.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    
    // Prepare the delete statement to prevent SQL injection
    $stmt = $conn->prepare("DELETE FROM create_events WHERE id = ?");
    $stmt->bind_param("i", $id);
    
    if ($stmt->execute()) {
        // Redirect back to your main management page
        header("Location: allevents.php?msg=deleted");
    } else {
        echo "Error deleting record: " . $conn->error;
    }
    
    $stmt->close();
    $conn->close();
} else {
    header("Location: allevents.php");
}
?>