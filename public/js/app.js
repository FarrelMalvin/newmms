// Modern JavaScript for MMS Website
class MMSApp {
    constructor() {
        this.init();
    }

    init() {
        this.setupEventListeners();
        this.initializeComponents();
        this.setupIntersectionObserver();
        this.setupSmoothScrolling();
        this.setupThemeToggle();
        this.setupMobileMenu();
        this.setupCarousels();
        this.setupFormValidation();
        this.setupLazyLoading();
    }

    setupEventListeners() {
        // Global event listeners
        document.addEventListener('DOMContentLoaded', () => {
            this.onDOMReady();
        });

        window.addEventListener('resize', this.debounce(() => {
            this.handleResize();
        }, 250));

        window.addEventListener('scroll', this.debounce(() => {
            this.handleScroll();
        }, 100));
    }

    initializeComponents() {
        // Initialize all components
        this.initTooltips();
        this.initModals();
        this.initDropdowns();
        this.initTabs();
        this.initAccordions();
    }

    setupIntersectionObserver() {
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('fade-in');
                    observer.unobserve(entry.target);
                }
            });
        }, observerOptions);

        // Observe elements with animation classes
        document.querySelectorAll('.animate-on-scroll').forEach(el => {
            observer.observe(el);
        });
    }

    setupSmoothScrolling() {
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', (e) => {
                e.preventDefault();
                const target = document.querySelector(anchor.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    }

    setupThemeToggle() {
        const themeToggle = document.querySelector('[data-theme-toggle]');
        if (themeToggle) {
            themeToggle.addEventListener('click', () => {
                this.toggleTheme();
            });
        }

        // Load saved theme
        this.loadTheme();
    }

    toggleTheme() {
        const currentTheme = document.documentElement.getAttribute('data-theme');
        const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
        
        document.documentElement.setAttribute('data-theme', newTheme);
        localStorage.setItem('theme', newTheme);
        
        // Update theme toggle button
        const themeToggle = document.querySelector('[data-theme-toggle]');
        if (themeToggle) {
            themeToggle.innerHTML = newTheme === 'dark' ? '🌞' : '🌙';
        }
    }

    loadTheme() {
        const savedTheme = localStorage.getItem('theme') || 'light';
        document.documentElement.setAttribute('data-theme', savedTheme);
        
        const themeToggle = document.querySelector('[data-theme-toggle]');
        if (themeToggle) {
            themeToggle.innerHTML = savedTheme === 'dark' ? '🌞' : '🌙';
        }
    }

    setupMobileMenu() {
        const mobileMenuToggle = document.querySelector('[data-mobile-menu-toggle]');
        const mobileMenu = document.querySelector('[data-mobile-menu]');
        
        if (mobileMenuToggle && mobileMenu) {
            mobileMenuToggle.addEventListener('click', () => {
                const isOpen = mobileMenu.classList.contains('open');
                
                if (isOpen) {
                    mobileMenu.classList.remove('open');
                    mobileMenuToggle.setAttribute('aria-expanded', 'false');
                } else {
                    mobileMenu.classList.add('open');
                    mobileMenuToggle.setAttribute('aria-expanded', 'true');
                }
            });

            // Close menu when clicking outside
            document.addEventListener('click', (e) => {
                if (!mobileMenu.contains(e.target) && !mobileMenuToggle.contains(e.target)) {
                    mobileMenu.classList.remove('open');
                    mobileMenuToggle.setAttribute('aria-expanded', 'false');
                }
            });
        }
    }

    setupCarousels() {
        document.querySelectorAll('[data-carousel]').forEach(carousel => {
            this.initCarousel(carousel);
        });
    }

    initCarousel(carousel) {
        const container = carousel.querySelector('[data-carousel-container]');
        const items = carousel.querySelectorAll('[data-carousel-item]');
        const prevBtn = carousel.querySelector('[data-carousel-prev]');
        const nextBtn = carousel.querySelector('[data-carousel-next]');
        const indicators = carousel.querySelectorAll('[data-carousel-indicator]');
        
        let currentIndex = 0;
        const totalItems = items.length;

        const showSlide = (index) => {
            items.forEach((item, i) => {
                item.style.transform = `translateX(${(i - index) * 100}%)`;
                item.classList.toggle('active', i === index);
            });

            indicators.forEach((indicator, i) => {
                indicator.classList.toggle('active', i === index);
            });
        };

        const nextSlide = () => {
            currentIndex = (currentIndex + 1) % totalItems;
            showSlide(currentIndex);
        };

        const prevSlide = () => {
            currentIndex = (currentIndex - 1 + totalItems) % totalItems;
            showSlide(currentIndex);
        };

        // Event listeners
        if (nextBtn) nextBtn.addEventListener('click', nextSlide);
        if (prevBtn) prevBtn.addEventListener('click', prevSlide);

        indicators.forEach((indicator, index) => {
            indicator.addEventListener('click', () => {
                currentIndex = index;
                showSlide(currentIndex);
            });
        });

        // Auto-play
        if (carousel.hasAttribute('data-autoplay')) {
            setInterval(nextSlide, 5000);
        }

        // Initialize first slide
        showSlide(0);
    }

    setupFormValidation() {
        document.querySelectorAll('form[data-validate]').forEach(form => {
            this.initFormValidation(form);
        });
    }

    initFormValidation(form) {
        const inputs = form.querySelectorAll('input, textarea, select');
        
        inputs.forEach(input => {
            input.addEventListener('blur', () => {
                this.validateField(input);
            });

            input.addEventListener('input', () => {
                if (input.classList.contains('error')) {
                    this.validateField(input);
                }
            });
        });

        form.addEventListener('submit', (e) => {
            e.preventDefault();
            
            let isValid = true;
            inputs.forEach(input => {
                if (!this.validateField(input)) {
                    isValid = false;
                }
            });

            if (isValid) {
                this.submitForm(form);
            }
        });
    }

    validateField(field) {
        const value = field.value.trim();
        const type = field.type;
        const required = field.hasAttribute('required');
        const pattern = field.getAttribute('pattern');
        const minLength = field.getAttribute('minlength');
        const maxLength = field.getAttribute('maxlength');

        // Remove existing error
        this.removeFieldError(field);

        // Required validation
        if (required && !value) {
            this.showFieldError(field, 'This field is required');
            return false;
        }

        // Email validation
        if (type === 'email' && value) {
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(value)) {
                this.showFieldError(field, 'Please enter a valid email address');
                return false;
            }
        }

        // Pattern validation
        if (pattern && value) {
            const regex = new RegExp(pattern);
            if (!regex.test(value)) {
                this.showFieldError(field, field.getAttribute('data-error-message') || 'Invalid format');
                return false;
            }
        }

        // Length validation
        if (minLength && value.length < parseInt(minLength)) {
            this.showFieldError(field, `Minimum ${minLength} characters required`);
            return false;
        }

        if (maxLength && value.length > parseInt(maxLength)) {
            this.showFieldError(field, `Maximum ${maxLength} characters allowed`);
            return false;
        }

        return true;
    }

    showFieldError(field, message) {
        field.classList.add('error');
        
        const errorDiv = document.createElement('div');
        errorDiv.className = 'field-error';
        errorDiv.textContent = message;
        errorDiv.style.color = '#ef4444';
        errorDiv.style.fontSize = '0.875rem';
        errorDiv.style.marginTop = '0.25rem';
        
        field.parentNode.appendChild(errorDiv);
    }

    removeFieldError(field) {
        field.classList.remove('error');
        const errorDiv = field.parentNode.querySelector('.field-error');
        if (errorDiv) {
            errorDiv.remove();
        }
    }

    async submitForm(form) {
        const submitBtn = form.querySelector('[type="submit"]');
        const originalText = submitBtn.textContent;
        
        // Show loading state
        submitBtn.disabled = true;
        submitBtn.textContent = 'Submitting...';
        
        try {
            const formData = new FormData(form);
            const response = await fetch(form.action, {
                method: form.method || 'POST',
                body: formData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest'
                }
            });

            const result = await response.json();
            
            if (response.ok) {
                this.showNotification('Success!', result.message || 'Form submitted successfully', 'success');
                form.reset();
            } else {
                this.showNotification('Error!', result.message || 'Something went wrong', 'error');
            }
        } catch (error) {
            this.showNotification('Error!', 'Network error occurred', 'error');
        } finally {
            submitBtn.disabled = false;
            submitBtn.textContent = originalText;
        }
    }

    setupLazyLoading() {
        const imageObserver = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    const img = entry.target;
                    img.src = img.dataset.src;
                    img.classList.remove('lazy');
                    imageObserver.unobserve(img);
                }
            });
        });

        document.querySelectorAll('img[data-src]').forEach(img => {
            imageObserver.observe(img);
        });
    }

    initTooltips() {
        document.querySelectorAll('[data-tooltip]').forEach(element => {
            element.addEventListener('mouseenter', (e) => {
                this.showTooltip(e.target);
            });

            element.addEventListener('mouseleave', (e) => {
                this.hideTooltip(e.target);
            });
        });
    }

    showTooltip(element) {
        const text = element.getAttribute('data-tooltip');
        const tooltip = document.createElement('div');
        tooltip.className = 'tooltip';
        tooltip.textContent = text;
        tooltip.style.cssText = `
            position: absolute;
            background: #1f2937;
            color: white;
            padding: 0.5rem;
            border-radius: 0.375rem;
            font-size: 0.875rem;
            z-index: 1000;
            pointer-events: none;
        `;

        document.body.appendChild(tooltip);

        const rect = element.getBoundingClientRect();
        tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
        tooltip.style.top = rect.top - tooltip.offsetHeight - 8 + 'px';

        element.tooltip = tooltip;
    }

    hideTooltip(element) {
        if (element.tooltip) {
            element.tooltip.remove();
            element.tooltip = null;
        }
    }

    initModals() {
        document.querySelectorAll('[data-modal-toggle]').forEach(toggle => {
            toggle.addEventListener('click', () => {
                const modalId = toggle.getAttribute('data-modal-toggle');
                this.openModal(modalId);
            });
        });

        document.querySelectorAll('[data-modal-close]').forEach(close => {
            close.addEventListener('click', () => {
                this.closeModal(close.closest('[data-modal]'));
            });
        });
    }

    openModal(modalId) {
        const modal = document.querySelector(`[data-modal="${modalId}"]`);
        if (modal) {
            modal.classList.add('open');
            document.body.style.overflow = 'hidden';
        }
    }

    closeModal(modal) {
        if (modal) {
            modal.classList.remove('open');
            document.body.style.overflow = '';
        }
    }

    initDropdowns() {
        document.querySelectorAll('[data-dropdown-toggle]').forEach(toggle => {
            toggle.addEventListener('click', (e) => {
                e.stopPropagation();
                const dropdown = toggle.nextElementSibling;
                dropdown.classList.toggle('open');
            });
        });

        document.addEventListener('click', () => {
            document.querySelectorAll('[data-dropdown].open').forEach(dropdown => {
                dropdown.classList.remove('open');
            });
        });
    }

    initTabs() {
        document.querySelectorAll('[data-tab-toggle]').forEach(toggle => {
            toggle.addEventListener('click', () => {
                const tabId = toggle.getAttribute('data-tab-toggle');
                this.switchTab(tabId);
            });
        });
    }

    switchTab(tabId) {
        const tabContainer = document.querySelector(`[data-tab="${tabId}"]`).closest('[data-tabs]');
        
        // Hide all tabs
        tabContainer.querySelectorAll('[data-tab]').forEach(tab => {
            tab.classList.remove('active');
        });
        
        // Remove active from all toggles
        tabContainer.querySelectorAll('[data-tab-toggle]').forEach(toggle => {
            toggle.classList.remove('active');
        });
        
        // Show selected tab
        document.querySelector(`[data-tab="${tabId}"]`).classList.add('active');
        document.querySelector(`[data-tab-toggle="${tabId}"]`).classList.add('active');
    }

    initAccordions() {
        document.querySelectorAll('[data-accordion-toggle]').forEach(toggle => {
            toggle.addEventListener('click', () => {
                const accordion = toggle.closest('[data-accordion]');
                const content = accordion.querySelector('[data-accordion-content]');
                
                if (accordion.classList.contains('open')) {
                    accordion.classList.remove('open');
                    content.style.maxHeight = '0px';
                } else {
                    accordion.classList.add('open');
                    content.style.maxHeight = content.scrollHeight + 'px';
                }
            });
        });
    }

    showNotification(title, message, type = 'info') {
        const notification = document.createElement('div');
        notification.className = `notification notification-${type}`;
        notification.innerHTML = `
            <div class="notification-header">
                <strong>${title}</strong>
                <button class="notification-close">&times;</button>
            </div>
            <div class="notification-body">${message}</div>
        `;

        notification.style.cssText = `
            position: fixed;
            top: 1rem;
            right: 1rem;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 0.5rem;
            padding: 1rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
            z-index: 1000;
            max-width: 400px;
            animation: slideInRight 0.3s ease-out;
        `;

        document.body.appendChild(notification);

        // Auto remove after 5 seconds
        setTimeout(() => {
            notification.remove();
        }, 5000);

        // Close button
        notification.querySelector('.notification-close').addEventListener('click', () => {
            notification.remove();
        });
    }

    onDOMReady() {
        // Initialize any DOM-dependent functionality
    }

    handleResize() {
        // Handle window resize events
        const isMobile = window.innerWidth < 768;
        document.body.classList.toggle('mobile', isMobile);
    }

    handleScroll() {
        // Handle scroll events
        const scrolled = window.scrollY > 100;
        document.body.classList.toggle('scrolled', scrolled);
    }

    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
}

// Initialize the app when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        new MMSApp();
    });
} else {
    new MMSApp();
}

// Export for use in other modules
window.MMSApp = MMSApp; 