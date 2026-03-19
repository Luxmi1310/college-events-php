<?php 
// 1. Database and Header Includes
include_once("include/header.php"); 
include 'db_config.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
/** * 2. AUTHENTICATION CHECK
 * Strictly shows only the logged-in student's data.
 */
if (!isset($_SESSION['logged_memebers'])) {
    echo "<script>window.location.href='login.php';</script>";
    exit();
}
$student_id = $_SESSION['logged_memebers']['id'];
// 3. Fetch ONLY this logged-in Student's Details
$student_query = "SELECT * FROM student WHERE id = '$student_id'";
$student_result = mysqli_query($conn, $student_query);
$student = mysqli_fetch_assoc($student_result);

// 4. Fetch Statistics for ONLY this student
$stat_query = "SELECT 
    COUNT(*) as total,
    SUM(CASE WHEN status = 'upcoming' THEN 1 ELSE 0 END) as upcoming,
    SUM(CASE WHEN status = 'completed' THEN 1 ELSE 0 END) as completed
    FROM event_register WHERE student_id = '$student_id'";
$stat_result = mysqli_query($conn, $stat_query);
$stats = mysqli_fetch_assoc($stat_result);

// 5. Fetch Registered Events for ONLY this student
$events_query = "SELECT er.status as reg_status, ce.* FROM event_register er 
                 JOIN create_events ce ON er.event_id = ce.id 
                 WHERE er.student_id = '$student_id'
                 ORDER BY ce.event_date DESC";
$events_result = mysqli_query($conn, $events_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css"> 
    <link rel="stylesheet" href="assets/css/animate.min.css"> 
    <link rel="stylesheet" href="assets/css/boxicons.min.css">  
    <link rel="stylesheet" href="assets/css/magnific-popup.min.css">
    <link rel="stylesheet" href="assets/css/fancybox.min.css"> 
    <link rel="stylesheet" href="assets/css/meanmenu.min.css"> 
    <link rel="stylesheet" href="assets/css/flaticon.css"> 
    <link rel="stylesheet" href="assets/css/odometer.min.css"> 
    <link rel="stylesheet" href="assets/css/owl.carousel.min.css"> 
    <link rel="stylesheet" href="assets/css/owl.theme.default.min.css"> 
    <link rel="stylesheet" href="assets/css/scrollCue.css"> 
    <link rel="stylesheet" href="assets/css/style.css">  
    <link rel="stylesheet" href="assets/css/responsive.css"> 
    <link rel="stylesheet" href="assets/css/dark.css"> 
    
    <title>My Profile | Nestu</title>
    <link rel="icon" type="image/png" href="assets/images/favicon.png">

    <style>
        .profile-header { background: linear-gradient(135deg, #1a237e 0%, #0d47a1 100%); color: white; border-radius: 0 0 30px 30px; padding: 50px 0; }
        .profile-image { width: 120px; height: 120px; object-fit: cover; border: 4px solid white; box-shadow: 0 5px 15px rgba(0,0,0,0.2); }
        .stat-card { transition: all 0.3s ease; cursor: pointer; border: 1px solid #eee; border-radius: 15px; background: white; }
        .stat-card:hover { transform: translateY(-5px); box-shadow: 0 10px 20px rgba(0,0,0,0.1); }
        .stat-card.active { border: 2px solid #1a237e; background-color: #f0f2ff; }
        .event-row { transition: all 0.2s ease; }
    </style>
</head>
<body class="bg-light">
    <?php include_once("include/navbar.php"); ?>

    <header class="profile-header mb-5 shadow">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-2 text-center">
                    <img src="assets/images/favicon.png" alt="Profile" class="profile-image rounded-circle mb-3 mb-md-0">
                </div>
                <div class="col-md-7 text-center text-md-start">
                    <h1 class="fw-bold mb-1 text-white"><?php echo htmlspecialchars($student['Name']); ?></h1>
                    <p class="opacity-75 mb-2 text-white"><?php echo htmlspecialchars($student['Email']); ?></p>
                    <span class="badge bg-white text-primary px-3 py-2">Student ID: #<?php echo $student['id']; ?></span>
                </div>
            </div>
        </div>
    </header>

    <main class="container">
        <section class="row mb-4 text-center">
            <div class="col-md-4 mb-3">
                <div class="card stat-card shadow-sm py-3 filter-trigger active" data-filter="all">
                    <h6 class="text-muted text-uppercase small">All Registered</h6>
                    <h2 class="fw-bold text-primary mb-0"><?php echo $stats['total']; ?></h2>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card stat-card shadow-sm py-3 filter-trigger" data-filter="upcoming">
                    <h6 class="text-muted text-uppercase small">Upcoming Events</h6>
                    <h2 class="fw-bold text-warning mb-0"><?php echo $stats['upcoming'] ?? 0; ?></h2>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card stat-card shadow-sm py-3 filter-trigger" data-filter="completed">
                    <h6 class="text-muted text-uppercase small">Attended</h6>
                    <h2 class="fw-bold text-success mb-0"><?php echo $stats['completed'] ?? 0; ?></h2>
                </div>
            </div>
        </section>

        <section class="card shadow-sm border-0 rounded-4 overflow-hidden mb-5">
            <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-bold">My Event History</h5>
                <input type="text" id="eventSearch" class="form-control form-control-sm w-auto" placeholder="Search event name...">
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="eventsTable">
                        <thead class="table-light">
                            <tr>
                                <th class="ps-4">Event Info</th>
                                <th>Date</th>
                                <th>Category</th>
                                <th>Status</th>
                                <th class="text-end pe-4">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (mysqli_num_rows($events_result) > 0): ?>
                                <?php while($row = mysqli_fetch_assoc($events_result)): ?>
                                <tr class="event-row" data-status="<?php echo strtolower($row['reg_status']); ?>">
                                    <td class="ps-4">
                                        <div class="fw-bold text-dark"><?php echo htmlspecialchars($row['title']); ?></div>
                                        <small class="text-muted"><i class="bi bi-geo-alt"></i> <?php echo htmlspecialchars($row['vanue']); ?></small>
                                    </td>
                                    <td><?php echo date('M d, Y', strtotime($row['event_date'])); ?></td>
                                    <td><span class="badge rounded-pill bg-light text-dark border"><?php echo htmlspecialchars($row['event_type']); ?></span></td>
                                    <td>
                                        <?php if($row['reg_status'] == 'completed'): ?>
                                            <span class="badge bg-success-subtle text-success border border-success-subtle px-3">Completed</span>
                                        <?php else: ?>
                                            <span class="badge bg-warning-subtle text-warning border border-warning-subtle px-3">Upcoming</span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-end pe-4">
                                        <button class="btn btn-sm btn-outline-primary rounded-pill px-3 view-details" 
                                            data-title="<?php echo htmlspecialchars($row['title']); ?>"
                                            data-desc="<?php echo htmlspecialchars($row['description']); ?>"
                                            data-venue="<?php echo htmlspecialchars($row['vanue']); ?>"
                                            data-date="<?php echo date('F d, Y', strtotime($row['event_date'])); ?>"
                                            data-img="admin/uploads/<?php echo $row['event_image']; ?>">
                                            Details
                                        </button>
                                    </td>
                                </tr>
                                <?php endwhile; ?>
                            <?php else: ?>
                                <tr><td colspan="5" class="text-center py-5">You haven't registered for any events yet.</td></tr>
                            <?php endif; ?>
                            <tr id="noResults" style="display: none;">
                                <td colspan="5" class="text-center py-5 text-muted">No matches found.</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>

    <div class="modal fade" id="eventModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="position-relative">
                    <img id="modalImg" src="" class="card-img-top" style="height: 220px; object-fit: cover; border-radius: 10px 10px 0 0;">
                    <button type="button" class="btn-close position-absolute top-0 end-0 m-3 bg-white p-2 rounded-circle" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-4">
                    <h4 id="modalTitle" class="fw-bold text-primary mb-1"></h4>
                    <p id="modalDate" class="text-muted small mb-3"></p>
                    <p id="modalDesc" class="text-secondary mb-4"></p>
                    <div class="bg-light p-3 rounded-3">
                        <small class="fw-bold text-uppercase d-block mb-1 text-muted" style="font-size: 10px; letter-spacing: 1px;">Location / Venue</small>
                        <span id="modalVenue" class="text-dark fw-medium"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/jquery.min.js"></script>
    <script src="assets/js/bootstrap.bundle.min.js"></script>
	<script data-cfasync="false" src="../../cdn-cgi/scripts/5c5dd728/cloudflare-static/email-decode.min.js"></script><script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/meanmenu.min.js"></script>
        <script src="assets/js/bootstrap.bundle.min.js"></script> 
        <script src="assets/js/bootstrap-datepicker.min.js"></script>
        <script src="assets/js/downCount.js"></script>
        <script src="assets/js/scrollCue.min.js"></script>
        <script src="assets/js/fancybox.min.js"></script>
        <script src="assets/js/appear.min.js"></script>
        <script src="assets/js/odometer.min.js"></script>
        <script src="assets/js/magnific-popup.min.js"></script>
        <script src="assets/js/owl.carousel.min.js"></script>
        <script src="assets/js/parallax.min.js"></script>
        <script src="assets/js/ajaxchimp.min.js"></script>
        <script src="assets/js/form-validator.min.js"></script>
        <script src="assets/js/subscribe-custom.js"></script>
        <script src="assets/js/contact-form-script.js"></script>
        <script src="assets/js/custom.js"></script>
    <script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015" integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ==" data-cf-beacon='{"version":"2024.11.0","token":"5fe684bbe2954c839d4575e6915100ba","r":1,"server_timing":{"name":{"cfCacheStatus":true,"cfEdge":true,"cfExtPri":true,"cfL4":true,"cfOrigin":true,"cfSpeedBrain":true},"location_startswith":null}}' crossorigin="anonymous"></script>
    <script>
        const searchInput = document.getElementById('eventSearch');
        const filterCards = document.querySelectorAll('.filter-trigger');
        const rows = document.querySelectorAll('.event-row');
        const noResults = document.getElementById('noResults');

        function applyFilters() {
            const searchTerm = searchInput.value.toLowerCase();
            const activeFilter = document.querySelector('.filter-trigger.active').dataset.filter;
            let count = 0;

            rows.forEach(row => {
                const text = row.innerText.toLowerCase();
                const status = row.dataset.status;
                const matchesSearch = text.includes(searchTerm);
                const matchesFilter = (activeFilter === 'all' || status === activeFilter);

                if (matchesSearch && matchesFilter) {
                    row.style.display = '';
                    count++;
                } else {
                    row.style.display = 'none';
                }
            });
            noResults.style.display = count === 0 ? 'table-row' : 'none';
        }

        searchInput.addEventListener('keyup', applyFilters);
        filterCards.forEach(card => {
            card.addEventListener('click', function() {
                filterCards.forEach(c => c.classList.remove('active'));
                this.classList.add('active');
                applyFilters();
            });
        });

        document.querySelectorAll('.view-details').forEach(btn => {
            btn.addEventListener('click', function() {
                document.getElementById('modalTitle').innerText = this.dataset.title;
                document.getElementById('modalDesc').innerText = this.dataset.desc;
                document.getElementById('modalVenue').innerText = this.dataset.venue;
                document.getElementById('modalDate').innerText = this.dataset.date;
                document.getElementById('modalImg').src = this.dataset.img;
                new bootstrap.Modal(document.getElementById('eventModal')).show();
            });
        });
    </script>
</body>
</html>