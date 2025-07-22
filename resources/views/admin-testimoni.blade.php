<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- viewport: checked responsive -->
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
                    <span class="nav-icon">🚪</span>
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
                        // Remove the card from DOM instead of page reload
                        const card = document.querySelector(`button[onclick="deleteTestimoni(${id})"]`).closest('.testimonial-card');
                        if (card) {
                            card.remove();
                            updateStats();
                            // ADDED: Reapply filters after deletion
                            applyFilters();
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error deleting testimonial');
                });
            }
        }

        function toggleHighlight(id, highlight) {
            const button = document.querySelector(`button[onclick="toggleHighlight(${id}, '${highlight}')"]`);
            const card = button.closest('.testimonial-card');
            
            button.disabled = true;
            button.textContent = 'Updating...';
            
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
                    // Update the card UI without page reload
                    updateCardHighlight(card, id, highlight);
                    // Update stats
                    updateStats();
                    // ADDED: Reapply filters after highlight toggle
                    applyFilters();
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error updating testimonial');
            })
            .finally(() => {
                // Re-enable button
                button.disabled = false;
            });
        }

        // ENHANCED: Function to update card highlight state
        function updateCardHighlight(card, id, highlight) {
            const badge = card.querySelector('.highlight-badge, .regular-badge');
            const actionsDiv = card.querySelector('.card-actions');
            
            if (highlight === 'true') {
                // Update badge
                badge.className = 'highlight-badge';
                badge.textContent = 'Highlighted';
                
                // Update button
                actionsDiv.innerHTML = `
                    <button class="action-btn remove-highlight" onclick="toggleHighlight(${id}, 'false')" title="Remove Highlight">
                        Remove Highlight
                    </button>
                    <button class="action-btn delete" onclick="deleteTestimoni(${id})" title="Delete">
                        Delete
                    </button>
                `;
            } else {
                // Update badge
                badge.className = 'regular-badge';
                badge.textContent = 'Regular';
                
                // Update button
                actionsDiv.innerHTML = `
                    <button class="action-btn highlight" onclick="toggleHighlight(${id}, 'true')" title="Highlight">
                        Highlight
                    </button>
                    <button class="action-btn delete" onclick="deleteTestimoni(${id})" title="Delete">
                        Delete
                    </button>
                `;
            }
            
            // Add visual feedback
            card.style.transform = 'scale(1.02)';
            card.style.transition = 'transform 0.2s ease';
            setTimeout(() => {
                card.style.transform = 'scale(1)';
            }, 200);
        }

        // ENHANCED: Function to update stats without page reload
        function updateStats() {
            const cards = document.querySelectorAll('.testimonial-card');
            const totalCards = cards.length;
            const highlightedCards = document.querySelectorAll('.highlight-badge').length;
            
            // Update total reviews stat
            const totalStat = document.querySelector('.stat-card .stat-value');
            if (totalStat) {
                totalStat.textContent = totalCards;
            }
            
            // Update highlighted stat
            const highlightedStat = document.querySelectorAll('.stat-card .stat-value')[1];
            if (highlightedStat) {
                highlightedStat.textContent = highlightedCards;
            }
        }

        function applyFilters() {
            const searchTerm = document.getElementById('searchTestimoni').value.toLowerCase();
            const filterValue = document.getElementById('filterHighlight').value;
            const cards = document.querySelectorAll('.testimonial-card');
            
            let visibleCount = 0;
            
            cards.forEach(card => {
                const text = card.textContent.toLowerCase();
                const matchesSearch = text.includes(searchTerm);
                
                let matchesFilter = true;
                if (filterValue === '1') {
                    // Show only highlighted testimonials
                    matchesFilter = card.querySelector('.highlight-badge') !== null;
                } else if (filterValue === '0') {
                    // Show only regular testimonials
                    matchesFilter = card.querySelector('.regular-badge') !== null;
                }
                
                const shouldShow = matchesSearch && matchesFilter;
                card.style.display = shouldShow ? 'block' : 'none';
                
                if (shouldShow) {
                    visibleCount++;
                }
            });
            
            // ADDED: Show/hide empty state based on visible cards
            updateEmptyState(visibleCount);
        }

        // NEW: Function to handle empty state
        function updateEmptyState(visibleCount) {
            const testimonialGrid = document.querySelector('.testimonials-grid');
            const existingEmptyState = testimonialGrid.querySelector('.filter-empty-state');
            
            if (visibleCount === 0) {
                // Show empty state for filter results
                if (!existingEmptyState) {
                    const emptyState = document.createElement('div');
                    emptyState.className = 'filter-empty-state';
                    emptyState.innerHTML = `
                        <div class="empty-icon">🔍</div>
                        <h3>No testimonials match your criteria</h3>
                        <p>Try adjusting your search terms or filter settings.</p>
                        <button class="btn btn-secondary" onclick="clearFilters()">Clear Filters</button>
                    `;
                    emptyState.style.cssText = `
                        text-align: center;
                        padding: 40px 20px;
                        background: #f9fafb;
                        border-radius: 12px;
                        border: 1px solid #e5e7eb;
                        grid-column: 1 / -1;
                    `;
                    testimonialGrid.appendChild(emptyState);
                }
            } else {
                // Remove empty state if cards are visible
                if (existingEmptyState) {
                    existingEmptyState.remove();
                }
            }
        }

        

        document.getElementById('searchTestimoni').addEventListener('input', function() {
            applyFilters();
        });

        document.getElementById('filterHighlight').addEventListener('change', function() {
            applyFilters();
        });

     
        document.getElementById('searchTestimoni').addEventListener('input', function() {
            applyFilters();
            showFilterStatus();
        });

        document.getElementById('filterHighlight').addEventListener('change', function() {
            applyFilters();
            showFilterStatus();
        });

        // NEW: Initialize on page load
        document.addEventListener('DOMContentLoaded', function() {
            applyFilters(); 
            showFilterStatus(); 
        });
    </script>
</body>
</html>