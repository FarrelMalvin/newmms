<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- viewport: checked responsive -->
    <title>Mifta Motor Sport</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Montserrat:wght@500;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <style>
        .appointment-title-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 6rem;
        }
        .appointment-title {
            margin-bottom: 2px;
        }
        .appointment-title-underline-svg {
            margin-top: 0;
        }
        .appointment-form-modern {
            background: #FFE4C6;
            padding: 2rem 1rem;
            border-radius: 0.5rem;
            max-width: 100%;
            margin: 0 auto;
        }
        .appointment-row {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 1.2rem;
            flex-wrap: wrap;
        }
        .appointment-input {
            display: flex;
            align-items: center;
            background: #fff;
            border-radius: 0.4rem;
            padding: 0.5rem 1rem;
            flex: 1 1 220px;
            min-width: 220px;
            position: relative;
        }
        .appointment-input .icon {
            margin-right: 0.7rem;
            display: flex;
            align-items: center;
        }
        .appointment-input input,
        .appointment-input select {
            border: none;
            outline: none;
            background: transparent;
            font-size: 1rem;
            width: 100%;
            padding: 0.4rem 0;
        }
        .btn-modern {
            background: #FE8400;
            color: #fff;
            border: none;
            border-radius: 0.4rem;
            padding: 0.8rem 2.2rem;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            align-self: stretch;
            margin-left: 1rem;
            transition: background 0.2s;
        }
        .btn-modern:hover {
            background: #ff9900;
        }
        @media (max-width: 900px) {
            .appointment-row {
                flex-direction: column;
                gap: 1rem;
            }
            .btn-modern {
            width: 100%;
                margin-left: 0;
                margin-top: 1rem;
            }
        }
    </style>
    <style>
    .testimonial-scroll-btn {
        background: #fff;
        border: 1px solid #FE8400;
        color: #FE8400;
        border-radius: 50%;
        width: 40px;
        height: 40px;
        font-size: 1.5rem;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        position: absolute;
        top: 50%;
        transform: translateY(-50%);
        z-index: 2;
        box-shadow: 0 2px 8px rgba(0,0,0,0.08);
        opacity: 0.8;
        transition: background 0.2s;
    }
    .testimonial-scroll-btn:hover {
        background: #FE8400;
        color: #fff;
    }
    .testimonial-scroll-left { left: 0; }
    .testimonial-scroll-right { right: 0; }
    .testimonial-container { position: relative; }
    </style>
    <style>
        .testimonial-container {
        overflow-x: auto;
        white-space: nowrap;
        scrollbar-width: none;
        -ms-overflow-style: none;
    }
        .testimonial-cards-wrapper {
            display: flex;
            gap: 2rem;
    }
        .testimonial-card-custom {
        min-width: 340px;
        max-width: 340px;
        display: inline-block;
        background: #fff;
            border-radius: 0.5rem;
            box-shadow: 0px 5px 20px 0px rgba(0,0,0,0.07);
            padding: 3rem 2rem;
            text-align: center;
        white-space: normal !important;
        overflow: hidden;
        word-break: break-word;
    }
    .testimonial-card-custom p {
        white-space: normal !important;
        word-break: break-word;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100%;
            margin-bottom: 1.5rem;
        }
    </style>
</head>
<body>
    <header>
        <div class="header-left">
            <div class="logo">
                <img src="/images/logo.png" alt="Mifta Motor Sport Logo">
            </div>
        </div>
        <div class="header-right">
            <nav>
                <a href="#services">Service</a>
                <a href="#product">Product</a>
                <a href="#testimonial">Testimonial</a>
                <a href="/customer/dashboard">Customer Dashboard</a>
            </nav>
            @auth
            <div class="account-dropdown" style="position:relative;">
                <button class="btn-login" id="accountDropdownBtn" style="background:#FE8400;color:#fff;border:none;padding:0.5em 1.2em;border-radius:0.4em;cursor:pointer;">
                    {{ Auth::user()->nama ?? Auth::user()->username }} &#x25BC;
                </button>
                <div class="dropdown-content" id="accountDropdownMenu" style="display:none;position:absolute;right:0;top:2.8em;background:#fff;border:1px solid #eee;border-radius:0.4em;box-shadow:0 2px 8px rgba(0,0,0,0.08);min-width:120px;z-index:9999;margin-top:0.5em;">
                    <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                        @csrf
                        <button type="submit" style="background:none;border:none;padding:0.7em 1.2em;width:100%;text-align:left;cursor:pointer;color:#333;">Logout</button>
                    </form>
                </div>
            </div>
            <script>
            document.addEventListener('DOMContentLoaded', function() {
                var btn = document.getElementById('accountDropdownBtn');
                var dropdown = document.getElementById('accountDropdownMenu');
                if(btn && dropdown) {
                    btn.addEventListener('click', function(e) {
                        e.preventDefault();
                        dropdown.style.display = dropdown.style.display === 'block' ? 'none' : 'block';
                    });
                    document.addEventListener('click', function(e) {
                        if (!btn.contains(e.target) && !dropdown.contains(e.target)) {
                            dropdown.style.display = 'none';
                        }
                    });
                }
            });
            </script>
            @else
            <div style="display: flex; gap: 0.5rem;">
                <a href="/login" class="btn-login">Login</a>
                <a href="{{ route('register') }}" class="btn-register">Register</a>
            </div>
            @endauth
        </div>
    </header>
    <div class="hero">
        <div class="hero-left">
            <div class="hero-title">
                <h1>Professional Care and Sales for Every Ride</h1>
            </div>
            <div class="hero-desc">
                <h2>Mifta Motor Sport offers everything your ride needs, in one place.</h2>
            </div>
            <button class="hero-btn">Book Now</button>
        </div>
        <div class="hero-right">    
         <img src="/images/tampilan1.png" alt="Hero Image">
        </div>
       
    </div>
    <div class="section about" id="about">
        <div class="about-content">
            <h2 class="section-title" style="text-align:center; ">Get to Know Us</h2>
            <div class="section-divider"></div> 
            <div class="about-text">
                <div class="about-image">
                    <img src="{{asset('images/tampilan2.png')}}" alt="About Us Image">
                </div>
                <div class="about-description">
                    <p>Mifta Motor Sport is your one-stop destination for premium motorbike service and trusted sales. We combine expert care with a curated selection of high-performance motorcycles to keep every ride smooth, powerful, and reliable.
                       
                    </p>
                     <a class="link" href="#services">Explore Our Services</a>
                </div>  
            </div>
        </div>
    </div>
    <div class="services-section" id="services">
        <h2 class="services-title">Our Premium Services</h2>
        <div class="section-divider"></div>
        <div class="services" style="display: flex; gap: 1.5rem; justify-content: center; align-items: flex-start;">
            <div class="service-card" style="background: #FFF; border-radius: 0.25rem; box-shadow: 0px 5px 20px 0px rgba(0,0,0,0.07); width: 17.3125rem; height: 20.125rem; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 1.125rem; text-align: center;">
                <img src="/images/fluent-mdl2_repair.jpg" alt="Expert Bike Care" style="width:56px; height:56px; object-fit:contain; margin-bottom:0.5rem;" />
                <h3 style="font-size: 1.12rem; font-weight: 600; margin-bottom: 0.25rem;">Expert Bike Care</h3>
                <p style="font-size: 0.97rem; color: #575757;">Pro maintenance for peak performance.</p>
            </div>
            <div class="service-card" style="background: #FFF; border-radius: 0.25rem; box-shadow: 0px 5px 20px 0px rgba(0,0,0,0.07); width: 17.3125rem; height: 20.125rem; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 1.125rem; text-align: center;">
                <img src="/images/mdi_motor-outline.png" alt="Quality Parts" style="width:56px; height:56px; object-fit:contain; margin-bottom:0.5rem;" />
                <h3 style="font-size: 1.12rem; font-weight: 600; margin-bottom: 0.25rem;">Quality Parts</h3>
                <p style="font-size: 0.97rem; color: #575757;">Reliable components for lasting performance.</p>
            </div>
            <div class="service-card" style="background: #FFF; border-radius: 0.25rem; box-shadow: 0px 5px 20px 0px rgba(0,0,0,0.07); width: 17.3125rem; height: 20.125rem; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 1.125rem; text-align: center;">
                <img src="/images/fluent-mdl2_repair.jpg" alt="Showroom" style="width:56px; height:56px; object-fit:contain; margin-bottom:0.5rem;" />
                <h3 style="font-size: 1.12rem; font-weight: 600; margin-bottom: 0.25rem;">Service</h3>
                <p style="font-size: 0.97rem; color: #575757;">Service premium bikes and other motorbikes for ready to ride.</p>
            </div>
        </div>
    </div>
    <!-- Book Your Appointment Title and Underline OUTSIDE the peach background -->
    <div class="appointment-title-container">
        <h2 class="appointment-title">Book Your Appointment</h2>
        <div class="section-divider"></div>
    </div>
    <div class="appointment-section" id="appointment" style="background: #FFE4C6;">
        <form method="POST" action="{{ route('service.store') }}" class="appointment-form-modern">
            @csrf
            <div class="appointment-row">
                <div class="appointment-input">
                    <span class="icon">📅</span>
                    <input type="date" id="tanggal" name="tanggal" placeholder="Service Date" required>
                </div>
                <div class="appointment-input">
                    <span class="icon">📍</span>
                    <select id="id_cabang" name="id_cabang" required>
                        <option value="">Service Location</option>
                        <!-- Option diisi JS -->
                    </select>
                </div>
                <div class="appointment-input">
                    <span class="icon">🛠️</span>
                    <select id="id_tipe_service" name="id_tipe_service" required>
                        <option value="">Service Type</option>
                        <!-- Option diisi JS -->
                    </select>
                </div>
            </div>
            <div class="appointment-row">
                <div class="appointment-input">
                    <span class="icon">⏰</span>
                    <select id="jadwal" name="jadwal" required>
                        <option value="">Service Time</option>
                    </select>
                </div>
                <div class="appointment-input">
                    <span class="icon">ℹ️</span>
                    <input type="text" id="keluhan" name="keluhan" placeholder="Describe Your Issue">
                </div>
                <button type="submit" class="btn-modern">Book Now</button>
            </div>
            <div id="slot-error" style="color:#d00; margin-top:0.5rem; display:none;">Tidak ada slot tersedia untuk tanggal & cabang ini.</div>
            @auth
                <input type="hidden" name="id_pengguna" value="{{ Auth::user()->id_pengguna }}">
            @endauth
        </form>
    </div>
    <div class="collection-section" id="product">
        <div style="display: flex; flex-direction: column; align-items: center; margin-bottom: 2.5rem;">
            <h2 class="collection-title-custom">Our Exclusive Collection</h2>
            <span class="collection-underline">
                <svg width="100%" height="2" viewBox="0 0 352 2" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="352" height="2" rx="1" fill="#FE8400"/>
                </svg>
            </span>
        </div>
        <div class="collections">
            @if($products->count() > 0)
                @foreach($products as $product)
                <div class="collection-card" style="width:320px;max-width:100vw;display:flex;flex-direction:column;height:100%;border:1.5px solid #e5e7eb;box-shadow:none;">
                    <div class="card-image" style="width:100%;height:220px;overflow:hidden;border-radius:0.28rem 0.28rem 0 0;">
                        <img src="{{ asset('storage/' . $product->gambar_produk) }}" alt="{{ $product->nama_produk }}" style="width:100%;height:100%;object-fit:cover;display:block;">
                    </div>
                    <div class="card-content" style="padding:1.25rem 1.25rem 0.5rem 1.25rem;flex:1 1 auto;display:flex;flex-direction:column;gap:0.5rem;">
                        <h3 style="font-size:1.25rem;font-weight:700;margin:0 0 0.25rem 0;">{{ $product->nama_produk }}</h3>
                        <div style="font-size:1.05rem;color:#575757;margin-bottom:0.25rem;display:flex;align-items:center;gap:0.5rem;">
                            <span style="font-size:1.1rem;">&#128690;</span> {{ $product->kategori ?? 'Motor Sport' }}
                        </div>
                        <div style="display:flex;align-items:center;justify-content:flex-end;gap:0.5vw;margin-top:0.5vw;">
                            <div style="font-size:1.15vw;font-weight:700;color:#FE8400;flex:1;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">Rp{{ number_format($product->harga, 0, ',', '.') }}</div>
                            <a href="https://wa.me/6285708150434?text=Halo%20saya%20tertarik%20dengan%20produk%20{{ urlencode($product->nama_produk) }}" target="_blank" rel="noopener" style="display:flex;align-items:center;justify-content:center;padding:0.5vw 1.5vw;border-radius:0.25vw;background:#FE8400;color:#fff;font-weight:700;font-size:1.1vw;min-width:8vw;max-width:13vw;height:2.5vw;text-decoration:none;transition:background 0.2s;flex:0 0 auto;">Contact Me</a>
                        </div>
                    </div>
                </div>
                @endforeach
            @else
                <div class="no-products-message">
                    <p>No products available at the moment.</p>
                </div>
            @endif
        </div>
    </div>
    <!-- Testimonial Section sesuai Figma -->
    <div class="testimonial-section" id="testimonial">
        <div style="display: flex; flex-direction: column; align-items: center; margin-bottom: 2.5rem;">
            <h2 class="testimonial-title-custom">What Our Clients Say?</h2>
            <span class="testimonial-underline">
                <svg width="100%" height="2" viewBox="0 0 352 2" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect width="352" height="2" rx="1" fill="#FE8400"/>
                </svg>
            </span>
        </div>
        <div class="testimonial-container" style="overflow-x:auto;white-space:nowrap;scrollbar-width:none;-ms-overflow-style:none;position:relative;">
            <div class="testimonial-cards-wrapper" id="testimonialWrapper" style="display:flex;gap:2rem;">
                @if($testimonials->count() > 0)
                    @foreach($testimonials as $testimonial)
                    <div class="testimonial-card-custom" style="min-width:340px;max-width:340px;display:inline-block;">
                        <div class="testimonial-avatar" style="width:80px;height:80px;border-radius:50%;background:linear-gradient(135deg,#FE8400,#ff9900);display:flex;align-items:center;justify-content:center;margin-bottom:1.5rem;font-size:2rem;color:white;font-weight:bold;">
                            {{ strtoupper(substr($testimonial->pengguna->nama ?? 'U', 0, 1)) }}
                        </div>
                        <h4 style="font-family: 'Montserrat', sans-serif; font-size: 1.1rem; font-weight: 600; color: #141414; margin-bottom: 0.5rem;">{{ $testimonial->pengguna->nama ?? 'Anonymous' }}</h4>
                        <p style="font-size: 1rem; color: #575757; text-align: center;">"{{ $testimonial->isi_testimoni }}"</p>
                        <div class="testimonial-rating" style="display:flex;justify-content:center;gap:0.25rem;margin-top:0.5rem;">
                                @for($i = 1; $i <= 5; $i++)
                                <span class="star" style="color:#FFD700;font-size:1.2rem;">{{ $i <= $testimonial->rating_bintang ? '★' : '☆' }}</span>
                                @endfor
                        </div>
                    </div>
                    @endforeach
                @else
                    <div class="testimonial-card-custom">
                        <div class="testimonial-avatar">N</div>
                        <h4 style="font-family: 'Montserrat', sans-serif; font-size: 1.1rem; font-weight: 600; color: #141414; margin-bottom: 0.5rem;">No testimonials yet</h4>
                        <p style="font-size: 1rem; color: #575757; text-align: center;">"Excellent service! My bike runs perfectly now."</p>
                        <div class="testimonial-rating" style="display:flex;justify-content:center;gap:0.25rem;margin-top:0.5rem;">
                            <span class="star" style="color:#FFD700;font-size:1.2rem;">★</span>
                            <span class="star" style="color:#FFD700;font-size:1.2rem;">★</span>
                            <span class="star" style="color:#FFD700;font-size:1.2rem;">★</span>
                            <span class="star" style="color:#FFD700;font-size:1.2rem;">★</span>
                            <span class="star" style="color:#FFD700;font-size:1.2rem;">★</span>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
    <div class="stats-section">
        <div class="stat">
            <div class="number">450+</div>
            <div class="label">Bikes Under Service</div>
        </div>
        <div class="stat">
            <div class="number">800+</div>
            <div class="label">Happy Clients</div>
        </div>
        <div class="stat">
            <div class="number">750+</div>
            <div class="label">Rental Locations</div>
        </div>
    </div>
    <footer>
        <div class="footer-row">
            <div class="footer-logo">
                <img src="/images/logo.png" alt="Logo" />
            </div>
            <div class="footer-contact">Need help? Please call <span style="color:var(--orange);">+62 812-3456-7890</span></div>
        </div>
        <div class="footer-social">
            <a href="#"><span style="font-family:Arial;">&#xf09a;</span></a>
            <a href="#"><span style="font-family:Arial;">&#xf099;</span></a>
            <a href="#"><span style="font-family:Arial;">&#xf16d;</span></a>
            <a href="#"><span style="font-family:Arial;">&#xf0e1;</span></a>
        </div>
    </footer>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
    const dateInput = document.getElementById('tanggal');
    const cabangInput = document.getElementById('id_cabang');
    const jadwalSelect = document.getElementById('jadwal');
    const slotError = document.getElementById('slot-error');

    // Fetch cabang
    fetch('/service-cabang')
        .then(res => res.json())
        .then(data => {
            const select = document.getElementById('id_cabang');
            select.innerHTML = '<option value="">Service Location</option>';
            data.forEach(cabang => {
                const opt = document.createElement('option');
                opt.value = cabang.id_cabang;
                opt.textContent = cabang.nama_cabang;
                select.appendChild(opt);
            });
        });

    // Fetch tipe service
    fetch('/service-types')
        .then(res => res.json())
        .then(data => {
            const select = document.getElementById('id_tipe_service');
            select.innerHTML = '<option value="">Service Type</option>';
            data.forEach(type => {
                const opt = document.createElement('option');
                opt.value = type.id_tipe_service;
                opt.textContent = type.nama_service;
                select.appendChild(opt);
            });
        });

    function updateSlot() {
        const date = dateInput.value;
        const cabang = cabangInput.value;
        if (!date || !cabang) return;

        fetch(`/validate-slot?date=${date}&id_cabang=${cabang}`)
            .then(res => res.json())
            .then(data => {
                jadwalSelect.innerHTML = '<option value="">Service Time</option>';
                let available = false;
                data.forEach(slot => {
                    const opt = document.createElement('option');
                    opt.value = slot.time;
                    opt.textContent = `${slot.time} ${!slot.available ? `(${slot.reason})` : ''}`;
                    opt.disabled = !slot.available;
                    if (slot.available) available = true;
                    jadwalSelect.appendChild(opt);
                });
                slotError.style.display = available ? 'none' : 'block';
            });
    }

    dateInput.addEventListener('change', updateSlot);
    cabangInput.addEventListener('change', updateSlot);
});
</script>
    <script>
    // Testimonial auto-scroll kanan-kiri bolak-balik + tombol manual
        document.addEventListener('DOMContentLoaded', function() {
            const wrapper = document.getElementById('testimonialWrapper');
            if (!wrapper) return;
        let direction = 1; // 1 = kanan, -1 = kiri
        let scrollStep = 1;
        let interval = null;
        function startAutoScroll() {
            if (interval) clearInterval(interval);
            interval = setInterval(() => {
                const maxScroll = wrapper.scrollWidth - wrapper.clientWidth;
                if (direction === 1 && wrapper.scrollLeft >= maxScroll) {
                    direction = -1;
                } else if (direction === -1 && wrapper.scrollLeft <= 0) {
                    direction = 1;
                }
                wrapper.scrollLeft += scrollStep * direction;
            }, 20);
        }
        startAutoScroll();
        // Pause on hover
        wrapper.addEventListener('mouseenter', () => { if (interval) clearInterval(interval); });
        wrapper.addEventListener('mouseleave', startAutoScroll);
        // Responsive: update scroll on resize
        window.addEventListener('resize', () => {
            // No-op, but could update card width if dynamic
        });
        });
    </script>
</body>
</html>