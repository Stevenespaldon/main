<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Smart Trashbin - Forgot Password</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="css/forgot-password.css">
</head>
<body>

  <!-- Navigation Header -->
  <header class="header">
    <div class="header-container">
      <div class="logo-section">
        <div class="logo-wrapper">
          <svg class="animated-logo" viewBox="0 0 100 100" xmlns="http://www.w3.org/2000/svg">
            <rect x="30" y="35" width="40" height="50" rx="6" fill="#16a34a"/>
            <rect x="25" y="30" width="50" height="5" fill="#15803d"/>
            <rect x="40" y="20" width="20" height="8" rx="2" fill="#22c55e"/>
            <line x1="40" y1="45" x2="40" y2="80" stroke="#f0fdf4" stroke-width="3" />
            <line x1="50" y1="45" x2="50" y2="80" stroke="#f0fdf4" stroke-width="3" />
            <line x1="60" y1="45" x2="60" y2="80" stroke="#f0fdf4" stroke-width="3" />
          </svg>
        </div>
        <div class="logo-text-section">
          <h1 class="brand-name">Smart Trashbin</h1>
          <p class="header-subtitle">Intelligent Waste Management System</p>
        </div>
      </div>
      <nav class="nav-center">
        <a href="index.php" class="nav-link">Home</a>
        <a href="about.php" class="nav-link">About</a>
        <a href="contact.php" class="nav-link">Contact</a>
        <a href="features.php" class="nav-link">Features</a>
      </nav>
      <nav class="nav-buttons">
        <a href="registration.php" class="btn btn-signup">
          <i class="fas fa-user-plus"></i> Sign Up
        </a>
      </nav>
    </div>
  </header>

  <!-- Forgot Password Container -->
  <div class="forgot-container">
    <!-- Background floating circles -->
    <div class="background-circle background-circle-1"></div>
    <div class="background-circle background-circle-2"></div>
    <div class="background-circle background-circle-3"></div>

    <div class="forgot-wrapper">
      <div class="forgot-header">
        <div class="forgot-icon">
          <i class="fas fa-lock"></i>
        </div>
        <h1>Forgot Password?</h1>
        <p>No worries! We'll help you reset it.</p>
      </div>

      <div class="forgot-content">
        <!-- Message box for displaying responses -->
        <div id="messageBox" style="display: none; margin-bottom: 20px; padding: 15px; border-radius: 5px; font-weight: 500;"></div>

        <!-- Fixed typo: changed "methood" to "method" -->
        <form method="post" action="send-password-reset.php">
          <div class="form-group">
            <label for="resetEmail">Email Address</label>
            <div class="input-wrapper">
              <i class="fas fa-envelope"></i>
              <input type="email" id="resetEmail" name="email" placeholder="Enter your registered email" required>
            </div>
            <div class="error-message" id="emailError"></div>
          </div>

          <button type="submit" class="btn-primary" id="submitBtn">
            <i class="fas fa-paper-plane me-2"></i> <span id="btnText">Send Reset Link</span>
          </button>
          <button type="button" class="btn-secondary" onclick="window.history.back()">
            <i class="fas fa-arrow-left me-2"></i> Back to Login
          </button>
        </form>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <div class="footer">
    <div class="footer-content">
      <div class="footer-links">
        <a href="privacy.php">Privacy Policy</a>
        <span class="separator">•</span>
        <a href="terms.php">Terms of Service</a>
        <span class="separator">•</span>
        <a href="support.php">Support</a>
      </div>
      <p class="footer-text" id="footerText"></p>
      <p class="footer-copyright">
        &copy; 2025 Smart Trashbin. All rights reserved.
      </p>
    </div>
  </div>

  <!-- JavaScript -->
  <script src="js/forgot-password.js"></script>
</body>
</html>
