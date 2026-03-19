<?php
include '../db_config.php'; 
date_default_timezone_set('Asia/Kolkata');
$current_time = date('Y-m-d H:i:s');

// Fetch only events that have already ended
$past_sql = "SELECT * FROM create_events WHERE end_date < '$current_time' ORDER BY end_date DESC";
$past_result = mysqli_query($conn, $past_sql);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin - Past Events Grid</title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
    /* 1. Layout Wrapper */
    body { 
        background-color: #f8f9fa; 
        margin: 0; 
    }

    /* 2. Offset for Fixed Sidebar 
       Most sidebars are 250px to 280px wide. 
       Adjust the 280px value below to match your sidebar width. */
    .main-content { 
        margin-left: 280px; 
        padding: 30px;
        min-height: 100vh;
        display: flex;
        flex-direction: column;
        transition: all 0.3s ease;
    }

    /* 3. Preserved Card Styles */
    .event-card { transition: transform 0.2s; border: none; }
    .event-card:hover { transform: translateY(-5px); }
    .img-container { position: relative; height: 180px; overflow: hidden; }
    .img-container img { width: 100%; height: 100%; object-fit: cover; }
    .event-badge { position: absolute; top: 10px; right: 10px; z-index: 2; }
    .capacity-info { font-size: 0.85rem; background: #f8f9fa; border-radius: 5px; padding: 8px; }

    /* 4. Responsive Adjustment
       On smaller screens (mobile), sidebars usually hide, 
       so we remove the margin. */
    @media (max-width: 991px) {
        .main-content {
            margin-left: 0;
            padding: 15px;
        }
    }

    /* 5. Footer Adjustment */
    footer {
        margin-top: auto;
        padding: 20px 0;
    }
</style>
</head>
<body>

<div class="wrapper">
    <?php include_once("leftbar.php"); ?>

    <div class="main-content">
        <div class="container-fluid"> <div class="d-flex justify-content-between align-items-center mb-4">
                <div>
                    <h2 class="fw-bold text-dark">Past Events Archive</h2>
                    <p class="text-muted">Manage and view details of concluded conferences.</p>
                </div>
                <a href="dashboard.php" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-arrow-left"></i> Back to Dashboard
                </a>
            </div>

            <div class="row g-4"> <?php 
                if(mysqli_num_rows($past_result) > 0):
                    while($row = mysqli_fetch_assoc($past_result)): 
                        $eid = $row['id'];
                        $reg_res = mysqli_query($conn, "SELECT COUNT(id) as total FROM event_register WHERE event_id='$eid'");
                        $reg_data = mysqli_fetch_assoc($reg_res);
                ?>
                <div class="col-xl-4 col-lg-6 col-md-6 mb-2">
                    <div class="card h-100 shadow-sm event-card">
                        <div class="img-container">
                            <span class="badge bg-dark event-badge">ID: #<?= $row['id'] ?></span>
                            <img src="uploads/<?= $row['event_image'] ?>" alt="Event Image">
                        </div>
                        
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title fw-bold text-truncate mb-0" style="max-width: 80%;">
                                    <?= htmlspecialchars($row['event_type']) ?>
                                </h5>
                                <span class="badge bg-secondary">Ended</span>
                            </div>
                            
                            <p class="text-muted small mb-3">
                                <i class="bi bi-geo-alt-fill text-danger"></i> <?= htmlspecialchars($row['vanue']) ?>
                            </p>

                            <div class="capacity-info mb-3">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Attendance</span>
                                    <strong><?= $reg_data['total'] ?> / <?= $row['capacity'] ?></strong>
                                </div>
                                <div class="progress" style="height: 6px;">
                                    <?php 
                                        $percent = ($row['capacity'] > 0) ? ($reg_data['total'] / $row['capacity']) * 100 : 0;
                                        $color = ($percent >= 90) ? 'bg-danger' : 'bg-success';
                                    ?>
                                    <div class="progress-bar <?= $color ?>" style="width: <?= $percent ?>%"></div>
                                </div>
                            </div>

                            <div class="mt-auto pt-3 border-top">
                                <div class="row g-2">
                                    <div class="col-6">
                                        <a href="attendees.php?eid=<?= $row['id'] ?>" class="btn btn-primary btn-sm w-100">
                                            <i class="bi bi-people"></i> Attendees
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <button onclick="confirmDelete(<?= $row['id'] ?>)" class="btn btn-outline-danger btn-sm w-100">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer bg-transparent text-center py-2">
                            <small class="text-muted italic">Concluded on: <?= date('d M, Y', strtotime($row['end_date'])) ?></small>
                        </div>
                    </div>
                </div>
                <?php 
                    endwhile; 
                else: 
                ?>
                <div class="col-12 text-center py-5">
                    <i class="bi bi-archive text-muted" style="font-size: 4rem;"></i>
                    <h4 class="mt-3 text-muted">No past events found.</h4>
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<?php include_once("footer.php"); ?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
function confirmDelete(id) {
    Swal.fire({
        title: 'Delete History?',
        text: "This action cannot be undone!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonText: 'Cancel',
        confirmButtonText: 'Yes, Delete!'
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = 'delete_event_query.php?id=' + id;
        }
    })
}
</script>
</body>
</html>