let slideIndex = 1;

window.onload = function() {
    showSlides(slideIndex); // Initialize the slides

    // Login modal handling
    const modal = document.getElementById('loginModal');
    const btn = document.getElementById('loginBtn');
    const span = document.getElementsByClassName('close')[0];

    btn.onclick = function() {
        console.log("Login button clicked"); // For debugging
        modal.style.display = 'block'; // Open modal
    }

    span.onclick = function() {
        modal.style.display = 'none'; // Close modal
    }

    window.onclick = function(event) {
        if (event.target === modal) {
            modal.style.display = 'none'; // Close modal
        }
    }
}

// Slide show functionality
function plusSlides(n) {
    showSlides(slideIndex += n);
}

function showSlides(n) {
    let slides = document.getElementsByClassName("myBanner");
    if (n > slides.length) slideIndex = 1;
    if (n < 1) slideIndex = slides.length;
    
    for (let i = 0; i < slides.length; i++) {
        slides[i].style.display = "none"; // Hide all slides
    }
    slides[slideIndex - 1].style.display = "block"; // Show current slide
}

// Fetch reservations when the button is clicked
document.getElementById('myReservationsBtn').addEventListener('click', fetchReservations);

function fetchReservations() {
    fetch('fetch_reservations.php')
        .then(response => response.json())
        .then(data => {
            const container = document.getElementById('reservationsContainer');
            container.innerHTML = ''; // Clear previous data
            data.forEach(reservation => {
                const block = document.createElement('div');
                block.className = 'reservation-block';
                block.innerHTML = `
                    <p><strong>Name:</strong> ${reservation.name}</p>
                    <p><strong>Guests:</strong> ${reservation.guests}</p>
                    <p><strong>Restaurant:</strong> ${reservation.restaurant}</p>
                    <p><strong>Date:</strong> ${reservation.reservation_date}</p>
                    <p><strong>Time:</strong> ${reservation.reservation_time}</p>
                    <button class="delete-btn" data-id="${reservation.id}">Delete</button>
                    <button class="update-btn" onclick="redirectToUpdateForm(${reservation.id})">Update</button>
                `;
                container.appendChild(block);
            });
            attachDeleteHandlers(container); // Attach delete button handlers
            document.getElementById('reservationsModal').style.display = 'block'; // Show modal
        })
        .catch(error => console.error('Error fetching reservations:', error));
}

function attachDeleteHandlers(container) {
    const deleteButtons = container.querySelectorAll('.delete-btn');
    deleteButtons.forEach(button => {
        button.addEventListener('click', function() {
            const reservationId = this.getAttribute('data-id');
            deleteReservation(reservationId);
        });
    });
}

function closeModal() {
    document.getElementById('reservationsModal').style.display = 'none';
}

function deleteReservation(id) {
    if (confirm('Are you sure you want to delete this reservation?')) {
        fetch('delete_reservation.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: new URLSearchParams({ 'id': id })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Reservation deleted successfully!');
                fetchReservations(); // Refresh the reservations list
            } else {
                alert('Error deleting reservation: ' + data.error);
            }
        })
        .catch(error => console.error('Error deleting reservation:', error));
    }
}

function redirectToUpdateForm(reservationId) {
    window.location.href = `add_reservation.php?id=${reservationId}`;
}
document.getElementById('myReservationsBtn').addEventListener('click', function() {
    console.log("Fetching reservations..."); // Log when the button is clicked
    fetchReservations();
});