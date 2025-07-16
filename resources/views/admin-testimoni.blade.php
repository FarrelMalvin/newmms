<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin-testimoni.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <title>Admin - Testimonials</title>
</head>
<body>
    <div class="dashboard-container">
        <div class="sidebar">
            <div class="logo-section">
                <div class="logo">
                    <span>MMS - Admin Dashboard</span>
                </div>
            </div>
            
            <nav class="nav-menu">
                <a href="/admin/dashboard" class="nav-item">
                    <span>Home</span>
                </a>
                <a href="/admin/testimoni" class="nav-item active">
                    <span>Testimonials</span>
                    <img class="chevron-right" src="/images/chevron-right.png" alt="">
                </a>
                <a href="/admin/produk" class="nav-item">
                    <span>Products</span>
                </a>
                <a href="/admin/booking" class="nav-item">
                    <span>Booking</span>
                </a>
                <a href="/admin/berita" class="nav-item">
                    <span>News</span>
                </a>
            </nav>
            
            <div class="logout-section">
                <a href="/logout" class="logout-btn">
                    <span>Log Out</span>
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <header class="header">
                <h1>Testimonials Management</h1>
                <div class="header-right">
                    
                    <div class="user-profile">
                        <span>{{ Auth::user()->nama ?? 'Admin' }}</span>
                    </div>
                </div>
            </header>

            <div class="content-wrapper">
                <!-- Stats Cards -->
                <div class="stats-section">
                    <div class="stat-card">
                        <div class="stat-content">
                            <div class="stat-label">Total Reviews</div>
                            <div class="stat-value">{{ $testimoni->count() }}</div>
                        </div>
                        <div class="stat-icon blue">⭐</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-content">
                            <div class="stat-label">Highlighted</div>
                            <div class="stat-value">{{ $testimoni->where('menyoroti', "true")->count() }}</div>
                        </div>
                        <div class="stat-icon yellow">⚡</div>
                    </div>
                </div>

                <!-- Search and Filter Section -->
                <div class="filter-section">
                    <div class="search-container">
                        <input type="text" id="searchTestimoni" placeholder="Search testimonials..." class="search-input">
                    </div>
                    <div class="filter-container">
                        <select name="filterStatus" id="filterHighlight" class="filter-select">
                            <option value="">All Statuses</option>
                            <option value="1">Highlighted</option>
                            <option value="0">Regular</option>
                        </select>
                    </div>
                </div>

                <!-- Testimonials Cards -->
                <div class="testimonials-grid">
                    @forelse($testimoni as $item)
                    <div class="testimonial-card">
                        <div class="card-header">
                            <div class="customer-profile">
                                <img src="https://ui-avatars.com/api/?name={{ $item->pengguna->nama ?? 'Unknown' }}&background=eeeeee&color=141414&size=48" alt="Profile" class="customer-avatar">
                                <div class="customer-details">
                                    <h4 class="customer-name">{{ $item->pengguna->nama ?? 'Unknown Customer' }}</h4>
                                    <p class="customer-type">Verified Customer</p>
                                </div>
                            </div>
                            @if($item->menyoroti == "true")
                            <span class="highlight-badge">Highlighted</span>
                            @else
                            <span class="regular-badge">Regular</span>
                            @endif
                        </div>

                        <div class="rating-section">
                            <div class="stars">
                            </div>
                        </div>

                        <div class="testimonial-content">
                            <p class="testimonial-text">{{ $item->isi_testimoni }}</p>
                        </div>

                        <div class="testimonial-meta">
                            <span class="product-service">
                                <strong>{{ $item->service->type_service ?? 'Service' }}:</strong> {{ $item->service->deskripsi ?? 'Premium Service' }}
                            </span>
                           
                        </div>

                        <div class="card-actions">
                            @if($item->menyoroti == "true")
                            <button class="action-btn remove-highlight"onclick="toggleHighlight({{ $item->id_testimoni }}, 'false')" title="Remove Highlight">
                                 Remove Highlight
                            </button>
                            @else
                            <button class="action-btn highlight" onclick="toggleHighlight({{ $item->id_testimoni }}, 'true')" title="Highlight">
                                Highlight
                            </button>
                            @endif
                            
                            <button class="action-btn delete" onclick="deleteTestimoni({{ $item->id_testimoni }})" title="Delete">
                                Delete
                            </button>
                        </div>
                    </div>
                    @empty
                    <div class="empty-state">
                        <div class="empty-icon">📝</div>
                        <h3>No testimonials found</h3>
                        <p>There are no testimonials to display at the moment.</p>
                        <button class="btn btn-primary" onclick="showAddModal()">Add First Testimonial</button>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Add Modal -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Add New Testimonial</h3>
                <span class="close" onclick="closeModal()">&times;</span>
            </div>
            <form id="addTestimoniForm">
                <div class="form-group">
                    <label for="id_pengguna">Customer</label>
                    <select id="id_pengguna" name="id_pengguna" required>
                        <option value="">Select Customer</option>
                        <!-- This should be populated from your users -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="id_service">Service</label>
                    <select id="id_service" name="id_service" required>
                        <option value="">Select Service</option>
                        <!-- This should be populated from your services -->
                    </select>
                </div>
                <div class="form-group">
                    <label for="isi_testimoni">Review</label>
                    <textarea id="isi_testimoni" name="isi_testimoni" required maxlength="1000"></textarea>
                </div>
                <div class="form-group">
                    <label>
                        <input type="checkbox" id="menyoroti" name="menyoroti"> 
                        Feature this review
                    </label>
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add Testimonial</button>  
                </div>
            </form>
        </div>
    </div>

    <!-- View Modal -->
    <div id="viewModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Testimonial Details</h3>
                <span class="close" onclick="closeViewModal()">&times;</span>
            </div>
            <div id="viewContent">
                <!-- Content will be populated by JavaScript -->
            </div>
        </div>
    </div>

    <script>
        // Set up CSRF token
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

        // Delete testimonial function
        function deleteTestimoni(id) {
            if (confirm('Are you sure you want to delete this testimonial?')) {
                fetch(`/admin/api/testimoni/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Content-Type': 'application/json'
                    }
                })
                .then(response => response.json())
                .then(data => {
                    if (data.message) {
                        alert(data.message);
                        location.reload();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error deleting testimonial');
                });
            }
        }


        // Toggle highlight function
        function toggleHighlight(id, highlight) {
            fetch(`/admin/api/testimoni/${id}`, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ highlight: highlight })
            })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    alert(data.message);
                    location.reload();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error updating testimonial');
            });
        }

        // Combined search and filter function 
        function applyFilters() {
            const searchTerm = document.getElementById('searchTestimoni').value.toLowerCase();
            const filterValue = document.getElementById('filterHighlight').value;
            const cards = document.querySelectorAll('.testimonial-card');
            
            cards.forEach(card => {
                const text = card.textContent.toLowerCase();
                const matchesSearch = text.includes(searchTerm);
                
                let matchesFilter = true;
                if (filterValue === '1') {
                    matchesFilter = card.querySelector('.highlight-badge') !== null;
                } else if (filterValue === '0') {
                    matchesFilter = card.querySelector('.regular-badge') !== null;
                }
                
                card.style.display = (matchesSearch && matchesFilter) ? 'block' : 'none';
            });
        }

        document.getElementById('searchTestimoni').addEventListener('input', applyFilters);
        document.getElementById('filterHighlight').addEventListener('change', applyFilters);
        
    </script>
</body>
</html>