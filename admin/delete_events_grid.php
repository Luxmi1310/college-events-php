<?php
include '../db_config.php';

if (isset($_GET['id'])) {
    $id = mysqli_real_escape_string($conn, $_GET['id']);

    // 1. Get the image name so we can delete the file from the folder
    $img_query = mysqli_query($conn, "SELECT event_image FROM create_events WHERE id = '$id'");
    $img_data = mysqli_fetch_assoc($img_query);
    $image_path = "uploads/" . $img_data['event_image'];

    // 2. Delete registrations associated with this event first
    mysqli_query($conn, "DELETE FROM event_register WHERE event_id = '$id'");

    // 3. Delete the event from the database
    $delete_sql = "DELETE FROM create_events WHERE id = '$id'";
    
    if (mysqli_query($conn, $delete_sql)) {
        // 4. If database delete is successful, remove the file from the server
        if (file_exists($image_path)) {
            unlink($image_path);
        }
        header("Location: past_events_grid.php?msg=deleted");
    } else {
        echo "Error deleting record: " . mysqli_error($conn);
    }
} else {
    header("Location: past_events_grid.php");
}
?>