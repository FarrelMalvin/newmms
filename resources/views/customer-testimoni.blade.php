<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- viewport: checked responsive -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/customer-testimoni.css') }}">
    <link rel="stylesheet" href="{{ asset('css/customer-dashboard.css') }}">
    <title>Customer - Testimonials</title>
</head>
<body>
    <div class="dashboard-container">
        <div class="sidebar">
            <div class="logo-section">
                <div class="logo">
                    <span>MMS - Customer Dashboard</span>
                </div>
            </div>
            
            <nav class="nav-menu">
                <a href="/customer/dashboard" class="nav-item">
                    <span>Home</span>
                </a>
                <a href="/customer/product" class="nav-item">
                    <span>Products</span>
                </a>
                <a href="/service" class="nav-item">
                    <span>Book Service</span>
                </a>
                <a href="/service/history" class="nav-item">
                    <span>Service History</span>
                </a>
                <a href="/customer/testimoni" class="nav-item active">
                    <span>Testimonials</span>
                </a>
            </nav>
            
            <div class="logout-section">
                <button onclick="performLogout()" class="logout-btn" style="background: none; border: none; cursor: pointer; display: flex; align-items: center; gap: 0.5rem; color: inherit; text-decoration: none; width: 100%; padding: 0.75rem 1rem; border-radius: 0.5rem; transition: background-color 0.2s;">
                    <span class="nav-icon">🚪</span>
                    <span>Log Out</span>
                </button>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <header class="header">
                <h1>Testimonials</h1>
                <div class="header-right">
                    <button class="btn btn-primary" onclick="showAddTestimoniModal()">
                        <span>+</span> Add Testimonial
                    </button>
                    <div class="user-profile">
                        <span>{{ Auth::user()->nama ?? 'Customer' }}</span>
                    </div>
                </div>
            </header>

            <div class="content-wrapper">
                <!-- My Testimonials Section -->
                <div class="section">
                    <h2>My Testimonials</h2>
                    <div id="myTestimonials" class="testimonials-grid">
                        <!-- My testimonials will be loaded here -->
                    </div>
                </div>

                <!-- All Testimonials Section -->
                <div class="section">
                    <h2>All Testimonials</h2>
                    <div class="filter-section">
                        <div class="search-container">
                            <input type="text" id="searchTestimoni" placeholder="Search testimonials..." class="search-input">
                        </div>
                        <div class="filter-container">
                            <select name="filterRating" id="filterRating" class="filter-select">
                                <option value="">All Ratings</option>
                                <option value="5">5 Stars</option>
                                <option value="4">4 Stars</option>
                                <option value="3">3 Stars</option>
                                <option value="2">2 Stars</option>
                                <option value="1">1 Star</option>
                            </select>
                        </div>
                    </div>
                    <div id="allTestimonials" class="testimonials-grid">
                        <!-- All testimonials will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add Testimonial Modal -->
    <div id="addTestimoniModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Add New Testimonial</h3>
                <span class="close" onclick="closeModal()">&times;</span>
            </div>
            <form id="addTestimoniForm">
                <div class="form-group">
                    <label for="service_info">Service Information</label>
                    <div id="service_info" class="service-info-display">
                        <!-- Service info will be loaded here -->
                    </div>
                </div>
                <div class="form-group">
                    <label for="isi_testimoni">Your Review</label>
                    <textarea id="isi_testimoni" name="isi_testimoni" required maxlength="1000" placeholder="Share your experience with our service..."></textarea>
                    <small class="char-count">0/1000 characters</small>
                </div>
                <div class="form-group">
                    <label for="rating_bintang">Rating</label>
                    <div class="rating-container">
                        <div class="stars">
                            <span class="star" data-rating="1">☆</span>
                            <span class="star" data-rating="2">☆</span>
                            <span class="star" data-rating="3">☆</span>
                            <span class="star" data-rating="4">☆</span>
                            <span class="star" data-rating="5">☆</span>
                        </div>
                        <input type="hidden" id="rating_bintang" name="rating_bintang" value="0" required>
                    </div>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Submit Testimonial</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let currentServiceId = null;

        // Load testimonials on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadAllTestimonials();
            loadMyTestimonials();
        });

        // Load all testimonials
        function loadAllTestimonials() {
            fetch('/testimoni')
                .then(response => response.json())
                .then(data => {
                    if (data.testimoni) {
                        displayTestimonials(data.testimoni, 'allTestimonials');
                    }
                })
                .catch(error => {
                    console.error('Error loading testimonials:', error);
                });
        }

        // Load my testimonials
        function loadMyTestimonials() {
            fetch('/testimoni')
                .then(response => response.json())
                .then(data => {
                    if (data.testimoni) {
                        const myTestimonials = data.testimoni.filter(t => t.id_pengguna == {{ Auth::user()->id_pengguna ?? 'null' }});
                        displayTestimonials(myTestimonials, 'myTestimonials');
                    }
                })
                .catch(error => {
                    console.error('Error loading my testimonials:', error);
                });
        }

        // Display testimonials
        function displayTestimonials(testimonials, containerId) {
            const container = document.getElementById(containerId);
            
            if (testimonials.length === 0) {
                container.innerHTML = `
                    <div class="empty-state">
                        <div class="empty-icon">📝</div>
                        <h3>No testimonials found</h3>
                        <p>${containerId === 'myTestimonials' ? 'You haven\'t submitted any testimonials yet.' : 'No testimonials available at the moment.'}</p>
                    </div>
                `;
                return;
            }

            container.innerHTML = testimonials.map(testimoni => `
                <div class="testimonial-card">
                    <div class="card-header">
                        <div class="customer-profile">
                            <img src="https://ui-avatars.com/api/?name=${testimoni.pengguna?.nama || 'Unknown'}&background=eeeeee&color=141414&size=48" alt="Profile" class="customer-avatar">
                            <div class="customer-details">
                                <h4 class="customer-name">${testimoni.pengguna?.nama || 'Unknown Customer'}</h4>
                                <p class="customer-type">Verified Customer</p>
                            </div>
                        </div>
                        ${testimoni.menyoroti === 'true' ? '<span class="highlight-badge">Featured</span>' : ''}
                    </div>

                    <div class="rating-section">
                        <div class="stars">
                            ${generateStars(testimoni.rating_bintang)}
                        </div>
                    </div>

                    <div class="testimonial-content">
                        <p class="testimonial-text">${testimoni.isi_testimoni}</p>
                    </div>

                    <div class="testimonial-meta">
                        <small>Service ID: ${testimoni.id_service}</small>
                    </div>
                </div>
            `).join('');
        }

        // Generate star rating display
        function generateStars(rating) {
            let stars = '';
            for (let i = 1; i <= 5; i++) {
                stars += `<span class="star ${i <= rating ? 'filled' : ''}">${i <= rating ? '★' : '☆'}</span>`;
            }
            return stars;
        }

        // Show add testimonial modal
        function showAddTestimoniModal() {
            // Get valid service first
            fetch('/testimoni/valid-service')
                .then(response => response.json())
                .then(data => {
                    if (data.id_service) {
                        currentServiceId = data.id_service;
                        document.getElementById('service_info').innerHTML = `
                            <div class="service-details">
                                <p><strong>Service ID:</strong> ${data.id_service}</p>
                                <p><strong>Date:</strong> ${data.service_details?.tanggal || 'N/A'}</p>
                                <p><strong>Issue:</strong> ${data.service_details?.keluhan || 'N/A'}</p>
                                <p><strong>Status:</strong> ${data.service_details?.status || 'N/A'}</p>
                                <p><strong>Completed:</strong> ${data.service_details?.finished_at || 'N/A'}</p>
                            </div>
                        `;
                        document.getElementById('addTestimoniModal').style.display = 'block';
                    } else {
                        alert(data.message || 'No valid service found for testimonial');
                    }
                })
                .catch(error => {
                    console.error('Error getting valid service:', error);
                    alert('Error getting service information');
                });
        }

        // Close modal
        function closeModal() {
            document.getElementById('addTestimoniModal').style.display = 'none';
            document.getElementById('addTestimoniForm').reset();
            document.getElementById('rating_bintang').value = '0';
            resetStars();
        }

        // Star rating functionality
        document.addEventListener('DOMContentLoaded', function() {
            const stars = document.querySelectorAll('.star[data-rating]');
            const ratingInput = document.getElementById('rating_bintang');

            stars.forEach(star => {
                star.addEventListener('click', function() {
                    const rating = this.getAttribute('data-rating');
                    ratingInput.value = rating;
                    updateStars(rating);
                });

                star.addEventListener('mouseenter', function() {
                    const rating = this.getAttribute('data-rating');
                    updateStars(rating);
                });
            });

            const starsContainer = document.querySelector('.stars');
            starsContainer.addEventListener('mouseleave', function() {
                const currentRating = ratingInput.value;
                updateStars(currentRating);
            });
        });

        function updateStars(rating) {
            const stars = document.querySelectorAll('.star[data-rating]');
            stars.forEach(star => {
                const starRating = star.getAttribute('data-rating');
                if (starRating <= rating) {
                    star.textContent = '★';
                    star.classList.add('filled');
                } else {
                    star.textContent = '☆';
                    star.classList.remove('filled');
                }
            });
        }

        function resetStars() {
            const stars = document.querySelectorAll('.star[data-rating]');
            stars.forEach(star => {
                star.textContent = '☆';
                star.classList.remove('filled');
            });
        }

        // Character count for testimonial text
        document.getElementById('isi_testimoni').addEventListener('input', function() {
            const charCount = this.value.length;
            document.querySelector('.char-count').textContent = `${charCount}/1000 characters`;
        });

        // Submit testimonial form
        document.getElementById('addTestimoniForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (document.getElementById('rating_bintang').value === '0') {
                alert('Please select a rating');
                return;
            }

            const formData = {
                id_pengguna: {{ Auth::user()->id_pengguna ?? 'null' }},
                id_service: currentServiceId,
                isi_testimoni: document.getElementById('isi_testimoni').value,
                menyoroti: 'false', // Default to false for customer submissions
                rating_bintang: parseInt(document.getElementById('rating_bintang').value)
            };

            fetch('/testimoni', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData)
            })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    alert(data.message);
                    if (data.message.includes('sukses')) {
                        closeModal();
                        loadAllTestimonials();
                        loadMyTestimonials();
                    }
                }
            })
            .catch(error => {
                console.error('Error submitting testimonial:', error);
                alert('Error submitting testimonial');
            });
        });

        // Search and filter functionality
        document.getElementById('searchTestimoni').addEventListener('input', function() {
            applyFilters();
        });

        document.getElementById('filterRating').addEventListener('change', function() {
            applyFilters();
        });

        // Logout function
        function performLogout() {
            // Create a form dynamically
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("logout") }}';
            
            // Add CSRF token
            var csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            form.appendChild(csrfToken);
            
            // Submit the form
            document.body.appendChild(form);
            form.submit();
        }

        function applyFilters() {
            const searchTerm = document.getElementById('searchTestimoni').value.toLowerCase();
            const filterRating = document.getElementById('filterRating').value;
            const cards = document.querySelectorAll('#allTestimonials .testimonial-card');
            
            cards.forEach(card => {
                const text = card.textContent.toLowerCase();
                const matchesSearch = text.includes(searchTerm);
                
                let matchesFilter = true;
                if (filterRating) {
                    const stars = card.querySelectorAll('.star.filled').length;
                    matchesFilter = stars == filterRating;
                }
                
                card.style.display = matchesSearch && matchesFilter ? 'block' : 'none';
            });
        }
    </script>
</body>
</html> 