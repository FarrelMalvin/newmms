<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- viewport: checked responsive -->
    <title>News Management - Mifta Motor Sport</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin-berita.css') }}">
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
                <a href="/admin/dashboard" class="nav-item">
                    <span>Home</span>
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
                <a href="/admin/berita" class="nav-item active">
                    <img class="chevron-right" src="/images/chevron-right.png" alt="">
                    <span>News</span>
                </a>
            </nav>
            
            <div class="logout-section">
                <button onclick="performLogout()" class="logout-btn" style="background: none; border: none; cursor: pointer; display: flex; align-items: center; gap: 0.5rem; color: inherit; text-decoration: none; width: 100%; padding: 0.75rem 1rem; border-radius: 0.5rem; transition: background-color 0.2s;">
                    <span>Log Out</span>
                </button>
            </div>
        </div>
        
        <!-- Main Content -->
        <div class="main-content">
            <!-- Header -->
            <header class="header">
                <h1>News Management</h1>
                <div class="header-right">
                    <div class="notification-badge">
                    </div>
                    <div class="user-profile">
                        <span>{{ Auth::user()->nama ?? 'Admin' }}</span>
                    </div>
                </div>
            </header>
            
            <div class="content-wrapper">
                <div class="news-grid">
                    <!-- News Input Form -->
                    <div class="news-form-section">
                        <h2 class="section-title">Add New News</h2>
                        <form id="newsForm">
                            <div class="form-row">
                                <div class="form-group">
                                    <label for="judul_berita">News Title</label>
                                    <input type="text" id="judul_berita" name="judul_berita" required>
                                </div>
                                <div class="form-group">
                                    <label for="judul">Short Title</label>
                                    <input type="text" id="judul" name="judul" placeholder="Short version for display">
                                </div>
                            </div>
                            
                            <div class="form-group full-width">
                                <label for="deskripsi">Description</label>
                                <textarea id="deskripsi" name="deskripsi" required placeholder="Enter news description..."></textarea>
                            </div>
                            
                            <div class="form-group full-width">
                                <label for="konten">Content</label>
                                <textarea id="konten" name="konten" placeholder="Enter full news content..."></textarea>
                            </div>
                            
                            <div class="form-group">
                                <label for="foto">News Image</label>
                                <input type="file" id="foto" name="foto" accept="image/*" onchange="previewImage(this)">
                                <img id="imagePreview" class="image-preview" alt="Preview">
                            </div>
                            
                            <div class="form-actions">
                                <button type="button" class="btn btn-secondary" onclick="resetForm()">Reset</button>
                                <button type="submit" class="btn btn-primary" id="submitBtn">Publish News</button>
                            </div>
                        </form>
</div>
                    
                    <!-- News List -->
                    <div class="news-list-section">
                        <h2 class="section-title">Published News</h2>
                        <div id="newsList">
                            <!-- News items will be loaded here -->
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        let isEditMode = false;
        let currentNewsId = null;

        // Load news on page load
        document.addEventListener('DOMContentLoaded', function() {
            loadNews();
        });

        // Form submission
        document.getElementById('newsForm').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            const submitBtn = document.getElementById('submitBtn');
            
            submitBtn.disabled = true;
            submitBtn.textContent = isEditMode ? 'Updating...' : 'Publishing...';
            
            let url = '/berita';
            let method = 'POST';
            
            if (isEditMode && currentNewsId) {
                url = `/berita/${currentNewsId}`;
                method = 'PUT';
                formData.append('_method', 'PUT');
            }
            
            fetch(url, {
                method: method === 'PUT' ? 'POST' : method,
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                },
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.message) {
                    alert(data.message);
                    resetForm();
                    loadNews();
                } else if (data.error) {
                    alert('Error: ' + data.error);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Error saving news');
            })
            .finally(() => {
                submitBtn.disabled = false;
                submitBtn.textContent = isEditMode ? 'Update News' : 'Publish News';
            });
        });

        function loadNews() {
            fetch('/berita')
                .then(response => response.json())
                .then(data => {
                    if (data.berita) {
                        displayNews(data.berita);
                    }
                })
                .catch(error => {
                    console.error('Error loading news:', error);
                });
        }

        function displayNews(newsList) {
            const newsListContainer = document.getElementById('newsList');
            
            if (newsList.length === 0) {
                newsListContainer.innerHTML = `
                    <div class="empty-state">
                        <p>No news published yet</p>
                        <p>Start by adding your first news article above</p>
                    </div>
                `;
                return;
            }
            
            newsListContainer.innerHTML = newsList.map(news => `
                <div class="news-item">
                    <img src="${news.foto ? '/storage/' + news.foto : 'https://via.placeholder.com/80x80?text=News'}" 
                         alt="${news.judul_berita}" class="news-image">
                    <div class="news-content">
                        <div class="news-title">${news.judul_berita}</div>
                        <div class="news-description">${news.deskripsi ? news.deskripsi.substring(0, 100) + '...' : 'No description'}</div>
                        <div class="news-date">${news.created_at ? new Date(news.created_at).toLocaleDateString() : 'No date'}</div>
                    </div>
                    <div class="news-actions">
                        <button class="btn-icon" onclick="editNews(${news.id_berita})">✏️</button>
                        <button class="btn-danger" onclick="deleteNews(${news.id_berita})">Delete</button>
                    </div>
                </div>
            `).join('');
        }

        function editNews(id) {
            fetch(`/berita/${id}`)
                .then(response => response.json())
                .then(data => {
                    if (data.berita) {
                        const news = data.berita;
                        
                        isEditMode = true;
                        currentNewsId = id;
                        
                        document.getElementById('judul_berita').value = news.judul_berita || '';
                        document.getElementById('judul').value = news.judul || '';
                        document.getElementById('deskripsi').value = news.deskripsi || '';
                        document.getElementById('konten').value = news.konten || '';
                        
                        document.getElementById('submitBtn').textContent = 'Update News';
                        
                        // Scroll to form
                        document.querySelector('.news-form-section').scrollIntoView({ behavior: 'smooth' });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error loading news data');
                });
        }

        function deleteNews(id) {
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
                        loadNews();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Error deleting news');
                });
            }
        }

        function resetForm() {
            document.getElementById('newsForm').reset();
            document.getElementById('imagePreview').style.display = 'none';
            isEditMode = false;
            currentNewsId = null;
            document.getElementById('submitBtn').textContent = 'Publish News';
        }

        function previewImage(input) {
            const preview = document.getElementById('imagePreview');
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function performLogout() {
            var form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("logout") }}';
            
            var csrfToken = document.createElement('input');
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
