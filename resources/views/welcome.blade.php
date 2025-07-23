<!DOCTYPE html>
<html lang="en">
    <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> <!-- viewport: checked responsive -->
    <title>Mifta Motor Sport</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&family=Montserrat:wght@500;700&family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --orange: #FE8400;
            --peach: #FFE4C6;
            --main-title-size: 2rem;
            --main-title-weight: 500;
            --main-title-family: 'Montserrat', sans-serif;
            --main-title-color: #141414;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            font-family: 'Poppins', sans-serif;
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
            font-family: 'Inter', sans-serif !important;
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
                margin-left: 0;
                margin-top: 1rem;
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
        @media (max-width: 640px) {
            .header-left .logo img {
                height: 40px !important;
                max-width: 110px !important;
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
    <style>
    /* Product Card Custom Styles */
    .product-card-custom {
        display: flex;
        flex-direction: column;
        background: #fff;
        border-radius: 0.25rem;
        border: 1.5px solid #e5e7eb;
        box-shadow: 0 2px 8px rgba(0,0,0,0.06);
        width: 320px;
        max-width: 100vw;
        margin-bottom: 2rem;
        overflow: hidden;
        transition: box-shadow 0.2s, transform 0.2s;
    }
    .product-card-custom:hover {
        box-shadow: 0 8px 24px rgba(254,132,0,0.13);
        transform: translateY(-4px) scale(1.01);
    }
    .product-image-custom {
        width: 100%;
        height: 200px;
        background: #f7f7f7;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
    }
    .product-image-custom img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        display: block;
    }
    .product-content-custom {
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
        padding: 1.25rem 1.25rem 1rem 1.25rem;
        flex: 1 1 auto;
    }
    .product-title-custom {
        font-size: 1.15rem;
        font-weight: 700;
        margin-bottom: 0.25rem;
        color: #181818;
    }
    .product-category-custom {
        font-size: 1.05rem;
        color: #575757;
        display: flex;
        align-items: center;
        gap: 0.5rem;
        margin-bottom: 0.25rem;
    }
    .product-icon-custom {
        font-size: 1.1rem;
    }
    .product-price-custom {
        font-size: 1.15rem;
        font-weight: 700;
        color: #FE8400;
        margin-bottom: 0.5rem;
    }
    .buy-now-btn-custom {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 6.625rem;
        height: 2.1875rem;
        padding: 0.5rem;
        background: #FE8400;
        color: #fff;
        font-weight: 700;
        font-size: 1.05rem;
        border: none;
        border-radius: 0.25rem;
        text-align: center;
        text-decoration: none;
        margin-top: 0.5rem;
        transition: background 0.2s;
        gap: 0.5rem;
        flex-shrink: 0;
    }
    .buy-now-btn-custom:hover {
        background: #ff9900;
    }
    @media (max-width: 768px) {
        .collections {
            flex-direction: column !important;
            align-items: center !important;
        }
        .product-card-custom {
            width: 100%;
            max-width: 360px;
        }
        .product-image-custom {
            height: 180px;
        }
        .buy-now-btn-custom {
            width: 100%;
            min-width: 0;
            font-size: 1rem;
            padding: 0.9rem 0;
            height: auto;
        }
    }
    @media (max-width: 480px) {
        .product-card-custom {
            width: 100%;
            max-width: 98vw;
        }
        .product-image-custom {
            height: 140px;
        }
        .product-content-custom {
            padding: 1rem 0.7rem 0.8rem 0.7rem;
        }
        .buy-now-btn-custom {
            width: 100%;
            font-size: 0.98rem;
            padding: 1rem 0;
            height: auto;
        }
    }
    </style>
    <style>
.news-section {
    padding: 3rem 5% 2rem 5%;
    background: #fff;
    text-align: center;
}
.news-section .section-title {
    text-align: center !important;
    margin-left: auto;
    margin-right: auto;
}
.news-section .section-divider {
    margin-left: auto;
    margin-right: auto;
}
.news-cards-container {
    display: flex;
    gap: 2rem;
    justify-content: center;
    flex-wrap: wrap;
    margin-bottom: 2rem;
}
.news-card-custom {
    background: #fff;
    border-radius: 0.5rem;
    box-shadow: 0 2px 12px rgba(0,0,0,0.07);
    width: 340px;
    max-width: 98vw;
    display: flex;
    flex-direction: column;
    overflow: hidden;
    border: 1.5px solid #e5e7eb;
    transition: box-shadow 0.2s, transform 0.2s;
    align-items: stretch;
}
.news-card-custom:hover {
    box-shadow: 0 8px 24px rgba(254,132,0,0.13);
    transform: translateY(-4px) scale(1.01);
}
.news-image-custom {
    width: 100%;
    height: 180px;
    background: #f7f7f7;
    display: flex;
    align-items: center;
    justify-content: center;
    overflow: hidden;
}
.news-image-custom img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    display: block;
}
.news-content-custom {
    display: flex;
    flex-direction: column;
    gap: 0.5rem;
    padding: 1.25rem 1.25rem 1rem 1.25rem;
    flex: 1 1 auto;
    align-items: flex-start;
}
.news-title-custom {
    font-size: 1.15rem;
    font-weight: 700;
    color: #181818;
    font-family: 'Poppins', sans-serif;
    margin-bottom: 0.25rem;
    text-align: left;
}
.news-desc-custom {
    font-size: 1rem;
    color: #575757;
    font-family: 'Poppins', sans-serif;
    margin-bottom: 0.5rem;
    text-align: left;
}
.news-readmore-btn {
    background: var(--orange);
    color: #fff;
    border: none;
    border-radius: 0.5rem;
    padding: 0.7rem 2rem;
    font-size: 1rem;
    font-family: 'Montserrat', sans-serif;
    font-weight: 600;
    cursor: pointer;
    margin-top: 0.7rem;
    align-self: flex-start;
    box-shadow: 0 2px 8px rgba(254,132,0,0.10);
    transition: background 0.2s, box-shadow 0.2s, transform 0.2s;
    letter-spacing: 0.01em;
}
.news-readmore-btn:hover {
    background: #ff9900;
    box-shadow: 0 4px 16px rgba(254,132,0,0.18);
    transform: translateY(-2px) scale(1.03);
}
@media (max-width: 900px) {
    .news-cards-container {
        flex-direction: column;
        align-items: center;
        gap: 1.5rem;
    }
    .news-card-custom {
        width: 100%;
        max-width: 98vw;
    }
    .news-image-custom {
        height: 140px;
    }
}
@media (max-width: 600px) {
    .news-card-custom {
        width: 100%;
        max-width: 100vw;
    }
    .news-content-custom {
        padding: 1rem 0.7rem 0.8rem 0.7rem;
    }
    .news-readmore-btn {
        width: 100%;
        align-self: center;
        padding: 1rem 0;
        font-size: 1.05rem;
    }
}
</style>
</head>
<body>
    <header>
        <div class="header-left">
            <div class="logo">
                <img src="/images/logo2.png" alt="Mifta Motor Sport Logo" style="height:60px;width:auto;max-width:160px;object-fit:contain;display:block;">
            </div>
        </div>
        <div class="header-right">
            <nav>
                <a href="#services">Service</a>
                <a href="#product">Product</a>
                <a href="#testimonial">Testimonial</a>
                <a href="/customer/dashboard">Customer Dashboard</a>
            </nav>
            @if(Auth::check())
            <div class="user-status" style="position: relative; display: flex; align-items: center; gap: 0.5rem; cursor:pointer; padding:0.2rem 0.7rem; border-radius:0.5rem; transition:background 0.2s;" onclick="event.stopPropagation(); document.getElementById('dropdown-logout').classList.toggle('show');">
                <span style="font-weight:600;">{{ Auth::user()->nama }}</span>
                <span style="font-size:0.85em; color: #FE8400;">({{ Auth::user()->peran }})</span>
                <span style="font-size:0.9em; color:#888; margin-left:0.3em;">Akun</span>
                <svg width="16" height="16" style="margin-left:0.2em;" fill="none" stroke="#333" stroke-width="2" viewBox="0 0 24 24"><path d="M6 9l6 6 6-6"/></svg>
                <div class="dropdown" style="position: relative;">
                    <div id="dropdown-logout" class="dropdown-menu" style="display:none;position:absolute;right:0;top:2.2rem;background:#fff;border:1px solid #eee;border-radius:0.5rem;box-shadow:0 2px 8px rgba(0,0,0,0.08);min-width:120px;z-index:1001;">
                        <form method="POST" action="{{ route('logout') }}" style="margin:0;">
                            @csrf
                            <button type="submit" style="background:none;border:none;padding:0.7em 1.2em;width:100%;text-align:left;cursor:pointer;">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
            <script>
            document.addEventListener('click', function() {
                var menu = document.getElementById('dropdown-logout');
                if(menu) menu.classList.remove('show');
            });
            </script>
            <style>
            .user-status:hover, .user-status:focus { background: #f7f7f7; }
            .user-status svg { transition: transform 0.2s; }
            .dropdown-menu.show { display: block !important; }
            .user-status .dropdown-menu { right: 0; left: auto; min-width: 100px; }
            @media (max-width: 640px) {
                .user-status span { font-size: 0.95em; }
            }
            </style>
            @else
            <div style="display: flex; gap: 0.5rem;">
                <a href="/login" class="btn-login">Login</a>
                <a href="{{ route('register') }}" class="btn-register">Register</a>
            </div>
            @endif
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
                <a href="/customer/dashboard">Customer Dashboard</a>
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
                <div class="service-icon" style="display:flex;align-items:center;justify-content:center;width:64px;height:64px;margin:0 auto 0.5rem auto;">
                  <svg width="57" height="57" viewBox="0 0 57 57" fill="none" xmlns="http://www.w3.org/2000/svg" style="max-width:100%;height:auto;">
                    <g clip-path="url(#clip0_59_379)">
                      <path d="M53.2734 6.51562C53.7474 7.33594 54.1758 8.11979 54.5586 8.86719C54.9414 9.61458 55.2878 10.3711 55.5977 11.1367C55.9076 11.9023 56.1263 12.6953 56.2539 13.5156C56.3815 14.3359 56.4635 15.2474 56.5 16.25C56.5 17.6901 56.3177 19.0755 55.9531 20.4062C55.5885 21.737 55.0599 22.9948 54.3672 24.1797C53.6745 25.3646 52.8451 26.431 51.8789 27.3789C50.9128 28.3268 49.8464 29.1471 48.6797 29.8398C47.513 30.5326 46.2643 31.0612 44.9336 31.4258C43.6029 31.7904 42.2083 31.9818 40.75 32C40.3307 32 39.9115 31.9818 39.4922 31.9453C39.0729 31.9089 38.6445 31.8542 38.207 31.7812L16.168 53.8203C15.293 54.6953 14.2995 55.3607 13.1875 55.8164C12.0755 56.2721 10.8997 56.5 9.66016 56.5C8.40234 56.5 7.21745 56.263 6.10547 55.7891C4.99349 55.3151 4.02734 54.6589 3.20703 53.8203C2.38672 52.9818 1.73047 52.0065 1.23828 50.8945C0.746094 49.7826 0.5 48.5977 0.5 47.3398C0.5 46.1185 0.727865 44.9518 1.18359 43.8398C1.63932 42.7279 2.30469 41.7253 3.17969 40.832L25.2188 18.793C25.1458 18.3737 25.0911 17.9544 25.0547 17.5352C25.0182 17.1159 25 16.6875 25 16.25C25 14.8099 25.1823 13.4245 25.5469 12.0938C25.9115 10.763 26.4401 9.50521 27.1328 8.32031C27.8255 7.13542 28.6549 6.06901 29.6211 5.12109C30.5872 4.17318 31.6536 3.35286 32.8203 2.66016C33.987 1.96745 35.2357 1.4388 36.5664 1.07422C37.8971 0.709635 39.2917 0.518229 40.75 0.5C41.7344 0.5 42.6367 0.572917 43.457 0.71875C44.2773 0.864583 45.0794 1.09245 45.8633 1.40234C46.6471 1.71224 47.4036 2.04948 48.1328 2.41406C48.862 2.77865 49.6458 3.21615 50.4844 3.72656L39.7109 14.5L42.5 17.2891L53.2734 6.51562ZM40.75 28.5C42.4453 28.5 44.0312 28.181 45.5078 27.543C46.9844 26.9049 48.2786 26.0299 49.3906 24.918C50.5026 23.806 51.3776 22.5117 52.0156 21.0352C52.6536 19.5586 52.9818 17.9635 53 16.25C53 14.9193 52.7812 13.6341 52.3438 12.3945L42.5 22.2109L34.7891 14.5L44.6055 4.65625C43.3659 4.21875 42.0807 4 40.75 4C39.0547 4 37.4688 4.31901 35.9922 4.95703C34.5156 5.59505 33.2214 6.47005 32.1094 7.58203C30.9974 8.69401 30.1224 9.98828 29.4844 11.4648C28.8464 12.9414 28.5182 14.5365 28.5 16.25C28.5 16.888 28.5547 17.5078 28.6641 18.1094C28.7734 18.7109 28.901 19.3125 29.0469 19.9141L5.66797 43.3203C5.13932 43.849 4.72917 44.4596 4.4375 45.1523C4.14583 45.8451 4 46.5742 4 47.3398C4 48.1055 4.14583 48.8346 4.4375 49.5273C4.72917 50.2201 5.13932 50.8216 5.66797 51.332C6.19661 51.8424 6.79818 52.2435 7.47266 52.5352C8.14714 52.8268 8.8763 52.9818 9.66016 53C10.4258 53 11.1549 52.8542 11.8477 52.5625C12.5404 52.2708 13.151 51.8607 13.6797 51.332L37.0859 27.9531C37.6875 28.099 38.2891 28.2266 38.8906 28.3359C39.4922 28.4453 40.112 28.5 40.75 28.5Z" fill="#FE8400"/>
                    </g>
                    <defs>
                      <clipPath id="clip0_59_379">
                        <rect width="56" height="56" fill="white" transform="translate(0.5 0.5)"/>
                      </clipPath>
                    </defs>
                  </svg>
                </div>
                <h3>Expert Bike Care</h3>
                <p>Pro maintenance for peak performance.</p>
            </div>
            <div class="service-card">
                <div class="service-icon" style="display:flex;align-items:center;justify-content:center;width:64px;height:64px;margin:0 auto 0.5rem auto;">
                  <svg width="57" height="57" viewBox="0 0 57 57" fill="none" xmlns="http://www.w3.org/2000/svg" style="max-width:100%;height:auto;">
                    <path d="M19.1666 23.8333H37.8333V42.4999H26.1666L21.5 37.8333H16.8333V26.1666M16.8333 9.83325V14.4999H23.8333V19.1666H16.8333L12.1666 23.8333V30.8333H7.49998V23.8333H2.83331V42.4999H7.49998V35.4999H12.1666V42.4999H19.1666L23.8333 47.1666H42.5V37.8333H47.1666V44.8333H54.1666V21.4999H47.1666V28.4999H42.5V19.1666H28.5V14.4999H35.5V9.83325H16.8333Z" fill="#FE8400"/>
                  </svg>
                </div>
                <h3>Quality Parts</h3>
                <p>Reliable components for lasting performance.</p>
            </div>
            <div class="service-card">
                <div class="service-icon" style="display:flex;align-items:center;justify-content:center;width:64px;height:64px;margin:0 auto 0.5rem auto;">
                  <svg width="57" height="57" viewBox="0 0 57 57" fill="none" xmlns="http://www.w3.org/2000/svg" style="max-width:100%;height:auto;">
                    <path d="M9.83335 31.4307V28.5H5.16668V23.8333H20.0183L26.6333 19.1667H34.7813L32.2333 12.1667H26.1667V7.5H35.5L38.048 14.5H47.1667V21.5H40.596L43.9933 30.838C46.5711 30.92 49.0286 31.9478 50.8971 33.7255C52.7657 35.5032 53.9146 37.9064 54.1248 40.4769C54.335 43.0474 53.5918 45.6053 52.0369 47.663C50.482 49.7207 48.2242 51.1341 45.694 51.6338C43.1638 52.1334 40.5381 51.6844 38.3178 50.3723C36.0974 49.0602 34.4376 46.9767 33.6549 44.5193C32.8722 42.0619 33.0213 39.4023 34.0738 37.0478C35.1263 34.6932 37.0086 32.8084 39.3617 31.7527L36.4777 23.8333H34.268L30.5767 37.53L30.572 37.5277L30.5767 37.5393L23.7517 40.0243C23.8061 40.4537 23.8333 40.89 23.8333 41.3333C23.8328 43.2582 23.3031 45.1458 22.3022 46.79C21.3013 48.4342 19.8677 49.7716 18.1581 50.656C16.4485 51.5405 14.5286 51.938 12.6084 51.8051C10.6881 51.6722 8.84134 51.014 7.26988 49.9025C5.69841 48.7909 4.46273 47.2688 3.69787 45.5024C2.93302 43.736 2.66843 41.7934 2.93302 39.8868C3.19761 37.9802 3.9812 36.1831 5.19815 34.6917C6.4151 33.2004 8.01858 32.0723 9.83335 31.4307ZM14.5 30.8963C16.0481 31.0696 17.5381 31.5852 18.8623 32.4057C20.1864 33.2261 21.3114 34.3309 22.1557 35.64L26.722 33.9763L29.4403 23.8333H28.164L21.5 28.5H14.5V30.8963ZM13.3333 47.1667C14.8804 47.1667 16.3642 46.5521 17.4581 45.4581C18.5521 44.3642 19.1667 42.8804 19.1667 41.3333C19.1667 39.7862 18.5521 38.3025 17.4581 37.2085C16.3642 36.1146 14.8804 35.5 13.3333 35.5C11.7863 35.5 10.3025 36.1146 9.20856 37.2085C8.1146 38.3025 7.50001 39.7862 7.50001 41.3333C7.50001 42.8804 8.1146 44.3642 9.20856 45.4581C10.3025 46.5521 11.7863 47.1667 13.3333 47.1667ZM43.6667 47.1667C45.2138 47.1667 46.6975 46.5521 47.7915 45.4581C48.8854 44.3642 49.5 42.8804 49.5 41.3333C49.5 39.7862 48.8854 38.3025 47.7915 37.2085C46.6975 36.1146 45.2138 35.5 43.6667 35.5C42.1196 35.5 40.6359 36.1146 39.5419 37.2085C38.4479 38.3025 37.8333 39.7862 37.8333 41.3333C37.8333 42.8804 38.4479 44.3642 39.5419 45.4581C40.6359 46.5521 42.1196 47.1667 43.6667 47.1667Z" fill="#FE8400"/>
                  </svg>
                </div>
                <h3>Service</h3>
                <p>Service premium bikes and other motorbikes for ready to ride.</p>
            </div>
        </div>
    </div>
    
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
        </form>
    </div>
    <!-- News Section -->
    @if(isset($news) && $news->count() > 0)
    <div class="news-section" id="news-section">
        <h2 class="section-title">Latest News</h2>
        <div class="section-divider"></div>
        <div class="news-cards-container">
            @foreach($news->take(3) as $item)
            <div class="news-card-custom">
                <div class="news-image-custom">
                    @if($item->foto)
                        <img src="{{ asset('storage/' . $item->foto) }}" alt="{{ $item->judul_berita }}">
                    @else
                        <img src="https://via.placeholder.com/400x220/FE8400/FFFFFF?text=No+Image" alt="No Image">
                    @endif
                </div>
                <div class="news-content-custom">
                    <div class="news-title-custom">{{ $item->judul_berita }}</div>
                    <div class="news-desc-custom">{{ \Illuminate\Support\Str::limit($item->deskripsi, 120) }}</div>
                    @if(strlen($item->deskripsi) > 120 || !empty($item->konten))
                    <button class="news-readmore-btn" onclick="showNewsModal(`{{ addslashes($item->judul_berita) }}`, `{{ addslashes($item->konten ?? $item->deskripsi) }}`)">Read More</button>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <!-- Modal for News -->
    <div id="newsModalOverlay" class="news-modal-overlay" style="display:none;">
        <div class="news-modal-box">
            <button class="news-modal-close" onclick="closeNewsModal()">&times;</button>
            <h3 id="newsModalTitle"></h3>
            <div id="newsModalContent"></div>
        </div>
    </div>
    <script>
    function showNewsModal(title, content) {
        document.getElementById('newsModalTitle').innerText = title;
        document.getElementById('newsModalContent').innerText = content;
        document.getElementById('newsModalOverlay').style.display = 'flex';
        document.body.style.overflow = 'hidden';
    }
    function closeNewsModal() {
        document.getElementById('newsModalOverlay').style.display = 'none';
        document.body.style.overflow = '';
    }
    // Close modal on ESC
    window.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeNewsModal();
    });
    // Close modal on click outside
    window.addEventListener('click', function(e) {
        var overlay = document.getElementById('newsModalOverlay');
        if (e.target === overlay) closeNewsModal();
    });
    </script>
    <style>
    .news-modal-overlay {
        position: fixed;
        top: 0; left: 0; right: 0; bottom: 0;
        background: rgba(30,30,30,0.65);
        z-index: 9999;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: background 0.2s;
    }
    .news-modal-box {
        background: #fff;
        border-radius: 1rem;
        box-shadow: 0 8px 32px rgba(0,0,0,0.18);
        padding: 2.2rem 2rem 1.5rem 2rem;
        max-width: 95vw;
        width: 420px;
        max-height: 90vh;
        overflow-y: auto;
        position: relative;
        display: flex;
        flex-direction: column;
        align-items: flex-start;
        animation: modalPopIn 0.18s cubic-bezier(.4,2,.6,1) 1;
    }
    @keyframes modalPopIn {
        0% { transform: scale(0.92) translateY(30px); opacity: 0; }
        100% { transform: scale(1) translateY(0); opacity: 1; }
    }
    .news-modal-close {
        position: absolute;
        top: 1.1rem;
        right: 1.2rem;
        background: none;
        border: none;
        font-size: 2rem;
        color: #FE8400;
        cursor: pointer;
        font-weight: 700;
        transition: color 0.2s;
        z-index: 2;
    }
    .news-modal-close:hover {
        color: #ff9900;
    }
    #newsModalTitle {
        font-family: 'Montserrat', sans-serif;
        font-size: 1.25rem;
        font-weight: 700;
        color: #181818;
        margin-bottom: 1rem;
        text-align: left;
        width: 100%;
    }
    #newsModalContent {
        font-family: 'Poppins', sans-serif;
        font-size: 1.05rem;
        color: #444;
        line-height: 1.7;
        text-align: left;
        width: 100%;
        white-space: pre-line;
    }
    @media (max-width: 600px) {
        .news-modal-box {
            width: 98vw;
            padding: 1.2rem 0.7rem 1.2rem 0.7rem;
        }
        #newsModalTitle {
            font-size: 1.1rem;
        }
        #newsModalContent {
            font-size: 0.98rem;
        }
    }
    </style>
    @endif
    
    <div class="collection-section" id="product">
        <div style="display: flex; flex-direction: column; align-items: center; margin-bottom: 2.5rem;">
            <h2 class="collection-title-custom">Our Exclusive Collection</h2>
            <div class="section-divider"></div>
        </div>
        <div class="collections" id="product-collections">
            @if($products->count() > 0)
                @foreach($products->take(3) as $product)
                <div class="product-card-custom">
                    <div class="product-image-custom">
                        <img src="{{ asset('storage/' . $product->gambar_produk) }}" alt="{{ $product->nama_produk }}">
                    </div>
                    <div class="product-content-custom">
                        <div class="product-title-custom">{{ $product->nama_produk }}</div>
                        <div class="product-category-custom">
                            <span class="product-icon-custom">🔧</span>
                            {{ $product->kategori ?? 'Sparepart' }}
                        </div>
                        <div class="product-price-custom">Rp{{ number_format($product->harga, 0, ',', '.') }}</div>
                        <a href="https://wa.me/6285708150434?text=Halo%20saya%20tertarik%20dengan%20produk%20{{ urlencode($product->nama_produk) }}" target="_blank" class="buy-now-btn-custom">Contact</a>
                    </div>
                </div>
                @endforeach
            @else
                <div class="collection-card">
                    <div class="info">
                        <h4>No products available</h4>
                        <p>Check back later for more products.</p>
                    </div>
                </div>
            @endif
        </div>
        @if($products->count() > 3)
        <div class="see-more-btn-container">
            <button class="see-more-btn" id="seeMoreBtn">See More</button>
            <button class="see-more-btn" id="minimizeBtn" style="display:none;">Minimize</button>
        </div>
        <style>
        .see-more-btn-container {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            margin-top: 1.5rem;
            margin-bottom: 0.5rem;
        }
        </style>
        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const seeMoreBtn = document.getElementById('seeMoreBtn');
            const minimizeBtn = document.getElementById('minimizeBtn');
            const collections = document.getElementById('product-collections');
            let expanded = false;
            const initialHTML = collections.innerHTML;
            seeMoreBtn.addEventListener('click', function() {
                if (!expanded) {
                    collections.innerHTML = `@foreach($products as $product)` +
                        `<div class=\"product-card-custom\">` +
                        `<div class=\"product-image-custom\"><img src=\"{{ asset('storage/' . $product->gambar_produk) }}\" alt=\"{{ $product->nama_produk }}\"></div>` +
                        `<div class=\"product-content-custom\">` +
                        `<div class=\"product-title-custom\">{{ $product->nama_produk }}</div>` +
                        `<div class=\"product-category-custom\"><span class=\"product-icon-custom\">🔧</span>{{ $product->kategori ?? 'Sparepart' }}</div>` +
                        `<div class=\"product-price-custom\">Rp{{ number_format($product->harga, 0, ',', '.') }}</div>` +
                        `<a href=\"https://wa.me/6285708150434?text=Halo%20saya%20tertarik%20dengan%20produk%20{{ urlencode($product->nama_produk) }}\" target=\"_blank\" class=\"buy-now-btn-custom\">Contact</a>` +
                        `</div></div>@endforeach`;
                    seeMoreBtn.style.display = 'none';
                    minimizeBtn.style.display = 'inline-block';
                    expanded = true;
                }
            });
            minimizeBtn.addEventListener('click', function() {
                if (expanded) {
                    collections.innerHTML = initialHTML;
                    seeMoreBtn.style.display = 'inline-block';
                    minimizeBtn.style.display = 'none';
                    expanded = false;
                }
            });
        });
        </script>
        @endif
    </div>
    
    <div class="testimonial-section" id="testimonial">
        <div style="display: flex; flex-direction: column; align-items: center; margin-bottom: 2.5rem;">
            <h2 class="testimonial-title-custom">What Our Clients Say?</h2>
            <div class="section-divider"></div>
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
    
    <footer>
        <div class="footer-row">
            <div class="footer-logo">
            <img src="/images/logo.png" alt="Mifta Motor Sport Logo" />
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