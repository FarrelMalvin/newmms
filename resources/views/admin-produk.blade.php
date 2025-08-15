<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- viewport: checked responsive -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin-testimoni.css') }}">
    <link rel="stylesheet" href="{{ asset('css/sidebar.css') }}">
    <link rel="stylesheet" href="{{ asset('css/admin-produk.css') }}">
    <title>Admin - Products</title>
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
                <a href="/admin/produk" class="nav-item active">
                    <span>Products</span>
                    <img class="chevron-right" src="/images/chevron-right.png" alt="">
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
                <h1>Products Management</h1>
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
                            <div class="stat-label">Total Products</div>
                            <div class="stat-value">{{ $produk->count() ?? 0 }}</div>
                        </div>
                        <div class="stat-icon blue">📦</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-content">
                            <div class="stat-label">Available</div>
                            <div class="stat-value">{{ $produk->where('stok', '>', 0)->count() ?? 0 }}</div>
                        </div>
                        <div class="stat-icon green">✅</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-content">
                            <div class="stat-label">Out of Stock</div>
                            <div class="stat-value">{{ $produk->where('stok', '<=', 0)->count() ?? 0 }}</div>
                        </div>
                        <div class="stat-icon red">❌</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-content">
                            <div class="stat-label">Low Stock</div>
                            <div class="stat-value">{{ $produk->where('stok', '<=', 5)->where('stok', '>', 0)->count() ?? 1 }}</div>
                        </div>
                        <div class="stat-icon orange">⚠️</div>
                    </div>
                </div>

                <!-- Search and Filter Section -->
                <div class="filter-section">
                    <div class="search-container">
                        <input type="text" id="searchProduk" placeholder="Search products..." class="search-input">
                    </div>
                    <div class="filter-container">
                        <select name="filterStatus" id="filterStock" class="filter-select">
                            <option value="">All Products</option>
                            <option value="available">Available</option>
                            <option value="out-of-stock">Out of Stock</option>
                            <option value="low-stock">Low Stock</option>
                        </select>
                        <select name="filterCategory" id="filterCategory" class="filter-select">
                            <option value="">All Categories</option>
                            <option value="Oil">Oil</option>
                            <option value="Second Part">Second Part</option>
                            <option value="New Part">New Part</option>
                            <option value="Apparel">Apparel</option>
                        </select>
                        <button class="btn btn-primary" onclick="showAddModal()">Add Product</button>
                    </div>
                </div>

                <!-- Products Cards -->
                <div class="testimonials-grid">
                    @forelse($produk ?? [] as $item)
                    <div class="testimonial-card product-card">
                        <div class="card-header">
                            <div class="customer-profile">
                                <img src="{{ $item->gambar_produk ? asset('storage/') . '/' . str_replace('storage/', '', $item->gambar_produk) : \App\Helpers\ImageHelper::getProductAvatar($item->nama_produk, 48) }}" alt="Product" class="customer-avatar product-image" onerror="this.src='{{ \App\Helpers\ImageHelper::getProductAvatar($item->nama_produk, 48) }}'">
                                <div class="customer-details">
                                    <h4 class="customer-name">{{ $item->nama_produk ?? 'Unknown Product' }}</h4>
                                    <p class="customer-type">{{ $item->kategori ?? 'General' }}</p>
                                </div>
                            </div>
                            @if($item->stok > 5)
                            <span class="highlight-badge available">Available</span>
                            @elseif($item->stok > 0)
                            <span class="regular-badge low-stock">Low Stock</span>
                            @else
                            <span class="regular-badge out-of-stock">Out of Stock</span>
                            @endif
                        </div>

                        <div class="rating-section">
                            <div class="price-section">
                                <span class="price">Rp {{ number_format($item->harga ?? 0, 0, ',', '.') }}</span>
                                <span class="stock">Stock: {{ $item->stok ?? 0 }}</span>
                            </div>
                        </div>

                        <div class="testimonial-content">
                            <p class="testimonial-text">{{ $item->deskripsi ?? 'No description available' }}</p>
                        </div>

                        <div class="testimonial-meta">
                           
                            <span class="product-service">
                                <strong>Category:</strong> {{ $item->kategori ?? 'General' }}
                            </span>
                        </div>

                        <div class="card-actions">
                            <button class="action-btn edit" onclick="editProduct({{ $item->id_produk }})" title="Edit Product">
                                ✏️ Edit
                            </button>
                            
                            <button class="action-btn highlight" onclick="viewProduct({{ $item->id_produk }})" title="View Details">
                                👁️ View
                            </button>
                            
                            <button class="action-btn delete" onclick="deleteProduct({{ $item->id_produk }})" title="Delete Product">
                                🗑️ Delete
                            </button>
                        </div>
                    </div>
                    @empty
                    <div class="empty-state">
                        <div class="empty-icon">📦</div>
                        <h3>No products found</h3>
                        <p>There are no products to display at the moment.</p>
                        <button class="btn btn-primary" onclick="showAddModal()">Add First Product</button>
                    </div>
                    @endforelse
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
                         <option value="">Select Categories</option>
                            <option value="Oil">Oil</option>
                            <option value="Second Part">Second Part</option>
                            <option value="New Part">New Part</option>
                            <option value="Apparel">Apparel</option>
                    </select>
                </div>
                    <div class="form-group">
                    <label for="harga">Price</label>
                    <input type="text" id="harga" name="harga" required min="0" inputmode="numeric" pattern="[0-9.,]*">
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

    <!-- View Modal -->
    <div id="viewModal" class="modal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Product Details</h3>
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
        // Event listeners
        document.getElementById('searchProduk').addEventListener('input', applyFilters);
        document.getElementById('filterStock').addEventListener('change', applyFilters);
        document.getElementById('filterCategory').addEventListener('change', applyFilters);

        // Add price formatting event listeners
        document.getElementById('harga').addEventListener('input', handlePriceInput);
        document.getElementById('harga').addEventListener('keydown', validatePriceInput);
        
        // Variables to track edit mode
        let isEditMode = false;
        let currentProductId = null;

        // Price formatting function
               // Price formatting function
        function formatPrice(value) {
            // Remove all non-digit characters
            const number = value.replace(/\D/g, '');
            // Add thousand separators
            return number.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        // Price input formatting with validation
        function handlePriceInput(event) {
            const input = event.target;
            const cursorPosition = input.selectionStart;
            const oldValue = input.value;
            const oldLength = oldValue.length;
            
            // Only allow digits and dots
            const cleanValue = input.value.replace(/[^\d]/g, '');
            
            // Format the value
            const formattedValue = formatPrice(cleanValue);
            input.value = formattedValue;
            
            // Adjust cursor position
            const newLength = formattedValue.length;
            const lengthDiff = newLength - oldLength;
            const newCursorPosition = Math.max(0, cursorPosition + lengthDiff);
            input.setSelectionRange(newCursorPosition, newCursorPosition);
        }

         // Get raw price value (remove dots)
        function getRawPrice(formattedPrice) {
            return formattedPrice.replace(/\./g, '');
        }

        // Validate price input to only allow numbers
        function validatePriceInput(event) {
            // Allow: backspace, delete, tab, escape, enter
            if ([8, 9, 27, 13, 46].indexOf(event.keyCode) !== -1 ||
                // Allow: Ctrl+A, Ctrl+C, Ctrl+V, Ctrl+X
                (event.keyCode === 65 && event.ctrlKey === true) ||
                (event.keyCode === 67 && event.ctrlKey === true) ||
                (event.keyCode === 86 && event.ctrlKey === true) ||
                (event.keyCode === 88 && event.ctrlKey === true)) {
                return;
            }
            // Ensure that it is a number and stop the keypress
            if ((event.shiftKey || (event.keyCode < 48 || event.keyCode > 57)) && (event.keyCode < 96 || event.keyCode > 105)) {
                event.preventDefault();
            }
        }
        // Modal functions
        function showAddModal() {
            isEditMode = false;
            currentProductId = null;
            document.getElementById('modalTitle').textContent = 'Add New Product';
            document.getElementById('addProductForm').reset();
            document.getElementById('productId').value = '';
            document.getElementById('submitBtn').textContent = 'Save Product';
            document.getElementById('addModal').style.display = 'block';
        }

        function closeModal() {
            document.getElementById('addModal').style.display = 'none';
            isEditMode = false;
            currentProductId = null;
        }

        function closeViewModal() {
            document.getElementById('viewModal').style.display = 'none';
        }

        // Form submission handler with proper edit/add logic
        document.getElementById('addProductForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            
            // Convert formatted price back to raw number before sending
            const priceInput = document.getElementById('harga');
            const rawPrice = getRawPrice(priceInput.value);
            formData.set('harga', rawPrice);
            
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
                    location.reload();
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

        // Delete product function
        function deleteProduct(id) {
            if (confirm('Are you sure you want to delete this product?')) {
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
                    alert('Error deleting product');
                });
            }
        }

        // Edit product function
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
                        // Format the price when populating
                        document.getElementById('harga').value = formatPrice(produk.harga ? produk.harga.toString() : '');
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

        // View product function
        function viewProduct(id) {
            fetch(`/admin/api/produk/${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.produk) {
                        const produk = data.produk;
                        document.getElementById('viewContent').innerHTML = `
                            <div class="product-details">
                                <div style="text-align: center; margin-bottom: 20px;">
                                    <img src="${produk.gambar_produk ? '{{ asset('storage/') }}/' + produk.gambar_produk.replace('storage/', '') : 'https://ui-avatars.com/api/?name=' + encodeURIComponent(produk.nama_produk) + '&background=FE8400&color=ffffff&size=200&font-size=0.4'}" style="width: 200px; height: 200px; object-fit: cover; border-radius: 8px; border: 1px solid #e5e7eb;">
                                </div>
                                <h3 style="margin-bottom: 15px; color: #1f2937;">${produk.nama_produk}</h3>
                                <p style="margin-bottom: 10px;"><strong>Category:</strong> ${produk.kategori}</p>
                                <p style="margin-bottom: 10px;"><strong>Price:</strong> Rp ${new Intl.NumberFormat('id-ID').format(produk.harga)}</p>
                                <p style="margin-bottom: 10px;"><strong>Stock:</strong> ${produk.stok}</p>
                                <p style="margin-bottom: 10px;"><strong>Description:</strong></p>
                                <p style="background: #f9fafb; padding: 10px; border-radius: 6px; border: 1px solid #e5e7eb;">${produk.deskripsi}</p>
                            </div>
                        `;
                        document.getElementById('viewModal').style.display = 'block';
                    } else {
                        alert('Product not found');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error loading product details');
                });
        }

        // Combined search and filter function
        function applyFilters() {
            const searchTerm = document.getElementById('searchProduk').value.toLowerCase();
            const stockFilter = document.getElementById('filterStock').value;
            const categoryFilter = document.getElementById('filterCategory').value;
            const cards = document.querySelectorAll('.product-card');
            
            cards.forEach(card => {
                const text = card.textContent.toLowerCase();
                const matchesSearch = text.includes(searchTerm);
                
                let matchesStock = true;
                if (stockFilter === 'available') {
                    matchesStock = card.querySelector('.available') !== null;
                } else if (stockFilter === 'out-of-stock') {
                    matchesStock = card.querySelector('.out-of-stock') !== null;
                } else if (stockFilter === 'low-stock') {
                    matchesStock = card.querySelector('.low-stock') !== null;
                }
                
                let matchesCategory = true;
                if (categoryFilter !== '') {
                    matchesCategory = text.includes(categoryFilter.toLowerCase());
                }
                
                card.style.display = (matchesSearch && matchesStock && matchesCategory) ? 'block' : 'none';
            });
        }

        // Event listeners
        document.getElementById('searchProduk').addEventListener('input', applyFilters);
        document.getElementById('filterStock').addEventListener('change', applyFilters);
        document.getElementById('filterCategory').addEventListener('change', applyFilters);

        // Add price formatting event listener
        document.getElementById('harga').addEventListener('input', handlePriceInput);

        // Close modal when clicking outside
        window.onclick = function(event) {
            const addModal = document.getElementById('addModal');
            const viewModal = document.getElementById('viewModal');
            
            if (event.target === addModal) {
                closeModal();
            }
            if (event.target === viewModal) {
                closeViewModal();
            }
        }

        // Close modal with Escape key
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                closeModal();
                closeViewModal();
            }
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
    </script>
</body>
</html>