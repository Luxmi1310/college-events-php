<?php
include 'db_config.php';

/** * 1. DATA FETCHING 
 * We fetch student details and determine registration status based on 'Status' column.
 */
$students = [];
$query = "SELECT 
            id, 
            Name, 
            Email, 
            Phone, 
            Status, 
            ADD_dated 
          FROM student 
          ORDER BY Name ASC";

$result = $conn->query($query);
if ($result) {
    while($row = $result->fetch_assoc()) {
        $students[] = $row;
    }
}

/** 2. DASHBOARD STATISTICS */
$total_students = count($students);
$total_registered = 0;
foreach($students as $s) {
    if($s['Status'] == 1) $total_registered++;
}
$total_pending = $total_students - $total_registered;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Student Management | CampusEvents Pro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        :root { --primary-color: #1a237e; --card-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        body { background-color: #f8f9fa; font-family: 'Inter', sans-serif; }
        #content { padding: 20px; }
        /* This ensures button and badge text never breaks into two lines */
.status-badge, .btn-sm { white-space: nowrap !important; }
        .quick-stats-bar {
            display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px; margin-bottom: 30px;
        }
        .quick-stat-card {
            background: white; padding: 15px; border-radius: 10px;
            display: flex; align-items: center; gap: 15px; box-shadow: var(--card-shadow);
        }
        .quick-stat-icon {
            width: 45px; height: 45px; border-radius: 8px;
            display: flex; align-items: center; justify-content: center; color: white;
        }

        .registrations-table-container {
            background: white; border-radius: 12px;
            box-shadow: var(--card-shadow); overflow: hidden;
        }

        .status-badge { padding: 5px 12px; border-radius: 50px; font-size: 0.75rem; font-weight: 600; }
        .status-confirmed { background: #e8f5e9; color: #2e7d32; }
        .status-pending { background: #ffebee; color: #c62828; }

        .student-avatar {
            width: 40px; height: 40px; background: #e8eaf6; color: #1a237e;
            display: flex; align-items: center; justify-content: center;
            border-radius: 8px; font-weight: bold;
        }
        .search-box { max-width: 400px; }
    </style>
</head>
<body>

    <?php include_once("leftbar.php"); ?>

    <div id="content">
        <header class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h2 class="fw-bold" style="color: var(--primary-color);">Student Verification Portal</h2>
                <p class="text-muted">Tracking OTP Verification (Status 1 = Registered)</p>
            </div>
            <div class="search-box input-group">
                <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                <input type="text" id="studentSearch" class="form-control border-start-0" placeholder="Search name, email or phone...">
            </div>
        </header>

        <main>
            <div class="quick-stats-bar">
                <div class="quick-stat-card border-start border-4 border-primary">
                    <div class="quick-stat-icon bg-primary"><i class="bi bi-people"></i></div>
                    <div>
                        <h4 class="mb-0 fw-bold"><?php echo $total_students; ?></h4>
                        <p class="mb-0 text-muted small">Total Students</p>
                    </div>
                </div>
                <div class="quick-stat-card border-start border-4 border-success">
                    <div class="quick-stat-icon bg-success"><i class="bi bi-check-circle"></i></div>
                    <div>
                        <h4 class="mb-0 fw-bold text-success"><?php echo $total_registered; ?></h4>
                        <p class="mb-0 text-muted small">Verified (Registered)</p>
                    </div>
                </div>
                <div class="quick-stat-card border-start border-4 border-danger">
                    <div class="quick-stat-icon bg-danger"><i class="bi bi-clock"></i></div>
                    <div>
                        <h4 class="mb-0 fw-bold text-danger"><?php echo $total_pending; ?></h4>
                        <p class="mb-0 text-muted small">Pending OTP</p>
                    </div>
                </div>
            </div>

            <section class="registrations-table-container">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="studentTable">
                        <thead class="bg-light">
                            <tr>
                                <th>Student Name</th>
                                <th>Email Address</th>
                                <th>Phone Number</th>
                                <th>Registration Date</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($students as $row): ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center gap-3">
                                            <div class="student-avatar">
                                                <?php echo strtoupper(substr($row['Name'], 0, 1)); ?>
                                            </div>
                                            <div class="fw-bold"><?php echo htmlspecialchars($row['Name']); ?></div>
                                        </div>
                                    </td>
                                    <td><?php echo htmlspecialchars($row['Email']); ?></td>
                                    <td><?php echo htmlspecialchars($row['Phone']); ?></td>
                                    <td><?php echo date('M d, Y', strtotime($row['ADD_dated'])); ?></td>
                                    <td>
                                        <?php if ($row['Status'] == 1): ?>
                                            <span class="status-badge status-confirmed">
                                                <i class="bi bi-patch-check-fill me-1"></i> Registered
                                            </span>
                                        <?php else: ?>
                                            <span class="status-badge status-pending">
                                                <i class="bi bi-x-circle me-1"></i> Not Registered
                                            </span>
                                        <?php endif; ?>
                                    </td>
                                    <td class="text-end">
    <?php if ($row['Status'] == 0): ?>
        <a href="update_status.php?id=<?php echo $row['id']; ?>&new_status=1" 
           class="btn btn-sm btn-success" 
           onclick="return confirm('Verify this student?')">
           <i class="bi bi-check-lg"></i>Verify Student
        </a>
    <?php else: ?>
        <a href="update_status.php?id=<?php echo $row['id']; ?>&new_status=0" 
           class="btn btn-sm btn-outline-danger" 
           onclick="return confirm('Revoke verification?')">
           Revoke
        </a>
    <?php endif; ?>
</td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>

    <script>
        document.getElementById('studentSearch').addEventListener('keyup', function() {
            let filter = this.value.toLowerCase();
            let rows = document.querySelectorAll('#studentTable tbody tr');

            rows.forEach(row => {
                let text = row.innerText.toLowerCase();
                row.style.display = text.includes(filter) ? '' : 'none';
            });
        });
    </script>

</body>
</html>