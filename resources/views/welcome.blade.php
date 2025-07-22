<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mifta Motor Sport</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Montserrat:wght@500;700&display=swap" rel="stylesheet">

    <style>
        :root {
            --orange: #FE8400;
            --peach: #FFE4C6;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            line-height: 1.6;
        }

        /* Header Styles */
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 5%;
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: relative;
            z-index: 1000;
        }

        .header-left .logo img {
            height: 60px;
            width: auto;
        }

        .header-right {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        nav {
            display: flex;
            gap: 2rem;
        }

        nav a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            transition: color 0.3s;
        }

        nav a:hover {
            color: var(--orange);
        }

        .btn-login, .btn-register {
            padding: 0.5rem 1.5rem;
            text-decoration: none;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s;
        }

        .btn-login {
            background: transparent;
            color: var(--orange);
            border: 2px solid var(--orange);
        }

        .btn-login:hover {
            background: var(--orange);
            color: white;
        }

        .btn-register {
            background: var(--orange);
            color: white;
            border: 2px solid var(--orange);
        }

        .btn-register:hover {
            background: #ff9900;
            border-color: #ff9900;
        }

        /* Hamburger Menu */
        .hamburger {
            display: none;
            flex-direction: column;
            cursor: pointer;
            padding: 0.5rem;
        }

        .hamburger span {
            width: 25px;
            height: 3px;
            background: #333;
            margin: 3px 0;
            transition: 0.3s;
            border-radius: 2px;
        }

        .hamburger.active span:nth-child(1) {
            transform: rotate(-45deg) translate(-5px, 6px);
        }

        .hamburger.active span:nth-child(2) {
            opacity: 0;
        }

        .hamburger.active span:nth-child(3) {
            transform: rotate(45deg) translate(-5px, -6px);
        }

        /* Mobile Menu */
        .mobile-menu {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100vh;
            background: rgba(0,0,0,0.5);
            z-index: 999;
        }

        .mobile-menu.active {
            display: block;
        }

        .mobile-menu-content {
            position: absolute;
            top: 0;
            right: -300px;
            width: 300px;
            height: 100%;
            background: white;
            padding: 2rem;
            transition: right 0.3s ease;
            box-shadow: -2px 0 10px rgba(0,0,0,0.1);
        }

        .mobile-menu.active .mobile-menu-content {
            right: 0;
        }

        .mobile-menu-close {
            position: absolute;
            top: 1rem;
            right: 1rem;
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: #333;
        }

        .mobile-nav {
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            margin-top: 3rem;
        }

        .mobile-nav a {
            text-decoration: none;
            color: #333;
            font-weight: 500;
            padding: 0.75rem 0;
            border-bottom: 1px solid #eee;
            transition: color 0.3s;
        }

        .mobile-nav a:hover {
            color: var(--orange);
        }

        .mobile-auth-buttons {
            display: flex;
            flex-direction: column;
            gap: 1rem;
            margin-top: 2rem;
        }

        .mobile-auth-buttons .btn-login,
        .mobile-auth-buttons .btn-register {
            text-align: center;
            display: block;
        }

        /* Hero Section */
        .hero {
            display: flex;
            align-items: center;
            padding: 4rem 5%;
            min-height: 70vh;
            background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        }

        .hero-left {
            flex: 1;
            padding-right: 2rem;
        }

        .hero-title h1 {
            font-size: 3rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .hero-desc h2 {
            font-size: 1.2rem;
            font-weight: 400;
            color: #666;
            margin-bottom: 2rem;
        }

        .hero-btn {
            background: var(--orange);
            color: white;
            border: none;
            padding: 1rem 2rem;
            border-radius: 0.5rem;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }

        .hero-btn:hover {
            background: #ff9900;
        }

        .hero-right {
            flex: 1;
        }

        .hero-right img {
            width: 100%;
            height: auto;
            border-radius: 1rem;
        }

        /* Section Styles */
        .section {
            padding: 4rem 5%;
        }

        .section-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 1rem;
        }

        .section-divider {
            width: 100px;
            height: 4px;
            background: var(--orange);
            margin: 0 auto 3rem;
            border-radius: 2px;
        }

        /* About Section */
        .about-text {
            display: flex;
            align-items: center;
            gap: 3rem;
        }

        .about-image {
            flex: 1;
        }

        .about-image img {
            width: 100%;
            border-radius: 1rem;
        }

        .about-description {
            flex: 1;
        }

        .about-description p {
            font-size: 1.1rem;
            color: #666;
            margin-bottom: 2rem;
            line-height: 1.8;
        }

        .link {
            color: var(--orange);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s;
        }

        .link:hover {
            color: #ff9900;
        }

        /* Services Section */
        .services-section {
            padding: 4rem 5%;
            background: #f8f9fa;
        }

        .services-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #333;
            text-align: center;
            margin-bottom: 1rem;
        }

        .services {
            display: flex;
            gap: 2rem;
            justify-content: center;
            align-items: flex-start;
            flex-wrap: wrap;
        }

        .service-card {
            background: white;
            border-radius: 0.5rem;
            box-shadow: 0px 5px 20px rgba(0,0,0,0.1);
            width: 280px;
            height: 320px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 1rem;
            text-align: center;
            padding: 2rem;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .service-card:hover {
            transform: translateY(-5px);
            box-shadow: 0px 10px 30px rgba(0,0,0,0.15);
        }

        .service-card img {
            width: 64px;
            height: 64px;
            object-fit: contain;
        }

        .service-card h3 {
            font-size: 1.2rem;
            font-weight: 600;
            color: #333;
        }

        .service-card p {
            font-size: 1rem;
            color: #666;
        }

        /* Appointment Styles */
        .appointment-title-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 3rem;
            padding: 2rem 0;
        }

        .appointment-title {
            font-size: 2.5rem;
            font-weight: 700;
            color: #333;
            margin-bottom: 1rem;
        }

        .appointment-section {
            background: var(--peach);
            padding: 3rem 5%;
        }

        .appointment-form-modern {
            background: var(--peach);
            padding: 2rem;
            border-radius: 0.5rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .appointment-row {
            display: flex;
            gap: 1.5rem;
            margin-bottom: 1.5rem;
            flex-wrap: wrap;
        }

        .appointment-input {
            display: flex;
            align-items: center;
            background: white;
            border-radius: 0.5rem;
            padding: 0.75rem 1rem;
            flex: 1;
            min-width: 250px;
        }

        .appointment-input .icon {
            margin-right: 0.75rem;
            font-size: 1.2rem;
        }

        .appointment-input input,
        .appointment-input select {
            border: none;
            outline: none;
            background: transparent;
            font-size: 1rem;
            width: 100%;
            padding: 0.5rem 0;
        }

        .btn-modern {
            background: var(--orange);
            color: white;
            border: none;
            border-radius: 0.5rem;
            padding: 1rem 2rem;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
            white-space: nowrap;
        }

        .btn-modern:hover {
            background: #ff9900;
        }

        /* Collection Section */
        .collection-section {
            padding: 4rem 5%;
        }

        .collection-title-custom {
            font-size: 2.5rem;
            font-weight: 700;
            color: #333;
            text-align: center;
            margin-bottom: 1rem;
        }

        .collections {
            display: flex;
            gap: 2rem;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 3rem;
        }

        .collection-card {
            width: 300px;
            height: 400px;
            border-radius: 1rem;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0,0,0,0.1);
            position: relative;
            background: linear-gradient(45deg, #667eea 0%, #764ba2 100%);
        }

        .collection-card .info {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            background: rgba(255,255,255,0.95);
            padding: 1.5rem;
        }

        .collection-card h4 {
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .collection-card p {
            color: #666;
            margin-bottom: 1rem;
        }

        .price {
            font-size: 1.2rem;
            font-weight: 700;
            color: var(--orange);
            margin-bottom: 1rem;
        }

        .btn {
            background: var(--orange);
            color: white;
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            cursor: pointer;
            transition: background 0.3s;
        }

        .btn:hover {
            background: #ff9900;
        }

        .see-more-btn {
            display: block;
            margin: 0 auto;
            background: transparent;
            color: var(--orange);
            border: 2px solid var(--orange);
            padding: 1rem 2rem;
            border-radius: 0.5rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }

        .see-more-btn:hover {
            background: var(--orange);
            color: white;
        }

        /* Testimonial Section */
        .testimonial-section {
            padding: 4rem 5%;
            background: #f8f9fa;
        }

        .testimonial-title-custom {
            font-size: 2.5rem;
            font-weight: 700;
            color: #333;
            text-align: center;
            margin-bottom: 1rem;
        }

        .testimonial-cards-row {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 2rem;
        }

        .testimonial-nav-btn {
            background: var(--orange);
            color: white;
            border: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            font-size: 1.2rem;
            cursor: pointer;
            transition: background 0.3s;
        }

        .testimonial-nav-btn:hover {
            background: #ff9900;
        }

        .testimonial-card-custom {
            background: white;
            padding: 2rem;
            border-radius: 1rem;
            text-align: center;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            max-width: 300px;
        }

        .testimonial-avatar {
            width: 80px;
            height: 80px;
            border-radius: 50%;
            margin: 0 auto 1rem;
            object-fit: cover;
        }

        /* Stats Section */
        .stats-section {
            display: flex;
            justify-content: space-around;
            align-items: center;
            padding: 4rem 5%;
            background: var(--orange);
            color: white;
        }

        .stat {
            text-align: center;
        }

        .number {
            font-size: 3rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .label {
            font-size: 1.1rem;
        }

        /* Help Section */
        .help-section-bg {
            padding: 4rem 5%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            position: relative;
        }

        .help-title-custom {
            font-size: 2.5rem;
            font-weight: 700;
            color: white;
            text-align: center;
            margin-bottom: 1rem;
        }

        .help-container-custom {
            display: flex;
            gap: 3rem;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
        }

        .contact-form {
            flex: 1;
            background: white;
            padding: 2rem;
            border-radius: 1rem;
        }

        .contact-form input,
        .contact-form textarea {
            width: 100%;
            padding: 1rem;
            margin-bottom: 1rem;
            border: 1px solid #ddd;
            border-radius: 0.5rem;
            font-size: 1rem;
        }

        .contact-form textarea {
            height: 120px;
            resize: vertical;
        }

        .contact-image {
            flex: 1;
        }

        .contact-image img {
            width: 100%;
            max-width: 400px;
            border-radius: 1rem;
        }

        /* Footer */
        footer {
            background: #333;
            color: white;
            padding: 2rem 5%;
        }

        .footer-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .footer-logo img {
            height: 50px;
        }

        .footer-social {
            display: flex;
            gap: 1rem;
        }

        .footer-social a {
            color: white;
            text-decoration: none;
            font-size: 1.5rem;
            transition: color 0.3s;
        }

        .footer-social a:hover {
            color: var(--orange);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .header-right nav,
            .header-right > div {
                display: none;
            }

            .hamburger {
                display: flex;
            }

            .hero {
                flex-direction: column;
                text-align: center;
                padding: 2rem 5%;
            }

            .hero-left {
                padding-right: 0;
                margin-bottom: 2rem;
            }

            .hero-title h1 {
                font-size: 2rem;
            }

            .about-text {
                flex-direction: column;
                text-align: center;
            }

            .services {
                flex-direction: column;
                align-items: center;
            }

            .appointment-row {
                flex-direction: column;
            }

            .btn-modern {
                width: 100%;
            }

            .collections {
                flex-direction: column;
                align-items: center;
            }

            .testimonial-cards-row {
                flex-direction: column;
            }

            .testimonial-nav-btn {
                display: none;
            }

            .stats-section {
                flex-direction: column;
                gap: 2rem;
            }

            .help-container-custom {
                flex-direction: column;
            }

            .footer-row {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
            }

            .section-title,
            .services-title,
            .appointment-title,
            .collection-title-custom,
            .testimonial-title-custom,
            .help-title-custom {
                font-size: 2rem;
            }
        }

        @media (max-width: 480px) {
            header {
                padding: 1rem 3%;
            }

            .section,
            .services-section,
            .appointment-section,
            .collection-section,
            .testimonial-section,
            .help-section-bg {
                padding: 2rem 3%;
            }

            .hero-title h1 {
                font-size: 1.5rem;
            }

            .service-card {
                width: 100%;
                max-width: 280px;
            }

            .collection-card {
                width: 100%;
                max-width: 300px;
            }

            .mobile-menu-content {
                width: 280px;
            }
        }
    </style>
    </head>
    <body>
    <header>
        <div class="header-left">
            <div class="logo">
                <img src=<img src="/images/logo.png" alt="Mifta Motor Sport Logo">
            </div>
        </div>
        <div class="header-right">
            <nav>
                <a href="#services">Service</a>
                <a href="#product">Product</a>
                <a href="#testimonial">Testimonial</a>
                <a href="#help">Help</a>
            </nav>
            <div style="display: flex; gap: 0.5rem;">
                <a href="/login" class="btn-login">Login</a>
                <a href="/signup" class="btn-register">Register</a>
            </div>
        </div>
        <div class="hamburger" id="hamburger">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </header>

    <!-- Mobile Menu -->
    <div class="mobile-menu" id="mobileMenu">
        <div class="mobile-menu-content">
            <button class="mobile-menu-close" id="closeMenu">&times;</button>
            <nav class="mobile-nav">
                <a href="#services">Service</a>
                <a href="#product">Product</a>
                <a href="#testimonial">Testimonial</a>
                <a href="#help">Help</a>
            </nav>
            <div class="mobile-auth-buttons">
                <a href="/login" class="btn-login">Login</a>
                <a href="/signup" class="btn-register">Register</a>
            </div>
        </div>
    </div>

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
            <h2 class="section-title" style="text-align:center;">Get to Know Us</h2>
            <div class="section-divider"></div> 
            <div class="about-text">
                <div class="about-image">
                <img src="{{asset('images/tampilan2.png')}}" alt="About Us Image">
                </div>
                <div class="about-description">
                    <p>Mifta Motor Sport is your one-stop destination for premium motorbike service and trusted sales. We combine expert care with a curated selection of high-performance motorcycles to keep every ride smooth, powerful, and reliable.</p>
                     <a class="link" href="#services">Explore Our Services</a>
                </div>  
            </div>
        </div>
    </div>
    
    <div class="services-section" id="services">
        <h2 class="services-title">Our Premium Services</h2>
        <div class="section-divider"></div>
        <div class="services">
            <div class="service-card">
                <img src="https://via.placeholder.com/64x64/FE8400/FFFFFF?text=🔧" alt="Expert Bike Care" />
                <h3>Expert Bike Care</h3>
                <p>Pro maintenance for peak performance.</p>
            </div>
            <div class="service-card">
                <img src="https://via.placeholder.com/64x64/FE8400/FFFFFF?text=🏍️" alt="Quality Parts" />
                <h3>Quality Parts</h3>
                <p>Reliable components for lasting performance.</p>
            </div>
            <div class="service-card">
                <img src="https://via.placeholder.com/64x64/FE8400/FFFFFF?text=🛠️" alt="Service" />
                <h3>Service</h3>
                <p>Service premium bikes and other motorbikes for ready to ride.</p>
            </div>
        </div>
    </div>
    
    <div class="appointment-title-container">
        <h2 class="appointment-title">Book Your Appointment</h2>
        <div class="section-divider"></div>
    </div>
    
    <div class="appointment-section" id="appointment">
        <form class="appointment-form-modern">
            <div class="appointment-row">
                <div class="appointment-input">
                    <span class="icon">📅</span>
                    <input type="date" id="tanggal" name="tanggal" placeholder="Service Date" required>
                </div>
                <div class="appointment-input">
                    <span class="icon">📍</span>
                    <select id="id_cabang" name="id_cabang" required>
                        <option value="">Service Location</option>
                        <option value="1">Jakarta Branch</option>
                        <option value="2">Surabaya Branch</option>
                        <option value="3">Bandung Branch</option>
                    </select>
                </div>
                <div class="appointment-input">
                    <span class="icon">🛠️</span>
                    <select id="id_tipe_service" name="id_tipe_service" required>
                        <option value="">Service Type</option>
                        <option value="1">Regular Service</option>
                        <option value="2">Premium Service</option>
                        <option value="3">Repair Service</option>
                    </select>
                </div>
            </div>
            <div class="appointment-row">
                <div class="appointment-input">
                    <span class="icon">⏰</span>
                    <select id="jadwal" name="jadwal" required>
                        <option value="">Service Time</option>
                        <option value="09:00">09:00 AM</option>
                        <option value="11:00">11:00 AM</option>
                        <option value="13:00">01:00 PM</option>
                        <option value="15:00">03:00 PM</option>
                    </select>
                </div>
                <div class="appointment-input">
                    <span class="icon">ℹ️</span>
                    <input type="text" id="keluhan" name="keluhan" placeholder="Describe Your Issue">
                </div>
                <button type="submit" class="btn-modern">Book Now</button>
            </div>
        </form>
    </div>
    
    <div class="collection-section" id="product">
        <div style="display: flex; flex-direction: column; align-items: center; margin-bottom: 2.5rem;">
            <h2 class="collection-title-custom">Our Exclusive Collection</h2>
            <div class="section-divider"></div>
        </div>
        <div class="collections">
            <div class="collection-card">
                <div class="info">
                    <h4>Motul Oil</h4>
                    <p>Sparepart</p>
                    <div class="price">Rp350.000</div>
                    <button class="btn">Buy Now</button>
                </div>
            </div>
            <div class="collection-card">
                <div class="info">
                    <h4>Ohlins Suspension Shocks</h4>
                    <p>Motor Part</p>
                    <div class="price">Rp28.900.000</div>
                    <button class="btn">Buy Now</button>
                </div>
            </div>
            <div class="collection-card">
                <div class="info">
                    <h4>Kawasaki H2R</h4>
                    <p>Motor Sport</p>
                    <div class="price">Rp750.000.000</div>
                    <button class="btn">Buy Now</button>
                </div>
            </div>
        </div>
        <button class="see-more-btn">See More</button>
    </div>
    
    <div class="testimonial-section" id="testimonial">
        <div style="display: flex; flex-direction: column; align-items: center; margin-bottom: 2.5rem;">
            <h2 class="testimonial-title-custom">What Our Clients Say?</h2>
            <div class="section-divider"></div>
        </div>
        <div class="testimonial-cards-row">
            <button class="testimonial-nav-btn" id="testimonialLeft">&#8592;</button>
            <div id="testimonialWrapper" style="display: flex; gap: 2rem; overflow-x: auto; scroll-behavior: smooth; max-width: 700px;">
                <div class="testimonial-card-custom">
                    <img src="https://randomuser.me/api/portraits/women/44.jpg" alt="Sophia Lane" class="testimonial-avatar">
                    <h4>Sophia Lane</h4>
                    <p>The service at Mifta Motor Sport was quick and professional. My bike feels smoother than ever.</p>
                </div>
                <div class="testimonial-card-custom">
                    <img src="https://randomuser.me/api/portraits/men/46.jpg" alt="Dylan Scott" class="testimonial-avatar">
                    <h4>Dylan Scott</h4>
                    <p>I found my dream bike at Mifta Motor Sport. The staff were helpful, and the whole process was easy.</p>
                </div>
                <!-- Tambahkan testimonial lain di sini jika perlu -->
            </div>
            <button class="testimonial-nav-btn" id="testimonialRight">&#8594;</button>
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
    
    <div class="help-section-bg" id="help">
        <div style="display: flex; flex-direction: column; align-items: center; margin-bottom: 2.5rem; position: relative; z-index:2;">
            <h2 class="help-title-custom">Need Help from Mifta Motor Sport?</h2>
            <div class="section-divider"></div>
        </div>
        <div class="help-container-custom">
            <form class="contact-form">
                <input type="text" placeholder="Your Name*" required>
                <input type="text" placeholder="Your Phone Number*" required>
                <textarea placeholder="Your Message" required></textarea>
                <button class="btn" type="submit">Send A Message</button>
            </form>
            <div class="contact-image">
                <img src="https://via.placeholder.com/400x300/FE8400/FFFFFF?text=Contact+Us" alt="Contact">
            </div>
        </div>
    </div>
    
    <footer>
        <div class="footer-row">
            <div class="footer-logo">
                <img src="https://via.placeholder.com/120x50/FE8400/FFFFFF?text=MIFTA+MOTOR" alt="Logo" />
            </div>
            <div class="footer-contact">Need help? Please call <span style="color:var(--orange);">+62 812-3456-7890</span></div>
        </div>
        <div class="footer-social">
            <a href="#">📘</a>
            <a href="#">🐦</a>
            <a href="#">📷</a>
            <a href="#">📧</a>
        </div>
    </footer>

    <script>
        // Mobile Menu Toggle
        const hamburger = document.getElementById('hamburger');
        const mobileMenu = document.getElementById('mobileMenu');
        const closeMenu = document.getElementById('closeMenu');

        hamburger.addEventListener('click', () => {
            hamburger.classList.toggle('active');
            mobileMenu.classList.toggle('active');
        });

        closeMenu.addEventListener('click', () => {
            hamburger.classList.remove('active');
            mobileMenu.classList.remove('active');
        });

        // Close menu when clicking outside
        mobileMenu.addEventListener('click', (e) => {
            if (e.target === mobileMenu) {
                hamburger.classList.remove('active');
                mobileMenu.classList.remove('active');
            }
        });

        // Close menu when clicking on nav links
        const mobileNavLinks = document.querySelectorAll('.mobile-nav a');
        mobileNavLinks.forEach(link => {
            link.addEventListener('click', () => {
                hamburger.classList.remove('active');
                mobileMenu.classList.remove('active');
            });
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Form submission handler
        document.querySelector('.appointment-form-modern').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Appointment booking submitted! We will contact you soon.');
        });

        document.querySelector('.contact-form').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('Message sent! We will get back to you soon.');
        });

        // Hero button scroll to appointment
        document.querySelector('.hero-btn').addEventListener('click', function() {
            document.querySelector('#appointment').scrollIntoView({
                behavior: 'smooth',
                block: 'start'
            });
        });
    </script>
    <script>
    // Testimonial auto-scroll kanan-kiri bolak-balik + tombol manual
    document.addEventListener('DOMContentLoaded', function() {
        const wrapper = document.getElementById('testimonialWrapper');
        const btnLeft = document.getElementById('testimonialLeft');
        const btnRight = document.getElementById('testimonialRight');
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
        // Tombol manual
        btnLeft.addEventListener('click', () => {
            wrapper.scrollLeft -= 300;
        });
        btnRight.addEventListener('click', () => {
            wrapper.scrollLeft += 300;
        });
    });
    </script>
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
    </body>
</html>