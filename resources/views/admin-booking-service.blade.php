<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <title>Dashboard Admin - Bookings</title>
    <link rel="stylesheet" href="/css/admin-dashboard.css">
    <link rel="stylesheet" href="/css/admin-testimoni.css">
    <link rel="stylesheet" href="/css/admin-booking-service.css">
    <link rel="stylesheet" href="/css/sidebar.css">
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
            
            <div class="admin-actions-section" style="margin-top: auto; padding: 1rem;">
                <a href="/admin/reset-password" class="reset-password-btn" style="display: flex; align-items: center; gap: 0.5rem; color: #FE8400; text-decoration: none; width: 100%; padding: 0.75rem 1rem; border-radius: 0.5rem; transition: background 0.2s; background: rgba(254, 132, 0, 0.1); margin-bottom: 0.5rem;">
                    <span>🔐 Reset Password</span>
                </a>
            </div>
            
            <div class="logout-section">
                <button onclick="performLogout()" class="logout-btn" style="background: none; border: none; cursor: pointer; display: flex; align-items: center; gap: 0.5rem; color: inherit; text-decoration: none; width: 100%; padding: 0.75rem 1rem; border-radius: 0.5rem; transition: background 0.2s;">
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
                            <div class="stat-label">In Progress</div>
                            <div class="stat-value">{{ $services->where('status', 'pros')->count() ?? 0 }}</div>
                        </div>
                        <div class="stat-icon yellow">⏳</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-content">
                            <div class="stat-label">Pending</div>
                            <div class="stat-value">{{ $services->where('status', 'pend')->count() ?? 0 }}</div>
                        </div>
                        <div class="stat-icon orange">🔧</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-content">
                            <div class="stat-label">Completed</div>
                            <div class="stat-value">{{ $services->where('status', 'fin')->count() ?? 0 }}</div>
                        </div>
                        <div class="stat-icon orange">⚠️</div>
                    </div>
                </div>

                <div class="filter-section">
                    <div class="search-container">
                        <input type="text" id="searchProduk" placeholder="Search services..." class="search-input">
                    </div>
                    <div class="filter-container">
                        <select name="filterStatus" id="filterStatus" class="filter-select">
                            <option value="">All Status</option>
                            <option value="pending">Pending</option>
                            <option value="completed">Completed</option>
                            <option value="in progress">In Progress</option>
                            <option value="cancelled">Cancelled</option>
                        </select>
                        <select name="filterCategory" id="filterCategory" class="filter-select">
                            <option value="">All Categories</option>
                            <option value="Daily">Daily</option>
                        </select>
                    </div>
                </div>
            </div>

            <div class="booking-table-section">
                <div class="table-container">
                    <table class="booking-table">
                        <thead>
                            <tr>
                                <th>CUSTOMER</th>
                                <th>SERVICE</th>
                                <th>COMPLAINT</th>
                                <th>DATE</th>
                                <th>STATUS</th>
                                <th>ACTIONS</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($services as $service)
                            <tr data-service-status="{{ $service->status }}" @if($service->status == 'pros') data-started-at="{{ $service->started_at }}" @endif>
                                <td>
                                    <div class="customer-info">
                                        <div class="customer-avatar">
                                                <img src="https://ui-avatars.com/api/?name={{ $service->pengguna->nama ?? 'Unknown' }}&background=eeeeee&color=141414&size=48" alt="Profile" class="customer-avatar">
                                        </div>
                                        <div class="customer-details">
                                            <div class="customer-name">{{ $service->pengguna->nama ?? 'Unknown' }}</div>
                    
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <div class="service-info">
                                        <div class="service-name">{{ $service->typeService->nama_service ?? 'Unknown Service' }}</div>
                                        <div class="service-duration">{{ $service->jadwal ?? 'N/A' }}</div>
                                    </div>
                                </td>
                                <td>
                                    <div class="complaint-info clickable-complaint" 
                                         onclick="openComplaintModal('{{ addslashes($service->keluhan ?? 'No complaints') }}', '{{ addslashes($service->pengguna->nama ?? 'Unknown') }}', '{{ addslashes($service->typeService->nama_service ?? 'Unknown Service') }}', '{{ \Carbon\Carbon::parse($service->tanggal)->format('M d, Y') }}')">
                                        <div class="complaint-preview">
                                            {{ Str::limit($service->keluhan ?? 'No complaints', 50) }}
                                            @if(strlen($service->keluhan ?? '') > 50)
                                                <span class="read-more">... Click to read more</span>
                                            @endif
                                        </div>
                                    </div>
                                <td>
                                    <div class="booking-date">
                                        {{ \Carbon\Carbon::parse($service->tanggal)->format('M d, Y') }}
                                    </div>
                                </td>
                                <td>
                                    <span class="status-badge 
                                        @if($service->status == 'pend') pending
                                        @elseif($service->status == 'pros') in-progress
                                        @elseif($service->status == 'fin') completed
                                        @elseif($service->status == 'cancel') cancelled
                                        @endif">
                                        @if($service->status == 'pend') Pending
                                        @elseif($service->status == 'pros') In Progress
                                        @elseif($service->status == 'fin') Completed
                                        @elseif($service->status == 'cancel') Cancelled
                                        @else {{ ucfirst($service->status) }}
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    <div class="action-buttons">
                                        @if($service->status == 'done' || $service->status == 'fin')
                                            <button class="action-btn complete" disabled>
                                                ✓ Complete
                                            </button>
                                        @elseif($service->status == 'pend')
                                            <button onclick="startService({{ $service->id_service }})" class="action-btn start">
                                                ▶ Start
                                            </button>
                                            <div><button onclick="cancelService({{ $service->id_service }}, {{ $service->id_pengguna }})" class="action-btn cancel">❌ Cancel</button></div>

                                        @elseif($service->status == 'pros')
                                            <div class="status-text processing">
                                                🔄 In Progress
                                                @if($service->started_at)
                                                    <br><small>Started: {{ \Carbon\Carbon::parse($service->started_at)->format('H:i:s') }}</small>
                                                    <br><div class="timer-display">Auto-complete in 02:00:00</div>
                                                @endif
                                            </div>
                                            <div><button onclick="cancelService({{ $service->id_service }}, {{ $service->id_pengguna }})" class="action-btn cancel">❌ Cancel</button></div>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="5" class="no-data">
                                    <div class="no-bookings">
                                        <p>No bookings found for this branch.</p>
                                    </div>
                                </td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div id="complaintModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h2>Service Complaint Details</h2>
                <span class="close">&times;</span>
            </div>
            <div class="modal-body">
                <div class="complaint-details">
                    <h3>Customer Information</h3>
                    <p><strong>Name:</strong> <span id="modalCustomerName"></span></p>
                    <p><strong>Service Type:</strong> <span id="modalServiceType"></span></p>
                    <p><strong>Date:</strong> <span id="modalServiceDate"></span></p>
                    
                    <h3>Complaint Description</h3>
                    <div id="modalComplaintText" class="complaint-text"></div>
                </div>
            </div>
        </div>
    </div>

    <!-- SweetAlert2 for better alerts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <style>
        /* Custom Alert Styles */
        .custom-alert {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background: white;
            border-radius: 12px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            padding: 2rem;
            z-index: 10000;
            max-width: 400px;
            width: 90%;
            text-align: center;
            border: 2px solid #FE8400;
        }
        
        .custom-alert.success {
            border-color: #28a745;
        }
        
        .custom-alert.error {
            border-color: #dc3545;
        }
        
        .custom-alert.warning {
            border-color: #ffc107;
        }
        
        .custom-alert .icon {
            font-size: 3rem;
            margin-bottom: 1rem;
        }
        
        .custom-alert .title {
            font-size: 1.5rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            color: #333;
        }
        
        .custom-alert .message {
            font-size: 1rem;
            color: #666;
            margin-bottom: 1.5rem;
            line-height: 1.5;
        }
        
        .custom-alert .btn {
            background: #FE8400;
            color: white;
            border: none;
            padding: 0.75rem 2rem;
            border-radius: 8px;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.2s;
        }
        
        .custom-alert .btn:hover {
            background: #e67300;
        }
        
        .custom-alert .btn.error {
            background: #dc3545;
        }
        
        .custom-alert .btn.error:hover {
            background: #c82333;
        }
        
        .overlay {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0,0,0,0.5);
            z-index: 9999;
        }
        
        /* Timer Styles */
        .timer-display {
            font-weight: 600;
            font-size: 0.9rem;
            padding: 0.25rem 0.5rem;
            border-radius: 4px;
            background: rgba(254, 132, 0, 0.1);
            color: #FE8400;
            display: inline-block;
            margin-top: 0.25rem;
        }
        
        .timer-display.warning {
            background: rgba(255, 193, 7, 0.1);
            color: #ffc107;
        }
        
        .timer-display.danger {
            background: rgba(220, 53, 69, 0.1);
            color: #dc3545;
        }
        
        /* Status Text Styles */
        .status-text.processing {
            background: rgba(254, 132, 0, 0.1);
            color: #FE8400;
            padding: 0.5rem;
            border-radius: 6px;
            font-weight: 500;
            text-align: center;
            border: 1px solid rgba(254, 132, 0, 0.2);
        }
        
        .status-text.processing small {
            display: block;
            margin-top: 0.25rem;
            font-size: 0.85rem;
            opacity: 0.8;
        }
    </style>
    
    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        
        // Custom Alert Function
        function showCustomAlert(type, title, message, callback = null) {
            const overlay = document.createElement('div');
            overlay.className = 'overlay';
            
            const alert = document.createElement('div');
            alert.className = `custom-alert ${type}`;
            
            const icon = type === 'success' ? '✅' : type === 'error' ? '❌' : type === 'warning' ? '⚠️' : 'ℹ️';
            
            alert.innerHTML = `
                <div class="icon">${icon}</div>
                <div class="title">${title}</div>
                <div class="message">${message}</div>
                <button class="btn ${type === 'error' ? 'error' : ''}" onclick="closeCustomAlert()">OK</button>
            `;
            
            document.body.appendChild(overlay);
            document.body.appendChild(alert);
            
            if (callback) {
                setTimeout(callback, 2000);
            }
        }
        
        function closeCustomAlert() {
            const overlay = document.querySelector('.overlay');
            const alert = document.querySelector('.custom-alert');
            if (overlay) overlay.remove();
            if (alert) alert.remove();
        }
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchProduk');
            const filterStatus = document.getElementById('filterStatus');
            const filterCategory = document.getElementById('filterCategory');

            searchInput.addEventListener('input', function() {
                filterBookings();
            });

            filterStatus.addEventListener('change', function() {
                filterBookings();
            });

            filterCategory.addEventListener('change', function() {
                filterBookings();
            });

            function filterBookings() {
                const searchValue = searchInput.value.toLowerCase();
                const statusValue = filterStatus.value;
                const categoryValue = filterCategory.value;

                const rows = document.querySelectorAll('.booking-table tbody tr');
                rows.forEach(row => {
                    const customerName = row.querySelector('.customer-name').textContent.toLowerCase();
                    const serviceName = row.querySelector('.service-name').textContent.toLowerCase();
                    const statusText = row.querySelector('.status-badge').textContent.toLowerCase();
                    const complaintText = row.querySelector('.complaint-info').textContent.toLowerCase();

                    const matchesSearch = customerName.includes(searchValue) || serviceName.includes(searchValue) || statusText.includes(searchValue) || complaintText.includes(searchValue);
                    const matchesStatus = !statusValue || statusText.includes(statusValue);
                    const matchesCategory = !categoryValue || row.querySelector('.service-info .service-name').textContent.includes(categoryValue);

                    if (matchesSearch && matchesStatus && matchesCategory) {
                        row.style.display = '';
                    } else {
                        row.style.display = 'none';
                    }
                });
            }
        });
        function startService(serviceId) {
            // Show loading state
            showCustomAlert('warning', 'Starting Service', 'Please wait while we start the service...');
            
            fetch(`/admin/api/service/start/${serviceId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                closeCustomAlert();
                if (data.success) {
                    showCustomAlert('success', 'Service Started', data.message, () => {
                        location.reload();
                    });
                } else if (data.error) {
                    showCustomAlert('error', 'Error', data.error);
                }
            })
            .catch(error => {
                closeCustomAlert();
                console.error('Error:', error);
                showCustomAlert('error', 'Error', 'Failed to start service. Please try again.');
            });
        }

        function cancelService(serviceId, userId) {
            // Show custom confirmation dialog
            const confirmCancel = confirm('Are you sure you want to cancel this service?');
            if (!confirmCancel) {
                return;
            }
            
            showCustomAlert('warning', 'Cancelling Service', 'Please wait while we cancel the service...');
            
            fetch(`/admin/api/service/cancel/${serviceId}/user/${userId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                },
            })
            .then(response => response.json())
            .then(data => {
                closeCustomAlert();
                if (data.success) {
                    showCustomAlert('success', 'Service Cancelled', data.message, () => {
                        location.reload();
                    });
                } else if (data.error) {
                    showCustomAlert('error', 'Error', data.error);
                }
            })
            .catch(error => {
                closeCustomAlert();
                console.error('Error:', error);
                showCustomAlert('error', 'Error', 'Failed to cancel service. Please try again.');
            });
        }

        function updateServiceTimers() {
            const inProgressServices = document.querySelectorAll('[data-service-status="pros"]');
            
            inProgressServices.forEach(serviceRow => {
                const startedAt = serviceRow.dataset.startedAt;
                
                if (startedAt) {
                    const startTime = new Date(startedAt);
                    const now = new Date();
                    const elapsed = now - startTime;
                    const twoHours = 2 * 60 * 60 * 1000; // 2 hours in milliseconds
                    const remaining = twoHours - elapsed;
                    
                    const timerElement = serviceRow.querySelector('.timer-display');
                    
                    if (remaining > 0) {
                        const totalSeconds = Math.ceil(remaining / 1000);
                        const hours = Math.floor(totalSeconds / 3600);
                        const minutes = Math.floor((totalSeconds % 3600) / 60);
                        const seconds = totalSeconds % 60;

                        const formattedTime = `${hours.toString().padStart(2, '0')}:${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;
                        
                        if (timerElement) {
                            // Update timer text and styling based on remaining time
                            timerElement.textContent = `Auto-complete in ${formattedTime}`;
                            
                            // Change color based on remaining time
                            if (remaining < 30 * 60 * 1000) { // Less than 30 minutes
                                timerElement.className = 'timer-display danger';
                            } else if (remaining < 60 * 60 * 1000) { // Less than 1 hour
                                timerElement.className = 'timer-display warning';
                            } else {
                                timerElement.className = 'timer-display';
                            }
                        }
                    } else {
                        if (timerElement) {
                            timerElement.textContent = 'Completing...';
                            timerElement.className = 'timer-display danger';
                        }
                        // Show completion alert
                        showCustomAlert('success', 'Service Completed', 'Service has been automatically completed!', () => {
                            location.reload();
                        });
                    }
                }
            });
        }

        // ...existing code...
        // Modal functionality
        function openComplaintModal(complaint, customerName, serviceType, serviceDate) {
            document.getElementById('modalCustomerName').textContent = customerName;
            document.getElementById('modalServiceType').textContent = serviceType;
            document.getElementById('modalServiceDate').textContent = serviceDate;
            document.getElementById('modalComplaintText').textContent = complaint;
            document.getElementById('complaintModal').style.display = 'block';
        }

        // Close modal functionality
        document.addEventListener('DOMContentLoaded', function() {
            const modal = document.getElementById('complaintModal');
            const closeBtn = document.querySelector('.close');

            // Close modal when clicking the X
            closeBtn.onclick = function() {
                modal.style.display = 'none';
            }

            // Close modal when clicking outside of it
            window.onclick = function(event) {
                if (event.target === modal) {
                    modal.style.display = 'none';
                }
            }

            // Close modal with Escape key
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape' && modal.style.display === 'block') {
                    modal.style.display = 'none';
                }
            });

            updateServiceTimers();
            setInterval(updateServiceTimers, 1000);
        });
// ...existing code...

        // Start the timer updates
        document.addEventListener('DOMContentLoaded', function() {
            updateServiceTimers();
            setInterval(updateServiceTimers, 1000);
        });

        // Logout function
        function performLogout() {
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("logout") }}';
            
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            
            form.appendChild(csrfToken);
            document.body.appendChild(form);
            form.submit();
        }
    </script>
</body>
</html>