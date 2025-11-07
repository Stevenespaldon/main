<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if user is logged in, redirect to login if not
if (!isset($_SESSION['user_id'])) {
    // Allow access to login and registration pages
    $allowed_pages = ['login.php', 'registration.php', 'forgot-password.php'];
    $current_page = basename($_SERVER['PHP_SELF']);
    
    if (!in_array($current_page, $allowed_pages)) {
        header('Location: login.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Smart Trashbin - Management System</title>
    <!-- Added both admin and login CSS -->
    <link rel="stylesheet" href="css/admin-dashboard.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/login.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        /* Scoped header styles to match provided design/alignment */
        .st-header {
            width: 100%;
            background: #fff;
            box-sizing: border-box;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            font-family: 'Inter', system-ui, -apple-system, "Segoe UI", Roboto, "Helvetica Neue", Arial;
        }
        .st-header .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 12px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
        }
        .st-brand {
            display: flex;
            align-items: center;
            gap: 14px;
        }
        .st-brand .icon {
            width: 44px;
            height: 44px;
            background: linear-gradient(180deg, rgba(7,136,62,0.12), rgba(7,136,62,0.08));
            color: #0aa24a;
            border-radius: 6px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            box-shadow: 0 6px 18px rgba(11,107,59,0.06);
        }
        .st-brand .text {
            display: flex;
            flex-direction: column;
            line-height: 1;
        }
        .st-brand .text .title {
            font-size: 18px;
            font-weight: 700;
            color: #0b6b3b;
            margin: 0;
        }
        .st-brand .text .subtitle {
            font-size: 12px;
            color: #5a6b63;
            margin: 0;
            margin-top: 2px;
        }

        /* Right nav */
        .st-nav {
            display: flex;
            gap: 22px;
            align-items: center;
        }
        .st-nav a {
            color: #0b6b3b;
            text-decoration: none;
            font-weight: 600;
            font-size: 14px;
            padding: 6px 0;
        }
        .st-nav a:hover { opacity: 0.88; }

        /* Responsive adjustments */
        @media (max-width: 780px) {
            .st-nav { display: none; }
            .st-header .container { padding: 12px 14px; }
        }
    </style>
</head>
<body>

<!-- Added actual navigation header content -->
<link rel="stylesheet" href="css/header.css">

<header class="st-header" role="banner" aria-label="Smart Trashbin header">
  <div class="container">
    <div class="st-brand" aria-hidden="false">
      <div class="icon" aria-hidden="true"><i class="fa-solid fa-trash-can"></i></div>
      <div class="text">
        <div class="title">Smart Trashbin</div>
        <div class="subtitle">Intelligent Waste Management System</div>
      </div>
    </div>

    <nav class="st-nav" aria-label="Primary">
      <a href="index.php">Home</a>
      <a href="about.php">About</a>
      <a href="features.php">Features</a>
      <a href="contact.php">Contact</a>
    </nav>
  </div>
</header>

</body>
</html>
