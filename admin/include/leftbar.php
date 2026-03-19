<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Events Pro - Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="stylesheet" href="css/style.css">
    
</head>
<body>
<nav id="sidebar">
        <!-- Sidebar Header -->
        <div class="sidebar-header">
            <a href="#" class="campus-logo">
                <div class="logo-icon">
                    <i class="bi bi-mortarboard"></i>
                </div>
                <div class="logo-text">
                    <h4>Events Pro</h4>
                    
                </div>
            </a>
        </div>
        
        <!-- Sidebar Menu -->
        <div class="sidebar-menu">
            <div class="nav-section">
                <div class="nav-title">Dashboard</div>
                <div class="nav-item">
                    <a href="dashboard.php" class="nav-link active">
                        <i class="bi bi-speedometer2"></i>
                        <span>Dashboard</span>
                    </a>
                    
                    <!--<a href="#" class="nav-link">
                        <i class="bi bi-graph-up"></i>
                        <span>Analytics</span>
                    </a>-->
					
                </div>
            </div>
            
            <div class="nav-section">
                <div class="nav-title">Event Management</div>
                <div class="nav-item">
                    <a href="allevents.php" class="nav-link">
                        <i class="bi bi-calendar-check"></i>
                        <span>All Events</span>
                    </a>
                    <a href="create_event.php" class="nav-link">
                        <i class="bi bi-plus-circle"></i>
                        <span>Create Event</span>
                    </a>
					<a href="event_register.php" class="nav-link">
                        <i class="bi bi-person-check"></i>
                        <span>Registered Events</span>
                    </a>
                    <a href="registrations.php" class="nav-link">
                        <i class="bi bi-person-check"></i>
                        <span>Registered Users</span>
                    </a>
                    <a href="feedback.php" class="nav-link">
                        <i class="bi bi-chat-left-text"></i>
                        <span>Feedback</span>
                    </a>
                </div>
            </div>
            
            <div class="nav-section">
                <div class="nav-title">Campus Organizations</div>
                <div class="nav-item">
				<a href="#" class="nav-link">
				<i class="bi bi-question-circle"></i>
				<span>Enquiries</span>
			</a>

			<a href="#" class="nav-link">
				<i class="bi bi-bell"></i>
				<span>Reminders</span>
			</a>                    <a href="#" class="nav-link">
                        <i class="bi bi-trophy"></i>
                        <span>Past Events</span>
                    </a>
                    
                </div>
            </div>
            
            <div class="nav-section">
                <div class="nav-title">Administration</div>
                <div class="nav-item">
                    
                    <a href="#" class="nav-link">
                        <i class="bi bi-gear"></i>
                        <span>Settings</span>
                    </a>
					 <a href="logout.php" class="nav-link" id="logoutBtn">
                        <button type="button" class="btn btn-danger btn-sm w-100">Logout</button>
                  </a>
                </div>
            </div>
        </div>
    </nav>