<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- viewport: checked responsive -->
    <title>Dashboard Admin - Mifta Motor Sport</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin-dashboard.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>
    <div class="dashboard-container">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="logo-section">
                <div class="logo">
                    <span>MMS - Admin Dashboard</span>
                </div>
            </div>
            
            <nav class="nav-menu">
                <a href="/admin/dashboard" class="nav-item active">
                    <span>Home</span>
                    <img class="chevron-right" src="/images/chevron-right.png" alt="">
                </a>
                <a href="/admin/testimoni" class="nav-item">
                    <span>Testimonials</span>
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
        
        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <header class="header">
                <h1>Home</h1>
                <div class="header-right">
                    <div class="notification-badge">
                    </div>
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
                        <div class="stat-label">Total Testimonials</div>
                        <div class="stat-value">{{ $testimoniCount }}</div>
                    </div>
                    <div class="stat-icon blue">👥</div>
                </div>
                <div class="stat-card">
                    <div class="stat-content">
                        <div class="stat-label">Active Product</div>
                        <div class="stat-value">{{ $produkCount }}</div>
                    </div>
                    <div class="stat-icon green">📦</div>
                </div>
                <div class="stat-card">
                    <div class="stat-content">
                        <div class="stat-label">New Bookings</div>
                        <div class="stat-value">{{ $serviceCount }}</div>
                    </div>
                    <div class="stat-icon yellow">📅</div>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="content-grid">
                <!-- Recent Testimonials -->
                <div class="content-section">
                    <div class="section-header">
                        <h2>Recent Testimonials</h2>
                        <a href="/admin/testimoni" class="btn btn-primary">View All</a>
                    </div>
                    <div class="testimonial-list">
                        @forelse($recentTestimoni->take(2) as $testimoni)
                        <div class="testimonial-item">
                         <img src="https://ui-avatars.com/api/?name={{ Auth::user()->nama }}&background=eeeeee&color=141414&size=128" alt="Profile" class="header-profile">
                            <div class="testimonial-content">
                                <div class="testimonial-name">{{ $testimoni->pengguna->nama ?? 'Anonymous' }}</div>
                                <div class="testimonial-text">"{{ Str::limit($testimoni->isi_testimoni, 50) }}"</div>
                            </div>
                            <div class="testimonial-actions">
                                <button class="btn-icon delete" onclick="deleteTestimoni({{ $testimoni->id_testimoni }})">🗑️</button>
                            </div>
                        </div>
                        @empty
                        <div class="empty-state">
                            <p>No testimonials yet</p>
                        </div>
                        @endforelse
                    </div>
                </div>
                <!-- Product Inventory -->
                <div class="content-section">
                    <div class="section-header">
                        <h2>Product Inventory</h2>
                        <a href="/admin/produk" class="btn btn-success">View All</a>
                    </div>
                    <div class="product-list">
                        @forelse($recentProduk->take(2) as $produk)
                        <div class="product-item">
                            <img src="{{ $produk->gambar_produk ? asset('storage/') . '/' . str_replace('storage/', '', $produk->gambar_produk) : \App\Helpers\ImageHelper::getProductAvatar($produk->nama_produk, 50) }}" alt="{{ $produk->nama_produk }}" class="product-image" onerror="this.src='{{ \App\Helpers\ImageHelper::getProductAvatar($produk->nama_produk, 50) }}'">
                            <div class="product-content">
                                <div class="product-name">{{ $produk->nama_produk }}</div>
                                <div class="product-category">{{ $produk->deskripsi ?? 'Product' }}</div>
                                <div class="product-price">Rp {{ number_format($produk->harga, 0, ',', '.') }}</div>
                            </div>
                            <div class="product-actions">
                                <button class="btn-icon" onclick="editProduct({{ $produk->id_produk }})">✏️</button>
                                <button onclick="deleteProduct({{ $produk->id_produk }})" class="btn-icon delete">🗑️</button>
                            </div>
                        </div>
                        @empty
                        <div class="empty-state">
                            <p>No products yet</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Recent Bookings -->
                <div class="content-section">
                    <div class="section-header">
                        <h2>Recent Bookings</h2>
                        <a href="/admin/booking" class="btn btn-warning">View All</a>
                    </div>
                    <div class="booking-list">
                        @forelse($recentServices->take(2) as $service)
                        <div class="booking-item">
                            <img src="https://ui-avatars.com/api/?name={{ Auth::user()->nama }}&background=eeeeee&color=141414&size=128" alt="Profile" class="header-profile">
                            <div class="booking-content">
                                <div class="booking-name">{{ $service->pengguna->nama ?? 'Anonymous' }}</div>
                                <div class="booking-service">{{ $service->type_service ?? 'Service' }} - {{ $service->tanggal ?? 'No Date' }}</div>
                                @switch($service->status)
                                    @case('fin')
                                        <span class="status-badge finished">Finished</span>
                                        @break
                                    @case('pros')
                                        <span class="status-badge ongoing">In Progress</span>
                                    @case('cancel')
                                        <span class="status-badge cancelled">Cancelled</span>
                                        @break
                                    @default
                                        <span class="status-badge draft">Pending</span>
                                @endswitch
                            </div>
                            <div class="booking-actions">
                                {{-- <button class="btn-icon">✏️</button>
                                <button class="btn-icon delete">🗑️</button> --}}
                            </div>
                        </div>
                        @empty
                        <div class="empty-state">
                            <p>No bookings yet</p>
                        </div>
                        @endforelse
                    </div>
                </div>

                <!-- Latest News -->
                <div class="content-section">
                    <div class="section-header">
                        <h2>Latest News</h2>
                        <a href="/admin/berita" class="btn btn-purple">View All</a>
                    </div>
                    <div class="news-list">
                        @forelse($recentBerita->take(2) as $berita)
                        <div class="news-item">
                            <div class="news-content">
                                <div class="news-title">{{ $berita->judul }}</div>
                                <div class="news-description">{{ Str::limit($berita->konten, 50) }}</div>
                                <span class="status-badge published">Published</span>
                            </div>
                            <div class="news-actions">
                                <button class="btn-icon" onclick="editBerita({{ $berita->id_berita }})">✏️</button>
                                <button class="btn-icon delete" onclick="deleteBerita({{ $berita->id_berita }})">🗑️</button>
                            </div>
                        </div>
                        @empty
                        <div class="empty-state">
                            <p>No news yet</p>
                        </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Add/Edit Modal -->
    <div id="addModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="modalTitle">Add New Product</h3>
                <span class="close" onclick="closeModal()">&times;</span>
            </div>
            <form id="addProductForm">
                <!-- Hidden field to track product ID for editing -->
                <input type="hidden" id="productId" name="productId" value="">
                
                <div class="form-group">
                    <label for="nama_produk">Product Name</label>
                    <input type="text" id="nama_produk" name="nama_produk" required>
                </div>
                <div class="form-group">
                    <label for="kategori">Category</label>
                    <select id="kategori" name="kategori" required>
                        <option value="">All Categories</option>
                        <option value="Oil">Oil</option>
                        <option value="Second Part">Second Part</option>
                        <option value="New Part">New Part</option>
                        <option value="Apparel">Apparel</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="harga">Price</label>
                    <input type="number" id="harga" name="harga" required min="0">
                </div>
                <div class="form-group">
                    <label for="stok">Stock</label>
                    <input type="number" id="stok" name="stok" required min="0">
                </div>
                <div class="form-group">
                    <label for="deskripsi">Description</label>
                    <textarea id="deskripsi" name="deskripsi" maxlength="1000"></textarea>
                </div>
                <div class="form-group">
                    <label for="gambar">Product Image</label>
                    <input type="file" id="gambar" name="gambar" accept="image/*">
                </div>
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="submitBtn">Save Product</button>
                </div>
            </form>
        </div>
    </div>

    <div id="beritaModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3 id="beritaModalTitle">Edit News</h3>
                <span class="close" onclick="closeBeritaModal()">&times;</span>
            </div>
            <form id="editBeritaForm">
                <!-- Hidden field to track berita ID for editing -->
                <input type="hidden" id="beritaId" name="beritaId" value="">
                
                <div class="form-group">
                    <label for="judul_berita">News Title</label>
                    <input type="text" id="judul_berita" name="judul_berita" required maxlength="255">
                </div>
                
                <div class="form-group">
                    <label for="berita_judul">Subtitle</label>
                    <input type="text" id="berita_judul" name="berita_judul" maxlength="255">
                </div>
                
                <div class="form-group">
                    <label for="berita_deskripsi">Description</label>
                    <textarea id="berita_deskripsi" name="berita_deskripsi" required rows="3" maxlength="500"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="berita_konten">Content</label>
                    <textarea id="berita_konten" name="berita_konten" rows="6" maxlength="2000"></textarea>
                </div>
                
                <div class="form-group">
                    <label for="foto">News Image</label>
                    <input type="file" id="foto" name="foto" accept="image/*">
                    <small class="form-text">Leave empty to keep current image</small>
                    <div id="currentImage" style="margin-top: 10px;"></div>
                </div>
                
                <div class="form-actions">
                    <button type="button" class="btn btn-secondary" onclick="closeBeritaModal()">Cancel</button>
                    <button type="submit" class="btn btn-primary" id="beritaSubmitBtn">Update News</button>
                </div>
            </form>
        </div>
    </div>



    <script>
        // Close dropdown when clicking outside
        document.addEventListener('click', function(event) {
            
        });

        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
         let isEditMode = false;
        let currentProductId = null;

        document.getElementById('addProductForm').addEventListener('submit', function(e) {
        e.preventDefault();
        
        const formData = new FormData(this);
        const submitBtn = document.getElementById('submitBtn');
        
        // Disable submit button during request
        submitBtn.disabled = true;
        submitBtn.textContent = 'Saving...';
        
        let url = '/admin/api/produk';
        let method = 'POST';
        
        // If editing, use PUT method and include product ID in URL
        if (isEditMode && currentProductId) {
            url = `/admin/api/produk/${currentProductId}`;
            method = 'PUT';
            // For PUT requests with file uploads, we need to use POST with _method
            formData.append('_method', 'PUT');
        }
        
        fetch(url, {
            method: method === 'PUT' ? 'POST' : method, // Laravel PUT with files workaround
            headers: {
                'X-CSRF-TOKEN': csrfToken,
            },
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.message) {
                alert(data.message);
                closeModal();
                location.reload(); // Refresh to show updated data
            } else if (data.error) {
                alert('Error: ' + data.error);
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('Error saving product');
        })
        .finally(() => {
            // Re-enable submit button
            submitBtn.disabled = false;
            submitBtn.textContent = isEditMode ? 'Update Product' : 'Save Product';
        });
    });

     let isEditBeritaMode = false;
        let currentBeritaId = null;

        function editBerita(id) {
            fetch(`/admin/dashboard/berita/${id}`)  // This is correct now
                .then(response => response.json())
                .then(data => {
                    if (data.success && data.berita) {
                        const berita = data.berita;
                        
                        // Set edit mode
                        isEditBeritaMode = true;
                        currentBeritaId = id;
                        
                        // Update modal title
                        document.getElementById('beritaModalTitle').textContent = 'Edit News';
                        document.getElementById('beritaSubmitBtn').textContent = 'Update News';
                        
                        // Populate form fields
                        document.getElementById('beritaId').value = id;
                        document.getElementById('judul_berita').value = berita.judul_berita || '';
                        document.getElementById('berita_judul').value = berita.judul || '';
                        document.getElementById('berita_deskripsi').value = berita.deskripsi || '';
                        document.getElementById('berita_konten').value = berita.konten || '';
                        
                        // Show current image if exists
                        const currentImageDiv = document.getElementById('currentImage');
                        if (berita.foto) {
                            currentImageDiv.innerHTML = `
                                <div style="display: flex; align-items: center; gap: 10px;">
                                    <img src="{{ asset('storage/') }}/${berita.foto.replace('storage/', '')}" alt="Current image" style="width: 100px; height: 60px; object-fit: cover; border-radius: 4px; border: 1px solid #ddd;">
                                    <span style="font-size: 0.9em; color: #666;">Current image</span>
                                </div>
                            `;
                        } else {
                            currentImageDiv.innerHTML = '<span style="font-size: 0.9em; color: #999;">No image uploaded</span>';
                        }
                        
                        // Show modal
                        document.getElementById('beritaModal').style.display = 'block';
                    } else {
                        alert('Error fetching news data: ' + (data.message || 'Unknown error'));
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error fetching news data');
                });
        }

        function deleteBerita(id) {
            if (confirm('Are you sure you want to delete this news?')) {
                fetch(`/berita/${id}`, {
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
                    } else if (data.error) {
                        alert('Error: ' + data.error);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error deleting news');
                });
            }
        }

        function closeBeritaModal() {
            document.getElementById('beritaModal').style.display = 'none';
            isEditBeritaMode = false;
            currentBeritaId = null;
            
            // Reset form
            document.getElementById('editBeritaForm').reset();
            document.getElementById('currentImage').innerHTML = '';
        }

        // Handle berita form submission
        document.getElementById('editBeritaForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            if (!currentBeritaId) {
                alert('No news selected for editing');
                return;
            }
            
            const formData = new FormData(this);
            const submitBtn = document.getElementById('beritaSubmitBtn');
            
            // Disable submit button during request
            submitBtn.disabled = true;
            submitBtn.textContent = 'Updating...';
            
            // Add method override for PUT request
            formData.append('_method', 'PUT');
            
            fetch(`/admin/dashboard/berita/${currentBeritaId}`, {  // Fixed: Added leading slash
                method: 'POST', // Laravel PUT with files workaround
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.message || data.success) {
                    alert(data.message || 'News updated successfully');
                    closeBeritaModal();
                    location.reload(); // Refresh to show updated data
                } else if (data.error) {
                    alert('Error: ' + data.error);
                } else if (data.errors) {
                    // Handle validation errors
                    let errorMessage = 'Validation errors:\n';
                    Object.keys(data.errors).forEach(key => {
                        errorMessage += `• ${key}: ${data.errors[key].join(', ')}\n`;
                    });
                    alert(errorMessage);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error updating news');
            })
            .finally(() => {
                // Re-enable submit button
                submitBtn.disabled = false;
                submitBtn.textContent = 'Update News';
            });
        });

        // Close modal when clicking outside
        document.addEventListener('click', function(event) {
            const modal = document.getElementById('addModal');
            const beritaModal = document.getElementById('beritaModal');
            
            if (event.target === modal) {
                closeModal();
            }
            if (event.target === beritaModal) {
                closeBeritaModal();
            }
        });

        function closeModal() {
        document.getElementById('addModal').style.display = 'none';
        isEditMode = false;
        currentProductId = null;
    }       
        function deleteTestimoni(id) {
            if (confirm('Are you sure you want to delete this testimonial?')) {
                fetch(`/testimoni/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
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

        
        function editProduct(id) {
            fetch(`/admin/api/produk/${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.produk) {
                        const produk = data.produk;
                        
                        // Set edit mode
                        isEditMode = true;
                        currentProductId = id;
                        
                        // Update modal title and button
                        document.getElementById('modalTitle').textContent = 'Edit Product';
                        document.getElementById('submitBtn').textContent = 'Update Product';
                        
                        // Populate form fields
                        document.getElementById('productId').value = id;
                        document.getElementById('nama_produk').value = produk.nama_produk || '';
                        document.getElementById('kategori').value = produk.kategori || '';
                        document.getElementById('harga').value = produk.harga || '';
                        document.getElementById('stok').value = produk.stok || '';
                        document.getElementById('deskripsi').value = produk.deskripsi || '';
                        
                        // Show modal
                        document.getElementById('addModal').style.display = 'block';
                    } else {
                        alert('Product not found');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error loading product data');
                });
        }

        document.addEventListener('click', function(event) {
        // Close modal when clicking outside
        const modal = document.getElementById('addModal');
        if (event.target === modal) {
            closeModal();
        }
    });

        function deleteProduct(id) {
            if (confirm('Apakah Anda yakin ingin menghapus produk?')) {
                fetch(`/admin/api/produk/${id}`, {
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
                    } else if (data.error) {
                        alert('Error: ' + data.error);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error menghapus produk');
                });
            }
        }

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