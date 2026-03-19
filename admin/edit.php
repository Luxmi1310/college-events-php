<?php
include 'db_config.php';

// --- 1. HANDLE THE UPDATE LOGIC ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_event'])) {
    $id = intval($_POST['id']);
    $title = $_POST['title'];
    $event_type = $_POST['event_type'];
    $status = $_POST['status'];
    $vanue = $_POST['vanue'];
    $capacity = intval($_POST['capacity']);

    // Convert datetime-local format to MySQL format
    $start_date = date('Y-m-d H:i:s', strtotime($_POST['start_date']));
    $end_date = date('Y-m-d H:i:s', strtotime($_POST['end_date']));
    
    // Sync the search-friendly event_date with the start_date
    $event_date = date('Y-m-d', strtotime($_POST['start_date']));

    if (strtotime($end_date) <= strtotime($start_date)) {
        $error = "Error: End date must be after the Start date.";
    } else {
        $sql = "UPDATE create_events SET title=?, event_type=?, status=?, vanue=?, capacity=?, start_date=?, end_date=?, event_date=? WHERE id=?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ssssisssi", $title, $event_type, $status, $vanue, $capacity, $start_date, $end_date, $event_date, $id);

        if ($stmt->execute()) {
            echo "<script>window.location.href='allevents.php?msg=updated';</script>";
            exit();
        } else {
            $error = "Update failed: " . $conn->error;
        }
    }
}

// --- 2. FETCH THE SINGLE EVENT TO EDIT ---
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $stmt = $conn->prepare("SELECT * FROM create_events WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $event = $result->fetch_assoc();
    
    if (!$event) { die("Event not found."); }
} else {
    header("Location: allevents.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Event | CampusEvents Pro</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <style>
        /* Base Layout */
        body { 
            background-color: #f8fafc; 
            margin: 0; 
            display: flex; /* Sidebar and Content side-by-side */
            min-height: 100vh;
        }

        /* The Main Viewport to the right of sidebar */
        #content {
            flex: 1;
            display: flex;
            flex-direction: column; /* Stack Header, Form, Footer vertically */
            height: 100vh;
            overflow-y: auto;
        }

        /* Full Width Header */
        .campus-header {
            background: white;
            padding: 1.25rem 2rem;
            border-bottom: 1px solid #e3e6f0;
            width: 100%;
        }

        /* Center the form in the middle space */
        .form-wrapper {
            flex: 1; /* Fills all space between header and footer */
            display: flex;
            justify-content: center; /* Center horizontally */
            align-items: center;     /* Center vertically */
            padding: 40px 20px;
        }

        .edit-container { 
            width: 100%;
            max-width: 850px; 
            background: white; 
            padding: 35px; 
            border-radius: 15px; 
            box-shadow: 0 0.5rem 2rem rgba(0,0,0,0.08); 
        }

        .form-label { font-weight: 600; color: #4e73df; font-size: 0.9rem; }
        .form-control, .form-select { padding: 0.6rem 0.75rem; border-color: #d1d3e2; }
        .form-control:focus { border-color: #4e73df; box-shadow: 0 0 0 0.2rem rgba(78,115,223,0.1); }
        
        .btn-update { 
            background: #4e73df; 
            border: none; 
            padding: 12px; 
            font-weight: 700; 
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transition: 0.3s;
        }
        .btn-update:hover { background: #2e59d9; transform: translateY(-1px); box-shadow: 0 4px 12px rgba(0,0,0,0.15); }

        /* Full Width Footer */
        footer {
            background: white;
            padding: 1rem 2rem;
            border-top: 1px solid #e3e6f0;
            width: 100%;
            text-align: center;
        }
    </style>
</head>
<body>

    <?php include_once("leftbar.php"); ?>

    <div id="content">
        
        <header class="campus-header d-flex justify-content-between align-items-center">
            <div class="header-title">
                <h3 class="fw-bold text-dark mb-0">Events Management</h3>
                <small class="text-muted">Update and refine event schedules</small>
            </div>
            <div class="header-actions">
                <a href="allevents.php" class="btn btn-outline-primary btn-sm px-3">
                    <i class="bi bi-list-ul me-1"></i> All Events
                </a>
            </div>
        </header>

        <main class="form-wrapper">
            <div class="edit-container">
                <div class="d-flex justify-content-between align-items-center mb-4 border-bottom pb-3">
                    <h4 class="fw-bold mb-0 text-primary">
                        <i class="bi bi-pencil-square me-2"></i>Edit Event Details
                    </h4>
                    <span class="badge bg-info text-white px-3 py-2">ID: #<?= $event['id'] ?></span>
                </div>

                <?php if(isset($error)): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i> <?= $error ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                <?php endif; ?>

                <form action="edit.php?id=<?= $event['id'] ?>" method="POST">
                    <input type="hidden" name="id" value="<?= $event['id'] ?>">

                    <div class="row g-3">
                        <div class="col-md-12">
                            <label class="form-label">Event Title</label>
                            <input type="text" name="title" class="form-control" value="<?= htmlspecialchars($event['title']) ?>" placeholder="Enter event name" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Event Category</label>
                            <select name="event_type" class="form-select">
                                <option value="Academic" <?= $event['event_type'] == 'Academic' ? 'selected' : '' ?>>Academic</option>
                                <option value="Social" <?= $event['event_type'] == 'Social' ? 'selected' : '' ?>>Social</option>
                                <option value="Workshop" <?= $event['event_type'] == 'Workshop' ? 'selected' : '' ?>>Workshop</option>
                                <option value="Seminar" <?= $event['event_type'] == 'Seminar' ? 'selected' : '' ?>>Seminar</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Lifecycle Status</label>
                            <select name="status" class="form-select">
                                <option value="Upcoming" <?= $event['status'] == 'Upcoming' ? 'selected' : '' ?>>Upcoming</option>
                                <option value="Ongoing" <?= $event['status'] == 'Ongoing' ? 'selected' : '' ?>>Ongoing</option>
                                <option value="Completed" <?= $event['status'] == 'Completed' ? 'selected' : '' ?>>Completed</option>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">Start Date & Time</label>
                            <input type="datetime-local" name="start_date" class="form-control" 
                                   value="<?= date('Y-m-d\TH:i', strtotime($event['start_date'])) ?>" required>
                        </div>

                        <div class="col-md-6">
                            <label class="form-label">End Date & Time</label>
                            <input type="datetime-local" name="end_date" class="form-control" 
                                   value="<?= date('Y-m-d\TH:i', strtotime($event['end_date'])) ?>" required>
                        </div>

                        <div class="col-md-8">
                            <label class="form-label">Venue Location</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light"><i class="bi bi-geo-alt"></i></span>
                                <input type="text" name="vanue" class="form-control" value="<?= htmlspecialchars($event['vanue']) ?>" required>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <label class="form-label">Attendee Capacity</label>
                            <input type="number" name="capacity" class="form-control" value="<?= $event['capacity'] ?>" required>
                        </div>
                    </div>

                    <div class="mt-5 d-flex gap-3">
                        <button type="submit" name="update_event" class="btn btn-primary btn-update flex-grow-1">
                            Save Changes
                        </button>
                        <a href="allevents.php" class="btn btn-light border py-2 px-4 fw-bold text-muted">Cancel</a>
                    </div>
                </form>
            </div>
        </main>

        <?php include_once("footer.php"); ?>
        
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>