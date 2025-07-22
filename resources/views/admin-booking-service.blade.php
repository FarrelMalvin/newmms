<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- viewport: checked responsive -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <title>Dashboard Admin - Bookings</title>
    <link rel="stylesheet" href="/css/admin-dashboard.css">
    <link rel="stylesheet" href="/css/admin-booking.css">
    <link rel="stylesheet" href="/css/sidebar.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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
                <a href="/admin/testimoni" class="nav-item">
                    <span>Testimonials</span>
                </a>
                <a href="/admin/produk" class="nav-item">
                    <span>Products</span>
                </a>
                <a href="/admin/booking" class="nav-item active">
                    <span>Booking</span>
                    <img class="chevron-right" src="/images/chevron-right.png" alt="">
                </a>
                <a href="/admin/berita" class="nav-item">
                    <span>News</span>
                </a>
            </nav>
            
            <div class="logout-section">
                <button onclick="performLogout()" class="logout-btn" style="background: none; border: none; cursor: pointer; display: flex; align-items: center; gap: 0.5rem; color: inherit; text-decoration: none; width: 100%; padding: 0.75rem 1rem; border-radius: 0.5rem; transition: background-color 0.2s;">
                    <span class="nav-icon">🚪</span>
                    <span>Log Out</span>
                </button>
            </div>
        </div>

        <div class="main-content">
            <div class="header">
                <h1>Booking Service</h1>
                <div class="header-right">
                    
                <div class="user-profile">
                    <span>{{ Auth::user()->nama ?? 'Admin' }}</span>
                </div>
                </div>
            </div>
            
            <div class="content">
                <div class="booking-list">
                    <!-- Booking items will be dynamically inserted here -->
                </div>
                
                <div class="booking-actions">
                    <button id="addBookingBtn" class="btn">Add Booking</button>
                </div>
            </div>
            
            <div class="content-wrapper">
                <div class="stats-section">
                    <div class="stat-card">
                        <div class="stat-content">
                            <div class="stat-label">Total Bookings</div>
                            <div class="stat-value">{{ $services->count() ?? 0 }}</div>
                        </div>
                        <div class="stat-icon blue">📅</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-content">
                            <div class="stat-label">Pending</div>
                            <div class="stat-value">{{ $services->where('status', 'pend')->count() ?? 0 }}</div>
                        </div>
                        <div class="stat-icon yellow">⏳</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-content">
                            <div class="stat-label">In Progress</div>
                            <div class="stat-value">{{ $services->where('status', 'pros')->count() ?? 0 }}</div>
                        </div>
                        <div class="stat-icon orange">🔧</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-content">
                            <div class="stat-label">Completed</div>
                            <div class="stat-value">{{ $services->where('status', 'fin')->count() ?? 0 }}</div>
                        </div>
                        <div class="stat-icon green">✅</div>
                    </div>
                </div>
                
                <!-- Booking List -->
                <div class="content-section">
                    <div class="section-header">
                        <h2>Recent Bookings</h2>
                    </div>
                    <div class="booking-list">
                        @forelse($services->take(10) as $service)
                        <div class="booking-item">
                            <div class="booking-content">
                                <div class="booking-name">{{ $service->pengguna->nama ?? 'Anonymous' }}</div>
                                <div class="booking-service">{{ $service->typeservice->nama_service ?? 'Service' }} - {{ $service->tanggal ?? 'No Date' }}</div>
                                <div class="booking-time">Time: {{ $service->jadwal ?? 'No Time' }}</div>
                                @switch($service->status)
                                    @case('fin')
                                        <span class="status-badge finished">Completed</span>
                                        @break
                                    @case('pros')
                                        <span class="status-badge ongoing">In Progress</span>
                                        @break
                                    @case('pend')
                                        <span class="status-badge pending">Pending</span>
                                        @break
                                    @default
                                        <span class="status-badge draft">{{ $service->status }}</span>
                                @endswitch
                            </div>
                            <div class="booking-actions">
                                @if($service->status === 'pend')
                                <button class="btn-icon" onclick="startService({{ $service->id_service }})">▶️</button>
                                @endif
                            </div>
                        </div>
                        @empty
                        <div class="empty-state">
                            <p>No bookings yet</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
    </div>
    
    <script>
        function startService(serviceId) {
            if (confirm('Start this service?')) {
                fetch(`/service/${serviceId}/start`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Content-Type': 'application/json',
                    },
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        location.reload();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('An error occurred');
                });
            }
        }

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
    </script>
</body>
</html>