// ============================================
// SMART TRASHBIN - PREMIUM FORGOT PASSWORD ANIMATIONS
// With Header & Footer Scripts from Login Page
// ============================================

(function() {
  'use strict';

  // ============================================
  // SCROLL PROGRESS INDICATOR
  // ============================================
  function initScrollProgress() {
    const progressBar = document.createElement('div');
    progressBar.className = 'scroll-progress';
    document.body.appendChild(progressBar);

    function updateProgress() {
      const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
      const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
      const scrolled = (winScroll / height) * 100;
      progressBar.style.width = scrolled + '%';
    }

    window.addEventListener('scroll', updateProgress, { passive: true });
    updateProgress();
  }

  // ============================================
  // HEADER SCROLL EFFECT
  // ============================================
  function initHeaderScroll() {
    const header = document.querySelector('.header');
    if (!header) return;
    
    let lastScroll = 0;

    function handleScroll() {
      const currentScroll = window.pageYOffset;

      if (currentScroll > 50) {
        header.classList.add('scrolled');
      } else {
        header.classList.remove('scrolled');
      }

      lastScroll = currentScroll;
    }

    window.addEventListener('scroll', handleScroll, { passive: true });
  }

  // ============================================
  // FORM VALIDATION & SUBMISSION
  // ============================================
  function initFormValidation() {
    const forgotForm = document.getElementById('forgotForm');
    const messageBox = document.getElementById('messageBox');
    const submitBtn = document.getElementById('submitBtn');
    const btnText = document.getElementById('btnText');
    const emailInput = document.getElementById('resetEmail');
    const emailError = document.getElementById('emailError');

    if (!forgotForm) return;

    // Real-time email validation
    if (emailInput) {
      emailInput.addEventListener('blur', () => {
        validateEmail(emailInput, emailError);
      });
    }

    // Form submission
    forgotForm.addEventListener('submit', async (e) => {
      e.preventDefault();

      const email = emailInput.value.trim();

      // Clear previous messages
      messageBox.style.display = 'none';
      emailError.textContent = '';

      // Validate email
      if (!validateEmail(emailInput, emailError)) {
        return;
      }

      // Disable button and show loading state
      submitBtn.disabled = true;
      btnText.textContent = 'Sending...';

      try {
        const formData = new FormData();
        formData.append('email', email);

        const response = await fetch('forgot-password-process.php', {
          method: 'POST',
          body: formData
        });

        const data = await response.json();

        // Show message
        messageBox.style.display = 'block';
        messageBox.textContent = data.message;

        if (data.success) {
          messageBox.style.backgroundColor = '#d1fae5';
          messageBox.style.color = '#065f46';
          messageBox.style.borderLeft = '4px solid #10b981';
          
          // Redirect after 2 seconds if redirect URL provided
          if (data.redirect) {
            setTimeout(() => {
              window.location.href = data.redirect;
            }, 2000);
          } else {
            // Clear form after success
            setTimeout(() => {
              forgotForm.reset();
              messageBox.style.display = 'none';
            }, 5000);
          }
        } else {
          messageBox.style.backgroundColor = '#fee2e2';
          messageBox.style.color = '#991b1b';
          messageBox.style.borderLeft = '4px solid #ef4444';
        }
      } catch (error) {
        console.error('Error:', error);
        messageBox.style.display = 'block';
        messageBox.textContent = 'An error occurred. Please try again later.';
        messageBox.style.backgroundColor = '#fee2e2';
        messageBox.style.color = '#991b1b';
        messageBox.style.borderLeft = '4px solid #ef4444';
      } finally {
        submitBtn.disabled = false;
        btnText.textContent = 'Send Reset Link';
      }
    });
  }

  function validateEmail(input, errorElement) {
    const email = input.value.trim();
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    
    if (!email) {
      setInputError(input, errorElement, 'Email is required');
      return false;
    } else if (!emailRegex.test(email)) {
      setInputError(input, errorElement, 'Please enter a valid email');
      return false;
    } else {
      setInputSuccess(input, errorElement);
      return true;
    }
  }

  function setInputError(input, errorElement, message) {
    input.classList.add('error');
    input.classList.remove('success');
    if (errorElement) {
      errorElement.textContent = message;
      errorElement.classList.add('show');
    }
  }

  function setInputSuccess(input, errorElement) {
    input.classList.remove('error');
    input.classList.add('success');
    if (errorElement) {
      errorElement.textContent = '';
      errorElement.classList.remove('show');
    }
  }

  // ============================================
  // REVEAL ANIMATIONS
  // ============================================
  function initRevealAnimations() {
    const revealElements = document.querySelectorAll(
      '.form-group, .btn-primary, .btn-secondary'
    );

    const observerOptions = {
      threshold: 0.15,
      rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
      entries.forEach((entry, index) => {
        if (entry.isIntersecting) {
          setTimeout(() => {
            entry.target.style.opacity = '1';
            entry.target.style.transform = 'translateY(0)';
          }, index * 100);
          
          observer.unobserve(entry.target);
        }
      });
    }, observerOptions);

    revealElements.forEach(el => {
      el.style.opacity = '0';
      el.style.transform = 'translateY(20px)';
      el.style.transition = 'opacity 0.6s ease-out, transform 0.6s ease-out';
      observer.observe(el);
    });
  }

  // ============================================
  // MAGNETIC BUTTON EFFECT
  // ============================================
  function initMagneticButtons() {
    const buttons = document.querySelectorAll('.btn-primary, .btn-secondary');

    buttons.forEach(button => {
      button.addEventListener('mousemove', (e) => {
        const rect = button.getBoundingClientRect();
        const x = e.clientX - rect.left - rect.width / 2;
        const y = e.clientY - rect.top - rect.height / 2;

        button.style.transform = `translate(${x * 0.1}px, ${y * 0.1}px)`;
      });

      button.addEventListener('mouseleave', () => {
        button.style.transform = '';
      });
    });
  }

  // ============================================
  // FLOATING SHAPES PARALLAX
  // ============================================
  function initFloatingShapes() {
    const shapes = document.querySelectorAll('.background-circle');

    function handleParallax() {
      const scrolled = window.pageYOffset;

      shapes.forEach((shape, index) => {
        const speed = 0.3 + (index * 0.1);
        const yPos = -(scrolled * speed);
        shape.style.transform = `translateY(${yPos}px)`;
      });
    }

    window.addEventListener('scroll', handleParallax, { passive: true });
  }

  // ============================================
  // FOOTER DYNAMIC TEXT
  // ============================================
  function initFooterText() {
    const footerText = document.getElementById('footerText');
    if (footerText) {
      const messages = [
        'Making waste management smarter, one bin at a time.',
        'Powered by IoT technology and sustainable innovation.',
        'Join us in creating cleaner, greener communities.',
        'Real-time monitoring for a cleaner tomorrow.'
      ];
      
      let currentIndex = 0;
      
      function updateFooterText() {
        footerText.style.opacity = '0';
        
        setTimeout(() => {
          footerText.textContent = messages[currentIndex];
          footerText.style.opacity = '1';
          currentIndex = (currentIndex + 1) % messages.length;
        }, 500);
      }
      
      // Initial text
      footerText.textContent = messages[0];
      
      // Rotate messages every 5 seconds
      setInterval(updateFooterText, 5000);
    }
  }

  // ============================================
  // NAVIGATION ACTIVE STATE
  // ============================================
  function initActiveNav() {
    const navLinks = document.querySelectorAll('.nav-link');
    const currentPage = window.location.pathname.split('/').pop() || 'index.php';

    navLinks.forEach(link => {
      const href = link.getAttribute('href');
      if (href === currentPage) {
        link.style.color = 'var(--primary-color)';
        link.style.fontWeight = '700';
      }
    });
  }

  // ============================================
  // INITIALIZATION
  // ============================================
  function init() {
    console.log('[Smart Trashbin] Initializing premium forgot password animations...');
    
    // Initialize all animation systems
    initScrollProgress();
    initHeaderScroll();
    initFormValidation();
    initRevealAnimations();
    initMagneticButtons();
    initFloatingShapes();
    initFooterText();
    initActiveNav();
    
    console.log('[Smart Trashbin] All animations initialized successfully!');
  }

  // ============================================
  // RUN ON DOM READY
  // ============================================
  if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', init);
  } else {
    init();
  }

})();
