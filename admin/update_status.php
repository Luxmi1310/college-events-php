<?php
include 'db_config.php';

if (isset($_GET['id']) && isset($_GET['new_status'])) {
    $id = intval($_GET['id']);
    $status = intval($_GET['new_status']);

    // Prepare the update query
    $stmt = $conn->prepare("UPDATE student SET Status = ? WHERE id = ?");
    $stmt->bind_param("ii", $status, $id);

    if ($stmt->execute()) {
        // Redirect back to the main list with a success message
        header("Location: registrations.php?msg=StatusUpdated");
    } else {
        echo "Error updating record: " . $conn->error;
    }
    $stmt->close();
}
$conn->close();
?>