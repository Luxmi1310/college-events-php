<?php
include '../db_config.php';
date_default_timezone_set('Asia/Kolkata');

if (!isset($_GET['eid'])) {
    header("Location: past_events.php");
    exit();
}

$eid = mysqli_real_escape_string($conn, $_GET['eid']);

// 1. Fetch Event Details
$event_info = mysqli_query($conn, "SELECT event_type, capacity FROM create_events WHERE id = '$eid'");
$event = mysqli_fetch_assoc($event_info);

// 2. Fetch Attendees
$attendees_sql = "SELECT er.student_id, er.add_dated as reg_date, s.Name, s.Email, s.Phone 
                  FROM event_register er
                  JOIN student s ON er.student_id = s.Id
                  WHERE er.event_id = '$eid' 
                  ORDER BY er.id DESC";
$attendees_result = mysqli_query($conn, $attendees_sql);
$total_attendees = mysqli_num_rows($attendees_result);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Attendee List - <?= htmlspecialchars($event['event_type']) ?></title>
    <link rel="stylesheet" href="../assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <style>
        body { background-color: #f4f7fb; color: #334155; margin: 0; }
        .main-content { margin-left: 280px; padding: 40px; min-height: 100vh; transition: all 0.3s ease; }
        .page-title { font-size: 1.75rem; font-weight: 800; color: #1e293b; }
        .main-card { border: none; border-radius: 12px; box-shadow: 0 10px 30px rgba(0,0,0,0.03); background: #ffffff; }
        .custom-table thead th { background-color: #f8fafc; color: #64748b; font-weight: 700; text-transform: uppercase; font-size: 0.7rem; padding: 1.25rem 1rem; border-bottom: 1px solid #e2e8f0; }
        .custom-table tbody td { padding: 1.1rem 1rem; border-bottom: 1px solid #f1f5f9; font-size: 0.92rem; }
        .id-badge { background: #eff6ff; color: #2563eb; font-weight: 700; padding: 4px 10px; border-radius: 6px; border: 1px solid #dbeafe; }

        /* --- EXPORT/PRINT LOGIC --- */
        @media print {
            .main-content { margin-left: 0 !important; padding: 0 !important; width: 100% !important; }
            /* Hide Sidebar, Footer, and Buttons during Export/Print */
            .sidebar, #left-sidebar, .leftbar-wrapper, footer, .btn, .no-print, .breadcrumb { 
                display: none !important; 
            }
            .main-card { box-shadow: none !important; border: 1px solid #eee !important; }
            body { background-color: #fff !important; }
        }

        @media (max-width: 991px) { .main-content { margin-left: 0; padding: 20px; } }
    </style>
</head>
<body>

    <div class="leftbar-wrapper no-print">
        <?php include_once("leftbar.php"); ?>
    </div>

    <div class="main-content">
        <div class="container-fluid">
            
            <div class="row align-items-center mb-4 no-print">
                <div class="col-md-7">
                    <h2 class="page-title mb-1">Attendee Report</h2>
                    <p class="text-muted small mb-0">Event: <?= htmlspecialchars($event['event_type']) ?></p>
                </div>
                <div class="col-md-5 text-md-end mt-3 mt-md-0">
                    <button onclick="exportTableToExcel('attendeeTable', '<?= $event['event_type'] ?>_Attendees')" class="btn btn-success btn-sm px-3 rounded-2 me-2">
                        <i class="bi bi-file-earmark-excel me-2"></i> Export Excel
                    </button>
                    <button onclick="window.print()" class="btn btn-dark btn-sm px-3 rounded-2">
                        <i class="bi bi-printer me-2"></i> Print / PDF
                    </button>
                </div>
            </div>

            <div class="card main-card" id="printableArea">
                <div class="table-responsive">
                    <table class="table custom-table table-hover mb-0" id="attendeeTable">
                        <thead>
                            <tr>
                                <th class="ps-4">No.</th>
                                <th>Student ID</th>
                                <th>Full Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th class="pe-4">Reg. Date</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php 
                            $count = 1;
                            if($total_attendees > 0):
                                while($row = mysqli_fetch_assoc($attendees_result)): 
                            ?>
                            <tr>
                                <td class="ps-4 text-muted"><?= $count++ ?></td>
                                <td><span class="id-badge"><?= $row['student_id'] ?></span></td>
                                <td class="fw-bold text-dark"><?= htmlspecialchars($row['Name']) ?></td>
                                <td><?= htmlspecialchars($row['Email']) ?></td>
                                <td><?= htmlspecialchars($row['Phone']) ?></td>
                                <td class="pe-4"><?= date('d M, Y', strtotime($row['reg_date'])) ?></td>
                            </tr>
                            <?php endwhile; else: ?>
                            <tr><td colspan="6" class="text-center py-5 text-muted">No registrations found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
<div class="mt-4 d-flex justify-content-between align-items-center">
                <a href="past_events.php" class="btn btn-outline-secondary btn-sm px-3 rounded-2">
                    <i class="bi bi-arrow-left me-2"></i> Return to Archive
                </a>
		</div>
            <div class="no-print mt-5">
                <?php include_once("footer.php"); ?>
            </div>

        </div>
    </div>

    <script>
    function exportTableToExcel(tableID, filename = ''){
        var downloadLink;
        var dataType = 'application/vnd.ms-excel';
        var tableSelect = document.getElementById(tableID);
        var tableHTML = tableSelect.outerHTML.replace(/ /g, '%20');
        
        filename = filename?filename+'.xls':'excel_data.xls';
        downloadLink = document.createElement("a");
        document.body.appendChild(downloadLink);
        
        if(navigator.msSaveOrOpenBlob){
            var blob = new Blob(['\ufeff', tableHTML], { type: dataType });
            navigator.msSaveOrOpenBlob( blob, filename);
        } else {
            downloadLink.href = 'data:' + dataType + ', ' + tableHTML;
            downloadLink.download = filename;
            downloadLink.click();
        }
    }
    </script>

</body>
</html>