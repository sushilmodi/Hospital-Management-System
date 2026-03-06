// Mobile Menu Toggle - Sidebar Style with Overlay
const menuIcon = document.getElementById('menuIcon');
const navLinks = document.getElementById('navLinks');
const body = document.body;

if(menuIcon) {
    menuIcon.addEventListener('click', (e) => {
        e.stopPropagation();
        navLinks.classList.toggle('active');
        
        // Add/remove overlay and prevent body scroll when menu is open
        if (navLinks.classList.contains('active')) {
            body.classList.add('menu-open');
            body.style.overflow = 'hidden'; // Prevent background scrolling
        } else {
            body.classList.remove('menu-open');
            body.style.overflow = ''; // Restore scrolling
        }
    });
    
    // Close menu when clicking outside
    document.addEventListener('click', (event) => {
        const isClickInside = menuIcon.contains(event.target) || navLinks.contains(event.target);
        
        if (!isClickInside && navLinks.classList.contains('active')) {
            navLinks.classList.remove('active');
            body.classList.remove('menu-open');
            body.style.overflow = ''; // Restore scrolling
        }
    });
    
    // Close menu with Escape key
    document.addEventListener('keydown', (e) => {
        if (e.key === 'Escape' && navLinks.classList.contains('active')) {
            navLinks.classList.remove('active');
            body.classList.remove('menu-open');
            body.style.overflow = '';
        }
    });
}

// Close mobile menu when a nav link is clicked
const navLinksItems = document.querySelectorAll('.nav-links a');
navLinksItems.forEach(link => {
    link.addEventListener('click', () => {
        if (navLinks && navLinks.classList.contains('active')) {
            navLinks.classList.remove('active');
            body.classList.remove('menu-open');
            body.style.overflow = ''; // Restore scrolling
        }
    });
});

// Contact Form Handling
document.addEventListener('DOMContentLoaded', () => {
  const form = document.getElementById('contactForm');
  const popup = document.getElementById('popupMessage');

  if (!form) return;

  form.addEventListener('submit', function (e) {
    e.preventDefault();

    const formData = new FormData(form);

    fetch('php/contact.php', {
      method: 'POST',
      body: formData
    })
    .then(res => res.text())
    .then(msg => {
      popup.textContent = msg;
      popup.style.display = "block";
      popup.style.backgroundColor = "var(--success)";
      form.reset();
      
      // Auto hide after 3 seconds
      setTimeout(() => {
          popup.style.display = "none";
      }, 3000);
    })
    .catch(() => {
      popup.textContent = "Error sending message!";
      popup.style.display = "block";
      popup.style.backgroundColor = "var(--danger)";
      
      setTimeout(() => {
          popup.style.display = "none";
      }, 3000);
    });
  });
});

// Smooth scrolling for anchor links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        const href = this.getAttribute('href');
        
        if (href !== '#') {
            e.preventDefault();
            
            const target = document.querySelector(href);
            if (target) {
                // Close mobile menu if open
                if (navLinks && navLinks.classList.contains('active')) {
                    navLinks.classList.remove('active');
                    body.classList.remove('menu-open');
                    body.style.overflow = '';
                }
                
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        }
    });
});

// Add active class to nav links based on scroll position
window.addEventListener('scroll', () => {
    const sections = document.querySelectorAll('section[id]');
    const navLinks = document.querySelectorAll('.nav-links a');
    
    let current = '';
    const scrollPosition = window.scrollY + 100; // Offset for header
    
    sections.forEach(section => {
        const sectionTop = section.offsetTop;
        const sectionHeight = section.clientHeight;
        
        if (scrollPosition >= sectionTop && scrollPosition < sectionTop + sectionHeight) {
            current = section.getAttribute('id');
        }
    });
    
    navLinks.forEach(link => {
        link.classList.remove('active');
        const href = link.getAttribute('href').replace('#', '');
        if (href === current) {
            link.classList.add('active');
        }
    });
});

// Header scroll effect
window.addEventListener('scroll', () => {
    const header = document.querySelector('.header');
    if (window.scrollY > 100) {
        header.style.background = 'rgba(255, 255, 255, 0.98)';
        header.style.boxShadow = '0 4px 20px rgba(0,0,0,0.1)';
    } else {
        header.style.background = 'rgba(255, 255, 255, 0.95)';
        header.style.boxShadow = '0 4px 20px rgba(0,0,0,0.06)';
    }
});

// Image error handling
document.addEventListener('DOMContentLoaded', () => {
    const images = document.querySelectorAll('img');
    images.forEach(img => {
        img.addEventListener('error', function() {
            // Check if image is doctor image
            if (this.src.includes('doctor') && !this.src.includes('default-doctor.jpg')) {
                this.src = 'uploads/doctors/default-doctor.jpg';
            }
            // Check if image is service icon
            else if (this.classList.contains('service-icon') && !this.src.includes('default-service.png')) {
                // You can set a default service icon here if needed
                console.log('Service icon missing:', this.src);
            }
        });
        
        // Add loading animation
        img.style.opacity = '0';
        img.style.transition = 'opacity 0.3s ease';
        img.onload = function() {
            this.style.opacity = '1';
        };
    });
});

// Handle window resize - close menu on desktop
window.addEventListener('resize', () => {
    if (window.innerWidth > 768) {
        if (navLinks && navLinks.classList.contains('active')) {
            navLinks.classList.remove('active');
            body.classList.remove('menu-open');
            body.style.overflow = '';
        }
    }
});

// Initialize tooltips or any other features
document.addEventListener('DOMContentLoaded', () => {
    // Add current year to footer if needed
    const yearElement = document.querySelector('.current-year');
    if (yearElement) {
        yearElement.textContent = new Date().getFullYear();
    }
    
    // Add animation to cards on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, observerOptions);
    
    // Observe service boxes and doctor cards
    document.querySelectorAll('.service-box, .doctor-card, .dash-card').forEach(el => {
        el.style.opacity = '0';
        el.style.transform = 'translateY(30px)';
        el.style.transition = 'opacity 0.6s ease, transform 0.6s ease';
        observer.observe(el);
    });
});