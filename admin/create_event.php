<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CampusEvents Pro | Create Event</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">
    <!-- Flatpickr for date picker -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="css/style.css">
</head>
	<style>
		/* Hide all sections by default */
.form-section {
    display: none;
}

/* Only show the section that has the .active class */
.form-section.active {
    display: block;
    animation: fadeIn 0.3s ease-in-out;
}

/* Keep the progress steps horizontal */
.create-steps {
    display: flex;
    justify-content: space-between;
    margin-bottom: 30px;
}

.step {
    flex: 1;
    text-align: center;
    color: #ccc;
}

.step.active { color: #0d6efd; font-weight: bold; }
.step.completed { color: #198754; }

@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}
#eventPreview .card {
    transition: transform 0.2s;
    border-radius: 12px;
}

#eventPreview .card-title {
    color: #2c3e50;
}

.preview-section {
    background-color: #f1f3f5; /* Light grey background to make the white card pop */
}
	</style>
<body>
    <?php include_once("leftbar.php"); ?>
    <div id="content">
        <div class="main-content">
            <div class="create-event-container">
                <div class="create-steps">
                    <div class="step active">
                        <div class="step-circle">1</div>
                        <div class="step-label">Basic Info</div>
                    </div>
                    <div class="step">
                        <div class="step-circle">2</div>
                        <div class="step-label">Event Details</div>
                    </div>
                    <div class="step">
                        <div class="step-circle">3</div>
                        <div class="step-label">Preview</div>
                    </div>
                </div>
                <div class="form-section active" id="step1Section">
                    <div class="section-header">
                        <h3>Event Basic Details</h3>
                        <p>Provide the fundamental information about your event</p>
                    </div>
                    <form id="basicDetailsForm">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="eventTitle" class="form-label">Event Title <span class="required">*</span></label>
                                <input type="text" class="form-control" id="eventTitle" placeholder="Enter event title" required>
                                <div class="form-text">Choose a clear and engaging title that describes your event</div>
                            </div>
                            <div class="form-group">
                                <label for="eventType" class="form-label">Event Type <span class="required">*</span></label>
                                <select class="form-select" id="eventType" required>
                                    <option value="">Select event type</option>
                                    <option value="conference">Conference</option>
                                    <option value="workshop">Workshop</option>
                                    <option value="seminar">Seminar</option>
                                    <option value="lecture">Guest Lecture</option>
                                    <option value="festival">Festival</option>
                                    <option value="sports">Sports Event</option>
                                    <option value="social">Social Gathering</option>
                                    <option value="other">Other</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group mt-3">
                            <label for="eventDescription" class="form-label">Event Description <span class="required">*</span></label>
                            <textarea class="form-textarea" id="eventDescription" placeholder="Describe your event in detail..." rows="3" required></textarea>
                            <div class="form-text">Include agenda, objectives, and speakers</div>
                        </div>
                        <div class="form-group mt-3">
                            <label class="form-label">Event Banner Image</label>
                            <div class="file-upload-area" id="imageUploadArea" style="cursor: pointer;">
                                <div class="file-upload-icon"><i class="bi bi-cloud-arrow-up"></i></div>
                                <div class="file-upload-text">
                                    <h5>Click to upload banner image</h5>
                                    <p class="text-muted">PNG, JPG up to 5MB</p>
                                </div>
                                <input type="file" id="eventImage" accept="image/*" style="display: none;">
                            </div>
                            <div class="file-preview mt-3" id="imagePreview" style="display: none;">
                                <img id="previewImage" src="" alt="Preview" class="img-fluid rounded border" style="max-height: 200px;">
                            </div>
                        </div>
                    </form>
                    <div class="form-actions mt-4">
                        <button type="button" class="btn btn-outline-secondary" disabled>
                            <i class="bi bi-arrow-left me-2"></i> Previous
                        </button>
                        <button type="button" class="btn btn-primary" id="nextToStep2">
                            Next: Schedule & Venue <i class="bi bi-arrow-right ms-2"></i>
                        </button>
                    </div>
                </div>
                <div class="form-section" id="step2Section">
                    <div class="section-header">
                        <h3>Schedule & Venue Details</h3>
                        <p>Set the date, time, and location for your event</p>
                    </div>
                    <form id="scheduleForm">
                        <div class="form-row">
                            <div class="form-group">
                                <label for="startDateTime" class="form-label">Start Date & Time <span class="required">*</span></label>
                                <input type="datetime-local" class="form-control" id="startDateTime" required>
                            </div>
                            <div class="form-group">
                                <label for="endDateTime" class="form-label">End Date & Time <span class="required">*</span></label>
                                <input type="datetime-local" class="form-control" id="endDateTime" required>
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="form-group">
                                <label class="form-label">Event Duration</label>
                                <div class="form-control" id="durationDisplay" style="background-color: #f8f9fa;">Calculating...</div>
                            </div>
                            <div class="form-group">
                                <label for="registrationDeadline" class="form-label">Registration Deadline</label>
                                <input type="datetime-local" class="form-control" id="registrationDeadline">
                            </div>
                        </div>
                        <div class="form-row mt-3">
                            <div class="form-group">
                                <label for="eventVenue" class="form-label">Venue <span class="required">*</span></label>
                                <select class="form-select" id="eventVenue" required>
                                    <option value="">Select venue</option>
                                    <option value="Auditorium">Main Auditorium</option>
                                    <option value="Conference Hall A">Conference Hall A</option>
                                    <option value="Library">Library Hall</option>
                                    <option value="Online">Online/Virtual</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="eventCapacity" class="form-label">Maximum Capacity <span class="required">*</span></label>
                                <input type="number" class="form-control" id="eventCapacity" min="1" value="100" required>
                            </div>
                        </div>
                    </form>
                    <div class="form-actions mt-4">
                        <button type="button" class="btn btn-outline-secondary" id="backToStep1">
                            <i class="bi bi-arrow-left me-2"></i> Previous
                        </button>
                        <button type="button" class="btn btn-primary" id="nextToStep3">
                            Next: Review & Preview <i class="bi bi-arrow-right ms-2"></i>
                        </button>
                    </div>
                </div>
                <div class="form-section" id="step4Section">
                    <div class="section-header">
                        <h3>Review & Publish Event</h3>
                        <p>Review all details before publishing your event</p>
                    </div>
                    <div class="preview-section card shadow-sm p-4">
                        <div class="preview-header mb-3">
                            <h4 class="text-primary"><i class="bi bi-eye me-2"></i>Event Preview</h4>
                            <p class="text-muted small">This is how your event will appear to others.</p>
                        </div>
                        <div class="preview-content" id="eventPreview">
                            </div>
                        <div class="preview-note mt-4 p-3 bg-light border-start border-warning border-4">
                            <h5><i class="bi bi-info-circle me-2"></i> Important Note</h5>
                            <p class="mb-0 small">Once published, this event will be visible to students and staff. Major changes might require re-approval.</p>
                        </div>
                        <div class="mt-4">
                            <label class="form-label fw-bold">Publishing Options</label>
                            <div class="radio-group border rounded p-3 bg-white">
                                <div class="form-check mb-2">
                                    <input class="form-check-input" type="radio" name="publishOption" id="publishNow" checked>
                                    <label class="form-check-label" for="publishNow"><strong>Publish immediately</strong></label>
                                </div>
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="publishOption" id="publishLater">
                                    <label class="form-check-label" for="publishLater"><strong>Save as draft</strong></label>
                                </div>
                            </div>
                        </div>
                        <div class="form-check mt-4">
                            <input class="form-check-input" type="checkbox" id="termsAgreement" required>
                            <label class="form-check-label small" for="termsAgreement">
                                I confirm that all information provided is accurate and I have obtained necessary approvals.
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-actions mt-4">
                        <button type="button" class="btn btn-outline-secondary" id="backToStep3">
                            <i class="bi bi-arrow-left me-2"></i> Previous: Details
                        </button>
                        <button type="button" class="btn btn-success px-5" id="publishEventBtn">
                            <i class="bi bi-check-circle me-2"></i> Publish Event
                        </button>
                    </div>
                </div>

                <div class="success-message text-center p-5" id="successMessage" style="display: none;">
                    <div class="success-icon mb-4">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 5rem;"></i>
                    </div>
                    <h3>Event Created Successfully!</h3>
                    <p class="text-muted">Your event is now live on the campus portal.</p>
                    <div class="d-flex justify-content-center gap-3 mt-4">
                        <button type="button" class="btn btn-primary" id="createAnotherBtn"><a href="create_event.php"><span class="text-dark"><b>Create Another Event</b></button></span></a>
                    </div>
                </div>

                <?php include_once("footer.php"); ?>
            </div>
        </div>
    </div>
    <script src="js/javascript.js"></script>
</body>
</html>