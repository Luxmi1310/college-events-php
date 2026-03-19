<?php
include 'db_config.php';

/** * 1. FETCH EVENTS FOR FILTER DROPDOWN */
$event_list = [];
$event_query = "SELECT id, title FROM create_events ORDER BY title ASC";
$event_res = $conn->query($event_query);
if ($event_res) {
    while($e_row = $event_res->fetch_assoc()) {
        $event_list[] = $e_row;
    }
}

/** * 2. DATA FETCHING (TRIPLE JOIN) */
$registrations = [];
$query = "SELECT 
            r.id as reg_id, 
            r.status as reg_status, 
            r.add_dated as reg_date,
            s.id as student_id,
            s.Name as student_name, 
            s.Email as student_email,
            e.title as event_title 
          FROM event_register r
          JOIN student s ON r.student_id = s.id
          JOIN create_events e ON r.event_id = e.id
          ORDER BY r.add_dated DESC";

$result = $conn->query($query);
if ($result) {
    while($row = $result->fetch_assoc()) {
        $registrations[] = $row;
    }
}

$total_registrations = count($registrations);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Registrations | CampusEvents Pro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <style>
        :root { --primary-color: #1a237e; --card-shadow: 0 4px 20px rgba(0,0,0,0.08); }
        body { background-color: #f8f9fa; font-family: 'Inter', sans-serif; }
        #content { padding: 20px; }
        .status-badge { padding: 5px 12px; border-radius: 50px; font-size: 0.75rem; font-weight: 600; white-space: nowrap; }
        .status-confirmed { background: #e8f5e9; color: #2e7d32; }
        .student-avatar {
            width: 40px; height: 40px; background: #e8eaf6; color: #1a237e;
            display: flex; align-items: center; justify-content: center;
            border-radius: 8px; font-weight: bold;
        }
        .registrations-table-container { background: white; border-radius: 12px; box-shadow: var(--card-shadow); overflow: hidden; }
        #noMatchRow { display: none; }
    </style>
</head>
<body>

    <?php include_once("leftbar.php"); ?>

    <div id="content">
        <header class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">
            <div>
                <h2 class="fw-bold" style="color: var(--primary-color);"> Event Registration list</h2>
                <p class="text-muted mb-0">Displaying all students successfully registered for events</p>
            </div>
            
            <div class="d-flex gap-2">
                <select id="eventFilter" class="form-select" style="max-width: 200px;">
                    <option value="">All Events</option>
                    <?php foreach($event_list as $event): ?>
                        <option value="<?php echo htmlspecialchars($event['title']); ?>">
                            <?php echo htmlspecialchars($event['title']); ?>
                        </option>
                    <?php endforeach; ?>
                </select>

                <div class="input-group" style="max-width: 300px;">
                    <span class="input-group-text bg-white border-end-0"><i class="bi bi-search"></i></span>
                    <input type="text" id="regSearch" class="form-control border-start-0" placeholder="Search student...">
                </div>
            </div>
        </header>

        <main>
            <section class="registrations-table-container">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0" id="regTable">
                        <thead class="bg-light">
                            <tr>
                                <th>Student ID</th>
                                <th>Student Name</th>
                                <th>Email</th>
                                <th>Event Title</th>
                                <th>Reg. Date</th>
                                <th>Status</th>
                                <th class="text-end">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($registrations as $row): ?>
                                <tr class="data-row">
                                    <td class="fw-bold text-primary">#STU-<?php echo $row['student_id']; ?></td>
                                    <td>
                                        <div class="d-flex align-items-center gap-2">
                                            <div class="student-avatar"><?php echo strtoupper(substr($row['student_name'], 0, 1)); ?></div>
                                            <span><?php echo htmlspecialchars($row['student_name']); ?></span>
                                        </div>
                                    </td>
                                    <td><?php echo htmlspecialchars($row['student_email']); ?></td>
                                    <td class="event-title-cell"><?php echo htmlspecialchars($row['event_title']); ?></td>
                                    <td><?php echo date('M d, Y', strtotime($row['reg_date'])); ?></td>
                                    <td>
                                        <span class="status-badge status-confirmed">
                                            <i class="bi bi-check-circle-fill me-1"></i> Confirmed
                                        </span>
                                    </td>
                                    <td class="text-end">
                                        <button class="btn btn-sm btn-outline-danger" onclick="return confirm('Cancel this registration?')">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            
                            <tr id="noMatchRow">
                                <td colspan="7" class="text-center py-5">
                                    <i class="bi bi-person-x fs-1 text-muted"></i>
                                    <p class="mt-2 text-muted">User or registration not found.</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>
    
    <?php include_once("footer.php"); ?>

    <script>
        const regSearch = document.getElementById('regSearch');
        const eventFilter = document.getElementById('eventFilter');
        const rows = document.querySelectorAll('.data-row');
        const noMatchRow = document.getElementById('noMatchRow');

        function filterTable() {
            let searchText = regSearch.value.toLowerCase();
            let selectedEvent = eventFilter.value.toLowerCase();
            let hasVisibleRow = false;

            rows.forEach(row => {
                let rowText = row.innerText.toLowerCase();
                let eventTitle = row.querySelector('.event-title-cell').innerText.toLowerCase();
                
                // Check if row matches search AND matches event filter
                let matchesSearch = rowText.includes(searchText);
                let matchesEvent = selectedEvent === "" || eventTitle === selectedEvent;

                if (matchesSearch && matchesEvent) {
                    row.style.display = '';
                    hasVisibleRow = true;
                } else {
                    row.style.display = 'none';
                }
            });

            // Show "Not Found" if no rows are visible
            noMatchRow.style.display = hasVisibleRow ? 'none' : 'table-row';
        }

        regSearch.addEventListener('keyup', filterTable);
        eventFilter.addEventListener('change', filterTable);
    </script>
</body>
</html>