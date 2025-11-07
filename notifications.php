<?php
require_once 'includes/config.php';

if (!isLoggedIn() || !isAdmin()) {
    header('Location: admin-login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Notifications - Trashbin Admin</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/admin-dashboard.css">
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="admin-dashboard.php">
        <span class="brand-circle me-2"><i class="fa-solid fa-trash-can"></i></span>
        <span class="d-none d-sm-inline">Trashbin Admin</span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="topNav">
        <ul class="navbar-nav ms-auto align-items-lg-center">
          <li class="nav-item">
            <a class="nav-link" href="profile.php" title="My Profile">
              <i class="fa-solid fa-user me-1"></i><span class="d-none d-sm-inline">Profile</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">
              <i class="fa-solid fa-right-from-bracket me-1"></i><span class="d-none d-sm-inline">Logout</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="dashboard">
    <!-- Sidebar -->
    <aside class="sidebar" id="sidebar">
      <div class="sidebar-header d-none d-md-block">
        <h6 class="sidebar-title">Menu</h6>
      </div>
      <a href="admin-dashboard.php" class="sidebar-item">
        <i class="fa-solid fa-chart-pie"></i><span>Dashboard</span>
      </a>
      <a href="bins.php" class="sidebar-item">
        <i class="fa-solid fa-trash-alt"></i><span>Bins</span>
      </a>
      <a href="janitors.php" class="sidebar-item">
        <i class="fa-solid fa-users"></i><span>Janitors</span>
      </a>
      <a href="reports.php" class="sidebar-item">
        <i class="fa-solid fa-chart-line"></i><span>Reports</span>
      </a>
      <a href="notifications.php" class="sidebar-item active">
        <i class="fa-solid fa-bell"></i><span>Notifications</span>
      </a>
      <a href="profile.php" class="sidebar-item">
        <i class="fa-solid fa-user"></i><span>My Profile</span>
      </a>
    </aside>

    <!-- Main Content -->
    <main class="content">
      <div class="section-header">
        <div>
          <h1 class="page-title">Notifications & Logs</h1>
          <p class="page-subtitle">System notifications and activity logs</p>
        </div>
        <div class="d-flex gap-2 flex-column flex-md-row">
          <div class="dropdown">
            <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="filterNotificationsDropdown" data-bs-toggle="dropdown">
              <i class="fas fa-filter me-1"></i>Filter
            </button>
            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="filterNotificationsDropdown">
              <li><a class="dropdown-item" href="#" data-filter="all">All</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item" href="#" data-filter="critical">Critical</a></li>
              <li><a class="dropdown-item" href="#" data-filter="warning">Warning</a></li>
              <li><a class="dropdown-item" href="#" data-filter="info">Info</a></li>
            </ul>
          </div>
        </div>
      </div>

      <div class="card">
        <div class="card-body p-0">
          <div class="table-responsive">
            <table class="table mb-0">
              <thead>
                <tr>
                  <th>Time</th>
                  <th>Bin ID</th>
                  <th class="d-none d-md-table-cell">Location</th>
                  <th>Alert Type</th>
                  <th class="d-none d-lg-table-cell">Status</th>
                  <th class="text-end">Action</th>
                </tr>
              </thead>
              <tbody id="notificationsTableBody">
                <tr>
                  <td colspan="6" class="text-center py-4 text-muted">No notifications found</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
        <div class="card-footer d-flex flex-wrap gap-2">
          <button class="btn btn-sm btn-outline-secondary" id="markAllReadBtn">
            <i class="fas fa-check-double me-1"></i>Mark All as Read
          </button>
          <button class="btn btn-sm btn-outline-danger" id="clearNotificationsBtn">
            <i class="fas fa-trash-alt me-1"></i>Clear All
          </button>
        </div>
      </div>
    </main>
  </div>

  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="js/bootstrap.bundle.min.js"></script>
  <script src="js/database.js"></script>
  <script src="js/dashboard.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function() {
      loadNotifications();
      
      // Filter functionality
      document.querySelectorAll('#filterNotificationsDropdown + .dropdown-menu .dropdown-item').forEach(item => {
        item.addEventListener('click', function(e) {
          e.preventDefault();
          const filter = this.getAttribute('data-filter');
          loadNotifications(filter);
        });
      });

      // Mark all as read
      document.getElementById('markAllReadBtn').addEventListener('click', function() {
        console.log('Mark all as read');
      });

      // Clear all
      document.getElementById('clearNotificationsBtn').addEventListener('click', function() {
        if (confirm('Clear all notifications?')) {
          console.log('Clear all notifications');
        }
      });
    });
  </script>
</body>
</html>
