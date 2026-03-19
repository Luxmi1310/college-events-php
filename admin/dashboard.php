<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

include '../db_config.php'; 
date_default_timezone_set('Asia/Kolkata');
$current_time = date('Y-m-d H:i:s');

// Optimized Database Fetch - Added logic for Past Events count
$query = "SELECT 
    (SELECT COUNT(*) FROM create_events) as total_events,
    (SELECT COUNT(*) FROM user) as total_users,
    (SELECT COUNT(*) FROM student) as total_student,
    (SELECT COUNT(*) FROM create_events WHERE end_date < '$current_time') as total_past";

$result = $conn->query($query);
$stats = $result->fetch_assoc();

$total_events = $stats['total_events'] ?? 0;
$total_participants = $stats['total_users'] ?? 0;
$total_student_regs = $stats['total_student'] ?? 0;
$total_past_events = $stats['total_past'] ?? 0; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events Pro - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        /* ADJUSTABLE SIDEBAR LOGIC */
        body { background-color: #f4f7fb; color: #334155; margin: 0; }
        
        #content { 
            margin-left: 280px; /* Adjust this to match your sidebar width */
            padding: 0;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            transition: all 0.3s ease;
        }

        .main-content { padding: 40px; flex: 1; }

        .campus-header {
            background: #fff;
            padding: 20px 40px;
            border-bottom: 1px solid #e2e8f0;
        }

        /* Stats Grid Styling */
        .campus-stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 25px;
            margin-bottom: 40px;
        }

        .campus-stat-card {
            background: #fff;
            padding: 25px;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.03);
            border: none;
            transition: transform 0.2s;
            text-decoration: none; /* For linkability */
            display: block;
        }

        .campus-stat-card:hover { transform: translateY(-5px); box-shadow: 0 8px 25px rgba(0,0,0,0.07); }

        .campus-stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            color: #fff;
            margin-bottom: 15px;
        }

        .campus-stat-value {
            font-size: 2rem;
            font-weight: 800;
            color: #1e293b;
            margin: 0;
        }

        @media (max-width: 991px) {
            #content { margin-left: 0; }
            .campus-header, .main-content { padding: 20px; }
        }
    </style>
</head>
<body>
    
    <?php include_once("leftbar.php"); ?>

    <div id="content">
        <header class="campus-header d-flex justify-content-between align-items-center">
            <div class="page-title">
                <h2 class="fw-bold mb-0">Events Dashboard</h2>
                <small class="text-muted">Overview of your campus activities</small>
            </div>
            <div class="header-right">
                <a href="create_event.php" class="btn btn-primary px-4 rounded-3 shadow-sm">
                    <i class="bi bi-plus-lg me-2"></i> New Event
                </a>
            </div>
        </header>
        
        <div class="main-content">
            <div class="campus-stats-grid">
                <div class="campus-stat-card">
                    <div class="campus-stat-icon bg-primary shadow-sm"><i class="bi bi-calendar-event"></i></div>
                    <h2 class="campus-stat-value"><?php echo $total_events; ?></h2>
                    <p class="text-muted mb-0 fw-semibold small">Total Created Events</p>
                </div>
                
                <div class="campus-stat-card">
                    <div class="campus-stat-icon bg-success shadow-sm"><i class="bi bi-person-check"></i></div>
                    <h2 class="campus-stat-value"><?php echo number_format($total_participants); ?></h2>
                    <p class="text-muted mb-0 fw-semibold small">Total Registered Users</p>
                </div>
                
                <div class="campus-stat-card">
                    <div class="campus-stat-icon bg-info shadow-sm"><i class="bi bi-journal-text"></i></div>
                    <h2 class="campus-stat-value"><?php echo $total_student_regs; ?></h2>
                    <p class="text-muted mb-0 fw-semibold small">Student Enrollments</p>
                </div>
                
                <a href="past_events.php" class="campus-stat-card border-start border-4 border-warning">
                    <div class="campus-stat-icon bg-warning text-dark shadow-sm"><i class="bi bi-archive"></i></div>
                    <h2 class="campus-stat-value"><?php echo $total_past_events; ?></h2>
                    <p class="text-muted mb-0 fw-semibold small">Past Events Archive</p>
                    <div class="mt-2">
                        <span class="text-primary small fw-bold">View Archive <i class="bi bi-arrow-right"></i></span>
                    </div>
                </a>
            </div>

            <?php include_once("footer.php"); ?>
        </div>
    </div>

</body>
</html>