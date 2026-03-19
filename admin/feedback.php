<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampusEvents Pro | Feedback Management</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <!-- Chart.js for Analytics -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link rel="stylesheet" href="css/style.css">
	
    <!-- Custom CSS -->
    <style>
        
        
        
        
        /* Feedback Header */
        
        
        
        
        /* Feedback Stats Cards */
        
        
        
    </style>
</head>
<body>
    <!-- Sidebar -->
	<?php include_once("leftbar.php");  ?>
    
   
    
    <!-- Main Content -->
    <div id="content">
        <!-- Campus Header -->
        <nav class="campus-header">
            <div class="header-left">
                <button class="campus-toggle" id="sidebarToggle">
                    <i class="bi bi-list"></i>
                </button>
                <div class="page-title">
                    <h2>Feedback Management</h2>
                    <p>Review and respond to event feedback from participants</p>
                </div>
            </div>
            
            <div class="header-right">
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#sendSurveyModal">
                    <i class="bi bi-send me-2"></i>
                    Send Survey
                </button>
            </div>
        </nav>
        
        <!-- Main Content Area -->
        <div class="main-content">
            <!-- Feedback Header -->
            <div class="feedback-header">
                <div class="feedback-title">
                    <h3>Event Feedback & Reviews</h3>
                    <p>Track participant satisfaction and improve future events</p>
                </div>
                
                <div class="d-flex gap-3">
                    <button class="btn btn-outline-primary" id="exportFeedbackBtn">
                        <i class="bi bi-download me-2"></i>
                        Export
                    </button>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#filterModal">
                        <i class="bi bi-funnel me-2"></i>
                        Filter
                    </button>
                </div>
            </div>
            
            <!-- Feedback Stats -->
            <div class="feedback-stats">
                <div class="stat-card">
                    <div class="stat-icon" style="background-color: var(--primary-color);">
                        <i class="bi bi-chat-left-text"></i>
                    </div>
                    <div class="stat-content">
                        <h4>142</h4>
                        <p>Total Feedback</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon" style="background-color: var(--accent-color);">
                        <i class="bi bi-star"></i>
                    </div>
                    <div class="stat-content">
                        <h4>4.7</h4>
                        <p>Average Rating</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon" style="background-color: var(--warning-color);">
                        <i class="bi bi-clock-history"></i>
                    </div>
                    <div class="stat-content">
                        <h4>18</h4>
                        <p>Unread Feedback</p>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-icon" style="background-color: var(--campus-teal);">
                        <i class="bi bi-check-circle"></i>
                    </div>
                    <div class="stat-content">
                        <h4>85%</h4>
                        <p>Response Rate</p>
                    </div>
                </div>
            </div>
            
            <!-- Analytics Section -->
            <div class="analytics-section">
                <div class="analytics-card">
                    <div class="card-header">
                        <h5>Feedback Trends</h5>
                        <select class="form-select form-select-sm" style="width: 150px;">
                            <option>Last 30 Days</option>
                            <option>Last 90 Days</option>
                            <option>This Semester</option>
                        </select>
                    </div>
                    <div class="chart-container">
                        <canvas id="feedbackTrendsChart"></canvas>
                    </div>
                </div>
                
                <div class="analytics-card">
                    <div class="card-header">
                        <h5>Rating Distribution</h5>
                    </div>
                    <div class="rating-distribution">
                        <div class="rating-bar">
                            <div class="rating-label">5 Stars</div>
                            <div class="rating-stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                            </div>
                            <div class="rating-progress">
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 65%;"></div>
                                </div>
                            </div>
                            <div class="rating-count">65%</div>
                        </div>
                        
                        <div class="rating-bar">
                            <div class="rating-label">4 Stars</div>
                            <div class="rating-stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star"></i>
                            </div>
                            <div class="rating-progress">
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 22%;"></div>
                                </div>
                            </div>
                            <div class="rating-count">22%</div>
                        </div>
                        
                        <div class="rating-bar">
                            <div class="rating-label">3 Stars</div>
                            <div class="rating-stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star"></i>
                                <i class="bi bi-star"></i>
                            </div>
                            <div class="rating-progress">
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 8%;"></div>
                                </div>
                            </div>
                            <div class="rating-count">8%</div>
                        </div>
                        
                        <div class="rating-bar">
                            <div class="rating-label">2 Stars</div>
                            <div class="rating-stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star"></i>
                                <i class="bi bi-star"></i>
                                <i class="bi bi-star"></i>
                            </div>
                            <div class="rating-progress">
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 3%;"></div>
                                </div>
                            </div>
                            <div class="rating-count">3%</div>
                        </div>
                        
                        <div class="rating-bar">
                            <div class="rating-label">1 Star</div>
                            <div class="rating-stars">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star"></i>
                                <i class="bi bi-star"></i>
                                <i class="bi bi-star"></i>
                                <i class="bi bi-star"></i>
                            </div>
                            <div class="rating-progress">
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar bg-warning" role="progressbar" style="width: 2%;"></div>
                                </div>
                            </div>
                            <div class="rating-count">2%</div>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Filter Section -->
            <div class="filter-section">
                <div class="filter-grid">
                    <div class="filter-group">
                        <label for="filterEvent">Event</label>
                        <select class="form-select" id="filterEvent">
                            <option value="">All Events</option>
                            <option value="tech-conference">Tech Conference 2023</option>
                            <option value="sports-festival">Sports Festival</option>
                            <option value="research-symposium">Research Symposium</option>
                            <option value="cultural-fest">Cultural Festival</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label for="filterRating">Rating</label>
                        <select class="form-select" id="filterRating">
                            <option value="">All Ratings</option>
                            <option value="5">5 Stars</option>
                            <option value="4">4 Stars</option>
                            <option value="3">3 Stars</option>
                            <option value="2">2 Stars</option>
                            <option value="1">1 Star</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label for="filterStatus">Status</label>
                        <select class="form-select" id="filterStatus">
                            <option value="">All Status</option>
                            <option value="unread">Unread</option>
                            <option value="responded">Responded</option>
                            <option value="flagged">Flagged</option>
                        </select>
                    </div>
                    
                    <div class="filter-group">
                        <label for="filterDate">Date Range</label>
                        <input type="date" class="form-control" id="filterDate">
                    </div>
                </div>
                
                <div class="d-flex justify-content-end mt-3">
                    <button class="btn btn-outline-secondary me-2" id="clearFiltersBtn">
                        Clear Filters
                    </button>
                    <button class="btn btn-primary" id="applyFiltersBtn">
                        Apply Filters
                    </button>
                </div>
            </div>
            
            <!-- Feedback List -->
            <div class="feedback-list" id="feedbackList">
                <!-- Feedback Card 1 -->
                <div class="feedback-card unread">
                    <div class="feedback-header-row">
                        <div class="feedback-user">
                            <div class="user-avatar-small">
                                JD
                            </div>
                            <div class="user-info">
                                <h6>John Davis</h6>
                                <p>Computer Science Student</p>
                            </div>
                        </div>
                        
                        <div class="feedback-meta">
                            <div class="feedback-rating">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <span class="ms-2">5.0</span>
                            </div>
                            <div class="feedback-date">
                                <i class="bi bi-calendar me-1"></i> October 18, 2023
                            </div>
                        </div>
                    </div>
                    
                    <div class="feedback-event">
                        <h6>Tech Conference 2023</h6>
                        <p>Computer Science Department • November 15-17, 2023</p>
                    </div>
                    
                    <div class="feedback-content">
                        "The conference was incredibly well-organized with excellent speakers from the industry. The workshops were hands-on and very informative. I particularly enjoyed the AI and machine learning sessions. The networking opportunities were fantastic - I made several valuable connections. Looking forward to next year's event!"
                    </div>
                    
                    <div class="feedback-tags">
                        <span class="feedback-tag">Well-Organized</span>
                        <span class="feedback-tag">Informative</span>
                        <span class="feedback-tag">Networking</span>
                        <span class="feedback-tag">Technical</span>
                    </div>
                    
                    <div class="feedback-actions">
                        <button class="btn btn-sm btn-outline-primary reply-btn">
                            <i class="bi bi-reply me-1"></i> Reply
                        </button>
                        <button class="btn btn-sm btn-outline-success mark-read-btn">
                            <i class="bi bi-check-circle me-1"></i> Mark as Read
                        </button>
                        <button class="btn btn-sm btn-outline-warning">
                            <i class="bi bi-flag me-1"></i> Flag
                        </button>
                        <button class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash me-1"></i>
                        </button>
                    </div>
                    
                    <!-- Reply Section -->
                    <div class="reply-section" id="replySection1">
                        <div class="reply-header">
                            <i class="bi bi-reply"></i>
                            <span>Reply to John Davis</span>
                        </div>
                        <textarea class="form-control mb-2" rows="3" placeholder="Type your response here..."></textarea>
                        <div class="d-flex justify-content-end gap-2">
                            <button class="btn btn-sm btn-outline-secondary cancel-reply-btn">
                                Cancel
                            </button>
                            <button class="btn btn-sm btn-primary send-reply-btn">
                                Send Reply
                            </button>
                        </div>
                    </div>
                </div>
                
                <!-- Feedback Card 2 -->
                <div class="feedback-card positive">
                    <div class="feedback-header-row">
                        <div class="feedback-user">
                            <div class="user-avatar-small">
                                SJ
                            </div>
                            <div class="user-info">
                                <h6>Sarah Johnson</h6>
                                <p>Faculty Member</p>
                            </div>
                        </div>
                        
                        <div class="feedback-meta">
                            <div class="feedback-rating">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star-half"></i>
                                <span class="ms-2">4.5</span>
                            </div>
                            <div class="feedback-date">
                                <i class="bi bi-calendar me-1"></i> October 16, 2023
                            </div>
                        </div>
                    </div>
                    
                    <div class="feedback-event">
                        <h6>Research Symposium</h6>
                        <p>Natural Sciences Department • October 12-13, 2023</p>
                    </div>
                    
                    <div class="feedback-content">
                        "Great platform for researchers to share their work. The quality of presentations was excellent, and the interdisciplinary discussions were very productive. Suggestion: Consider having more time for Q&A sessions as some presentations ran over time. Overall, a very well-organized event that fostered meaningful academic exchange."
                    </div>
                    
                    <div class="feedback-tags">
                        <span class="feedback-tag">Academic</span>
                        <span class="feedback-tag">Research</span>
                        <span class="feedback-tag">Productive</span>
                        <span class="feedback-tag">Suggestions</span>
                    </div>
                    
                    <!-- Response Card -->
                    <div class="response-card">
                        <div class="response-header">
                            <div class="response-author">
                                <i class="bi bi-person-circle me-1"></i> Dr. Michael Chen (Event Coordinator)
                            </div>
                            <div class="response-date">
                                October 17, 2023
                            </div>
                        </div>
                        <div class="response-content">
                            Thank you for your valuable feedback, Sarah! We appreciate your suggestion about extending Q&A time. We'll definitely consider this for future symposiums. We're glad you found the event productive and hope to see you again next year!
                        </div>
                    </div>
                    
                    <div class="feedback-actions">
                        <button class="btn btn-sm btn-outline-primary reply-btn">
                            <i class="bi bi-reply me-1"></i> Add Reply
                        </button>
                        <button class="btn btn-sm btn-outline-success">
                            <i class="bi bi-check-circle me-1"></i> Mark as Resolved
                        </button>
                    </div>
                </div>
                
                <!-- Feedback Card 3 -->
                <div class="feedback-card negative">
                    <div class="feedback-header-row">
                        <div class="feedback-user">
                            <div class="user-avatar-small">
                                MR
                            </div>
                            <div class="user-info">
                                <h6>Michael Rodriguez</h6>
                                <p>Engineering Student</p>
                            </div>
                        </div>
                        
                        <div class="feedback-meta">
                            <div class="feedback-rating">
                                <i class="bi bi-star-fill"></i>
                                <i class="bi bi-star"></i>
                                <i class="bi bi-star"></i>
                                <i class="bi bi-star"></i>
                                <i class="bi bi-star"></i>
                                <span class="ms-2">1.0</span>
                            </div>
                            <div class="feedback-date">
                                <i class="bi bi-calendar me-1"></i> October 14, 2023
                            </div>
                        </div>
                    </div>
                    
                    <div class="feedback-event">
                        <h6>Sports Festival</h6>
                        <p>Student Affairs • October 7-8, 2023</p>
                    </div>
                    
                    <div class="feedback-content">
                        "Extremely disappointed with the organization. The schedule was constantly changing, equipment was inadequate, and communication was poor. Many events started late or were cancelled without proper notice. The medical tent was understaffed when there was an injury. This needs significant improvement for future events."
                    </div>
                    
                    <div class="feedback-tags">
                        <span class="feedback-tag">Organization</span>
                        <span class="feedback-tag">Communication</span>
                        <span class="feedback-tag">Safety</span>
                        <span class="feedback-tag">Needs Improvement</span>
                    </div>
                    
                    <div class="feedback-actions">
                        <button class="btn btn-sm btn-outline-primary reply-btn">
                            <i class="bi bi-reply me-1"></i> Reply
                        </button>
                        <button class="btn btn-sm btn-outline-warning">
                            <i class="bi bi-flag me-1"></i> Flag for Follow-up
                        </button>
                        <button class="btn btn-sm btn-outline-danger">
                            <i class="bi bi-trash me-1"></i>
                        </button>
                    </div>
                </div>
            </div>
            
            <!-- Pagination -->
            <div class="pagination-container">
                <div class="text-muted">
                    Showing 1-3 of 142 feedback entries
                </div>
                <nav>
                    <ul class="pagination mb-0">
                        <li class="page-item disabled">
                            <a class="page-link" href="#">
                                <i class="bi bi-chevron-left"></i>
                            </a>
                        </li>
                        <li class="page-item active"><a class="page-link" href="#">1</a></li>
                        <li class="page-item"><a class="page-link" href="#">2</a></li>
                        <li class="page-item"><a class="page-link" href="#">3</a></li>
                        <li class="page-item"><a class="page-link" href="#">4</a></li>
                        <li class="page-item"><a class="page-link" href="#">5</a></li>
                        <li class="page-item">
                            <a class="page-link" href="#">
                                <i class="bi bi-chevron-right"></i>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        
        <!-- Footer -->
     	<?php include_once("footer.php");  ?>
			
    </div>

    <!-- Send Survey Modal -->
    <div class="modal fade" id="sendSurveyModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Send Feedback Survey</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Select Event</label>
                        <select class="form-select">
                            <option>Tech Conference 2023</option>
                            <option>Research Symposium</option>
                            <option>Sports Festival</option>
                            <option>Cultural Festival</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Survey Type</label>
                        <select class="form-select">
                            <option>Post-Event Satisfaction</option>
                            <option>Speaker Feedback</option>
                            <option>Venue & Logistics</option>
                            <option>Overall Experience</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Recipients</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="allAttendees" checked>
                            <label class="form-check-label" for="allAttendees">
                                All Event Attendees
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="speakersOnly">
                            <label class="form-check-label" for="speakersOnly">
                                Speakers & Presenters Only
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="volunteersOnly">
                            <label class="form-check-label" for="volunteersOnly">
                                Volunteers & Staff Only
                            </label>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Custom Message (Optional)</label>
                        <textarea class="form-control" rows="3" placeholder="Add a personal message to the survey email..."></textarea>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label">Schedule Survey</label>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="scheduleOption" id="sendNow" checked>
                            <label class="form-check-label" for="sendNow">
                                Send immediately
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="scheduleOption" id="scheduleLater">
                            <label class="form-check-label" for="scheduleLater">
                                Schedule for later
                            </label>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary">Send Survey</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JavaScript -->
    <script>
        // Sidebar toggle
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            document.getElementById('sidebar').classList.toggle('active');
            document.getElementById('content').classList.toggle('active');
        });
        
        // Initialize Chart.js
        const ctx = document.getElementById('feedbackTrendsChart').getContext('2d');
        const feedbackTrendsChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Week 1', 'Week 2', 'Week 3', 'Week 4', 'Week 5', 'Week 6'],
                datasets: [{
                    label: 'Feedback Received',
                    data: [12, 19, 15, 25, 22, 30],
                    borderColor: '#1a73e8',
                    backgroundColor: 'rgba(26, 115, 232, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }, {
                    label: 'Average Rating',
                    data: [4.2, 4.5, 4.3, 4.7, 4.6, 4.8],
                    borderColor: '#00c853',
                    backgroundColor: 'rgba(0, 200, 83, 0.1)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 35,
                        ticks: {
                            stepSize: 5
                        }
                    }
                }
            }
        });
        
        // Reply functionality
        document.querySelectorAll('.reply-btn').forEach(button => {
            button.addEventListener('click', function() {
                const card = this.closest('.feedback-card');
                const replySection = card.querySelector('.reply-section');
                replySection.classList.toggle('active');
                
                // Scroll to reply section
                if (replySection.classList.contains('active')) {
                    replySection.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
                }
            });
        });
        
        // Cancel reply
        document.querySelectorAll('.cancel-reply-btn').forEach(button => {
            button.addEventListener('click', function() {
                const replySection = this.closest('.reply-section');
                replySection.classList.remove('active');
            });
        });
        
        // Send reply
        document.querySelectorAll('.send-reply-btn').forEach(button => {
            button.addEventListener('click', function() {
                const replySection = this.closest('.reply-section');
                const textarea = replySection.querySelector('textarea');
                const message = textarea.value.trim();
                
                if (message) {
                    // In a real app, this would send to backend
                    alert('Reply sent successfully!');
                    textarea.value = '';
                    replySection.classList.remove('active');
                    
                    // Mark as responded
                    const card = replySection.closest('.feedback-card');
                    card.classList.remove('unread');
                    card.classList.add('positive');
                } else {
                    alert('Please enter a reply message');
                }
            });
        });
        
        // Mark as read
        document.querySelectorAll('.mark-read-btn').forEach(button => {
            button.addEventListener('click', function() {
                const card = this.closest('.feedback-card');
                card.classList.remove('unread');
                
                // Update unread count
                const unreadCount = document.querySelectorAll('.feedback-card.unread').length;
                document.querySelector('.badge-notification').textContent = unreadCount;
                
                // Update stats card
                document.querySelectorAll('.stat-card')[2].querySelector('h4').textContent = unreadCount;
                
                alert('Marked as read');
            });
        });
        
        // Filter functionality
        document.getElementById('applyFiltersBtn').addEventListener('click', function() {
            const eventFilter = document.getElementById('filterEvent').value;
            const ratingFilter = document.getElementById('filterRating').value;
            const statusFilter = document.getElementById('filterStatus').value;
            
            // In a real app, this would filter from backend
            alert(`Filters applied:\nEvent: ${eventFilter || 'All'}\nRating: ${ratingFilter || 'All'}\nStatus: ${statusFilter || 'All'}`);
        });
        
        document.getElementById('clearFiltersBtn').addEventListener('click', function() {
            document.getElementById('filterEvent').value = '';
            document.getElementById('filterRating').value = '';
            document.getElementById('filterStatus').value = '';
            document.getElementById('filterDate').value = '';
            alert('Filters cleared');
        });
        
        // Export feedback
        document.getElementById('exportFeedbackBtn').addEventListener('click', function() {
            alert('Exporting feedback data...');
            // In a real app, this would generate and download CSV/Excel
        });
        
        // Initialize unread count badge
        const unreadCount = document.querySelectorAll('.feedback-card.unread').length;
        document.querySelector('.badge-notification').textContent = unreadCount;
    </script>
</body>
</html>