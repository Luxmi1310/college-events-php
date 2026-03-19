// all events 

document.addEventListener('DOMContentLoaded', function() {
    
    // --- 1. SIDEBAR TOGGLE ---
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.getElementById('sidebar'); // Ensure your sidebar has this ID
    const content = document.getElementById('content');

    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('active');
            content.classList.toggle('active');
        });
    }

    // --- 2. FILTERING LOGIC ---
    const filterType = document.getElementById('eventType');
    const filterDept = document.getElementById('eventDepartment');
    const filterStatus = document.getElementById('eventStatus');
    const applyBtn = document.getElementById('applyFilters');
    const resetBtn = document.getElementById('resetFilters');
    const clearLink = document.getElementById('clearFilters');

    function filterEvents() {
        const typeValue = filterType.value.toLowerCase();
        const deptValue = filterDept.value.toLowerCase();
        const statusValue = filterStatus.value.toLowerCase();
        
        const cards = document.querySelectorAll('.event-card');

        cards.forEach(card => {
            // Get data from the card
            const cardType = card.querySelector('.badge-category').innerText.toLowerCase();
            const cardStatus = card.querySelector('.status-pill').innerText.toLowerCase();
            const cardVenue = card.querySelector('.bi-geo-alt').nextElementSibling.innerText.toLowerCase();

            // Check if card matches filters
            const matchesType = typeValue === "" || cardType.includes(typeValue);
            const matchesStatus = statusValue === "" || cardStatus.includes(statusValue);
            const matchesDept = deptValue === "" || cardVenue.includes(deptValue);

            // Show or Hide
            if (matchesType && matchesStatus && matchesDept) {
                card.style.display = "block";
                card.style.animation = "fadeIn 0.3s ease";
            } else {
                card.style.display = "none";
            }
        });
    }

    // --- 3. EVENT LISTENERS ---

    // Apply Filters Button
    if (applyBtn) {
        applyBtn.addEventListener('click', filterEvents);
    }

    // Reset Buttons (both the button and the "Clear All" link)
    [resetBtn, clearLink].forEach(btn => {
        if (btn) {
            btn.addEventListener('click', function() {
                filterType.value = "";
                filterDept.value = "";
                filterStatus.value = "";
                filterEvents(); // Refresh view
            });
        }
    });

});
document.addEventListener('DOMContentLoaded', function() {
    // Select sections and progress steps
    const step1 = document.getElementById('step1Section');
    const step2 = document.getElementById('step2Section');
    const step4 = document.getElementById('step4Section'); // Your Preview section
    const steps = document.querySelectorAll('.step');

    // --- Navigation Logic ---

    // Next: Step 1 -> Step 2
    document.getElementById('nextToStep2').onclick = () => {
        step1.classList.remove('active');
        step2.classList.add('active');
        steps[1].classList.add('active');
        steps[0].classList.add('completed');
    };

    // Next: Step 2 -> Step 3 (Preview)
    document.getElementById('nextToStep3').onclick = () => {
        updatePreview();
        step2.classList.remove('active');
        step4.classList.add('active'); // Goes to your id="step4Section"
        steps[2].classList.add('active');
        steps[1].classList.add('completed');
    };

    // Back Buttons
    document.getElementById('backToStep1').onclick = () => {
        step2.classList.remove('active');
        step1.classList.add('active');
        steps[1].classList.remove('active');
    };

    document.getElementById('backToStep3').onclick = () => {
        step4.classList.remove('active');
        step2.classList.add('active');
        steps[2].classList.remove('active');
    };

    // --- Image Upload & Preview Logic ---
    const imageInput = document.getElementById('eventImage');
    const uploadArea = document.getElementById('imageUploadArea');
    const previewImg = document.getElementById('previewImage');
    const previewDiv = document.getElementById('imagePreview');

    uploadArea.onclick = () => imageInput.click();

    imageInput.onchange = function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                previewImg.src = e.target.result;
                previewDiv.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    };

    // --- Event Preview Update ---
   function updatePreview() {
    const title = document.getElementById('eventTitle').value;
    const type = document.getElementById('eventType').value;
    const venue = document.getElementById('eventVenue').value;
    const start = document.getElementById('startDateTime').value;
    const desc = document.getElementById('eventDescription').value;
    
    // Get the image source from the upload preview
    const imageSrc = document.getElementById('previewImage').src;
    const hasImage = document.getElementById('imagePreview').style.display !== 'none';

    const previewContainer = document.getElementById('eventPreview');
    
    previewContainer.innerHTML = `
        <div class="card border-0 shadow-sm overflow-hidden">
            ${hasImage ? `<img src="${imageSrc}" class="card-img-top" style="height: 200px; object-fit: cover;" alt="Event Banner">` : 
            `<div class="bg-light text-center py-5 border-bottom"><i class="bi bi-image text-muted" style="font-size: 3rem;"></i><p>No banner uploaded</p></div>`}
            
            <div class="card-body">
                <div class="d-flex justify-content-between align-items-start mb-2">
                    <span class="badge bg-primary text-capitalize">${type || 'Event'}</span>
                    <small class="text-muted"><i class="bi bi-calendar-event me-1"></i> ${start ? new Date(start).toLocaleString() : 'Date not set'}</small>
                </div>
                <h4 class="card-title fw-bold">${title || 'Untitled Event'}</h4>
                <p class="text-muted mb-3"><i class="bi bi-geo-alt-fill me-1"></i> ${venue || 'Venue not selected'}</p>
                <hr>
                <h6>Description</h6>
                <p class="card-text small text-secondary">${desc || 'No description provided.'}</p>
            </div>
        </div>
    `;
}

    // --- Final Submission (Uploads) ---
    document.getElementById('publishEventBtn').onclick = function() {
        if (!document.getElementById('termsAgreement').checked) {
            alert("Please agree to the terms and conditions.");
            return;
        }

        const formData = new FormData();
        
        // Append all fields manually to match your PHP keys
        formData.append('title', document.getElementById('eventTitle').value);
        formData.append('type', document.getElementById('eventType').value);
        formData.append('description', document.getElementById('eventDescription').value);
        formData.append('start_date', document.getElementById('startDateTime').value);
        formData.append('end_date', document.getElementById('endDateTime').value);
        formData.append('registration_deadline', document.getElementById('registrationDeadline').value);
        formData.append('venue', document.getElementById('eventVenue').value);
        formData.append('capacity', document.getElementById('eventCapacity').value);
        
        // Append the image file
        if (imageInput.files[0]) {
            formData.append('event_image', imageInput.files[0]);
        }

        // Send to PHP
        fetch('save_event.php', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                document.querySelector('.create-event-container').innerHTML = 
                    document.getElementById('successMessage').innerHTML;
            } else {
                alert("Error: " + data.message);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert("Failed to connect to the server.");
        });
    };
});