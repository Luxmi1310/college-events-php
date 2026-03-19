<?php
include 'db_config.php';

/** * 1. DATA FETCHING 
 */

// Fetch Events for Cards
$events = [];
$event_result = $conn->query("SELECT e.*, 
    (SELECT COUNT(*) FROM event_register r WHERE r.event_id = e.id) as current_participants 
    FROM create_events e ORDER BY e.event_date DESC");

if ($event_result) {
    while($row = $event_result->fetch_assoc()) {
        $events[] = $row;
    }
}

/** * 2. DASHBOARD STATISTICS 
 */
$today = date('Y-m-d');

// Total Events Count
$total_events_q = $conn->query("SELECT COUNT(*) as total FROM create_events");
$total_events = $total_events_q->fetch_assoc()['total'] ?? 0;

// Upcoming Events: Events where the START date is today or in the future
$upcoming_q = $conn->query("SELECT COUNT(*) as total FROM create_events WHERE start_date >= '$today'");
$total_upcoming = $upcoming_q->fetch_assoc()['total'] ?? 0;

// Past Events: Events where the END date has already passed
$past_q = $conn->query("SELECT COUNT(*) as total FROM create_events WHERE end_date < '$today'");
$total_past = $past_q->fetch_assoc()['total'] ?? 0;

// Total Students
$student_q = $conn->query("SELECT COUNT(*) as total FROM student");
$total_students = $student_q->fetch_assoc()['total'] ?? 0;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampusEvents Pro | Admin Dashboard</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
    
    <style>
        
        .event-card { background: white; border-radius: 12px; padding: 20px; border: 1px solid #eee; position: relative; transition: 0.3s; }
        .event-past { opacity: 0.7; filter: grayscale(0.5); background-color: #f8f9fc; }
        .event-card:hover { transform: translateY(-5px); box-shadow: 0 5px 15px rgba(0,0,0,0.1); }
    </style>
</head>
<body>
    <?php include_once("leftbar.php"); ?>

    <div id="content" class="p-1">
        <nav class="campus-header d-flex justify-content-between align-items-center mb-4">
            <div class="header-left">
                <h2 class="fw-bold mb-0">Events Management</h2>
                
            </div>
            <div class="header-right">
                <a href="create_event.php" class="btn btn-primary">
                    <i class="bi bi-plus-circle me-1"></i> Create Event
                </a>
            </div>
        </nav>
        
        <div class="quick-stats-bar">
            <div class="quick-stat-card border-start border-4 border-primary">
                <div class="quick-stat-icon bg-primary"><i class="bi bi-calendar-range"></i></div>
                <div class="quick-stat-content">
                    <h4 class="mb-0 fw-bold"><?php echo $total_events; ?></h4>
                    <p class="mb-0 text-muted small">Total Events</p>
                </div>
            </div>
            
            <div class="quick-stat-card border-start border-4 border-success">
                <div class="quick-stat-icon bg-success"><i class="bi bi-calendar-check"></i></div>
                <div class="quick-stat-content">
                    <h4 class="mb-0 fw-bold text-success"><?php echo $total_upcoming; ?></h4>
                    <p class="mb-0 text-muted small">Upcoming</p>
                </div>
            </div>

            <div class="quick-stat-card border-start border-4 border-danger">
                <div class="quick-stat-icon bg-danger"><i class="bi bi-calendar-x"></i></div>
                <div class="quick-stat-content">
                    <h4 class="mb-0 fw-bold text-danger"><?php echo $total_past; ?></h4>
                    <p class="mb-0 text-muted small">Concluded (Past)</p>
                </div>
            </div>
            
            <div class="quick-stat-card border-start border-4 border-info">
                <div class="quick-stat-icon bg-info"><i class="bi bi-people"></i></div>
                <div class="quick-stat-content">
                    <h4 class="mb-0 fw-bold"><?php echo $total_students; ?></h4>
                    <p class="mb-0 text-muted small">Total Students</p>
                </div>
            </div>
        </div>

        <div class="events-grid">
            <?php if (!empty($events)): ?>
                <?php foreach ($events as $row): 
                    // LOGIC: Event is past only if the end_date has passed
                    $endTimestamp = strtotime($row['end_date']);
                    $todayTimestamp = strtotime($today);
                    $isPast = ($endTimestamp < $todayTimestamp);
                ?>
                    <div class="event-card <?= $isPast ? 'event-past' : '' ?>">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <div>
                                <span class="badge bg-light text-dark border small"><?= htmlspecialchars($row['event_type']) ?></span>
                                <h5 class="mt-2 fw-bold mb-0"><?= htmlspecialchars($row['title']) ?></h5>
                            </div>
                            <?php if($isPast): ?>
                                <span class="badge bg-secondary rounded-pill small">Concluded</span>
                            <?php else: ?>
                                <span class="badge bg-success rounded-pill small">Active</span>
                            <?php endif; ?>
                        </div>
                        
                        <div class="event-info mb-3">
                            <div class="small text-muted mb-1">
                                <i class="bi bi-calendar-event me-2 text-primary"></i> 
                                <strong>Starts:</strong> <?= date('M d, Y', strtotime($row['start_date'])) ?>
                            </div>
                            <div class="small text-muted mb-1">
                                <i class="bi bi-calendar-check me-2 text-success"></i> 
                                <strong>Ends:</strong> <?= date('M d, Y', strtotime($row['end_date'])) ?>
                            </div>
                            <div class="small text-muted mb-1">
                                <i class="bi bi-geo-alt me-2 text-danger"></i> <?= htmlspecialchars($row['vanue']) ?>
                            </div>
                        </div>

                        <?php 
                            $capacity = (int)$row['capacity'];
                            $participants = (int)$row['current_participants'];
                            $percent = ($capacity > 0) ? ($participants / $capacity) * 100 : 0;
                        ?>
                        <div class="registration-box bg-light p-2 rounded">
                            <div class="d-flex justify-content-between mb-1 small">
                                <span class="text-muted">Attendance</span>
                                <span class="fw-bold"><?= $participants ?> / <?= $capacity ?></span>
                            </div>
                            <div class="progress" style="height: 5px;">
                                <div class="progress-bar bg-primary" style="width: <?= $percent ?>%;"></div>
                            </div>
                        </div>

                        <div class="event-footer mt-4 d-flex gap-2 pt-3 border-top">
                            <a href="edit.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-primary flex-grow-1">Edit</a>
                            <a href="delete_event.php?id=<?= $row['id'] ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Delete?');"><i class="bi bi-trash"></i></a>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="col-12 text-center py-5">
                    <p class="text-muted">No events found.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
     	<?php include_once("footer.php");  ?>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>