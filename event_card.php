<?php
function renderEventCard($row, $conn) {
    // 1. Get current registration count
    $reg_sql = "SELECT id FROM event_register WHERE event_id='".$row['id']."'";
    $reg_query = mysqli_query($conn, $reg_sql);
    $current_count = mysqli_num_rows($reg_query);
    
    // 2. Setup Timestamps using Unix Integers (Reliable for comparison)
     date_default_timezone_set('Asia/Kolkata');
    $now = time(); // Current time as integer
    
    $eventStart = strtotime($row['start_date']); // Event start as integer
    $eventEnd   = strtotime($row['end_date']);   // Event end as integer
    $capacity   = (int)$row['capacity'];

    // 3. Status Logic - Check the order
    if ($now < $eventStart) {
        // Current time is BEFORE the start date
        $status_type = "waiting"; 
    } elseif ($now > $eventEnd) {
        // Current time is AFTER the end date
        $status_type = "past";
    } elseif ($current_count >= $capacity) {
        // Capacity is full
        $status_type = "full";
    } else {
        // We are between Start and End, and not full
        $status_type = "open";
    }

    $url = !isset($_SESSION['logged_memebers']) ? "login.php" : "event_register.php?eid=" . $row['id'];
    ?>
    
    <div class="col-lg-4 col-md-6 mb-4">
        <div class="event-grid-card bg-white d-flex flex-column h-100 shadow-sm border">
            <img src="admin/uploads/<?= $row['event_image'] ?>" class="w-100" style="height:160px; object-fit:cover;">
            <div class="p-3 d-flex flex-column flex-grow-1">
                <h6 class="fw-bold mb-1"><?= htmlspecialchars($row['event_type']) ?></h6>
                <small class="text-muted mb-2"><i class="bi bi-geo-alt"></i> <?= htmlspecialchars($row['vanue']) ?></small>
                
                <div class="bg-light p-2 rounded mb-3" style="font-size: 0.75rem;">
                    <i class="bi bi-calendar-event"></i> Event Date: <?= date('M j, Y g:i A', $eventStart) ?>
                </div>

                <div class="mt-auto">
                    <?php if($status_type == "waiting"): ?>
                        <div class="timer-box mb-2 text-center text-danger">
                            <small class="d-block text-muted">Registration starts in:</small>
                            <span class="countdown" data-time="<?= $row['start_date'] ?>"></span>
                        </div>
                        <button class="btn btn-secondary btn-sm w-100" disabled style="cursor: not-allowed;">Join Soon</button>

                    <?php elseif($status_type == "open"): ?>
                        <div class="btn-box">
                            <a href="<?= $url ?>" class="btn btn-primary btn-sm w-100">Join Now</a>
                        </div>

                    <?php elseif($status_type == "full"): ?>
                        <button class="btn btn-warning btn-sm w-100" disabled>House Full</button>
                    <?php else: ?>
                        <button class="btn btn-dark btn-sm w-100" disabled>Closed</button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    <?php
}