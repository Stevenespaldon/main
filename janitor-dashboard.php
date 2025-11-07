<?php
require_once 'includes/config.php';

// Check if user is logged in
if (!isLoggedIn()) {
    header('Location: user-login.php');
    exit;
}

// Check if user is janitor
if (!isJanitor()) {
    header('Location: admin-dashboard.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Janitor Dashboard - Trashbin Management</title>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="css/bootstrap.min.css">
  <link rel="stylesheet" href="css/janitor-dashboard.css">
</head>
<body>
  <!-- Navigation -->
  <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
    <div class="container-fluid">
      <a class="navbar-brand" href="#">
        <span class="brand-circle me-2"><i class="fa-solid fa-trash-can"></i></span>
        <span>Trashbin Janitor</span>
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#topNav">
        <span class="navbar-toggler-icon"></span>
      </button>
      <div class="collapse navbar-collapse" id="topNav">
        <ul class="navbar-nav ms-auto align-items-lg-center">
          <li class="nav-item me-2">
            <a class="nav-link position-relative" href="#" id="notificationsBtn">
              <i class="fa-solid fa-bell"></i>
              <span class="badge rounded-pill bg-danger position-absolute translate-middle" id="notificationCount" style="top:8px; left:18px; display:none;">0</span>
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="logout.php" title="Logout">
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
      <div class="sidebar-header">
        <h6 class="sidebar-title">Menu</h6>
      </div>
      <a href="#" class="sidebar-item active" data-section="dashboard">
        <i class="fa-solid fa-chart-pie"></i><span>Dashboard</span>
      </a>
      <a href="#" class="sidebar-item" data-section="assigned-bins">
        <i class="fa-solid fa-trash-alt"></i><span>Assigned Bins</span>
      </a>
      <a href="#" class="sidebar-item" data-section="task-history">
        <i class="fa-solid fa-history"></i><span>Task History</span>
      </a>
      <a href="#" class="sidebar-item" data-section="alerts">
        <i class="fa-solid fa-bell"></i><span>Alerts</span>
      </a>
      <a href="#" class="sidebar-item" data-section="my-profile">
        <i class="fa-solid fa-user"></i><span>My Profile</span>
      </a>
    </aside>

    <!-- Main Content -->
    <main class="content">
      <!-- Dashboard Section -->
      <section id="dashboardSection" class="content-section">
        <div class="section-header">
          <div>
            <h1 class="page-title">Dashboard</h1>
            <p class="page-subtitle">Welcome back! Here's your daily overview.</p>
          </div>
          <div class="btn-group">
            <button class="btn btn-outline-secondary btn-sm" onclick="filterDashboard('today')">Today</button>
            <button class="btn btn-outline-secondary btn-sm" onclick="filterDashboard('week')">Week</button>
            <button class="btn btn-outline-secondary btn-sm" onclick="filterDashboard('month')">Month</button>
          </div>
        </div>

        <!-- Stats Cards -->
        <div class="row g-4 mb-5">
          <div class="col-md-4">
            <div class="stat-card">
              <div class="stat-icon">
                <i class="fa-solid fa-trash-alt"></i>
              </div>
              <div class="stat-content">
                <h6>Assigned Bins</h6>
                <h2 id="assignedBinsCount">0</h2>
                <small><i class="fas fa-info-circle me-1"></i>Active assignments</small>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="stat-card">
              <div class="stat-icon warning">
                <i class="fa-solid fa-clock"></i>
              </div>
              <div class="stat-content">
                <h6>Pending Tasks</h6>
                <h2 id="pendingTasksCount">0</h2>
                <small><i class="fas fa-clock me-1"></i>Awaiting action</small>
              </div>
            </div>
          </div>
          <div class="col-md-4">
            <div class="stat-card">
              <div class="stat-icon success">
                <i class="fa-solid fa-check-circle"></i>
              </div>
              <div class="stat-content">
                <h6>Completed Today</h6>
                <h2 id="completedTodayCount">0</h2>
                <small><i class="fas fa-check-circle me-1"></i>Great work!</small>
              </div>
            </div>
          </div>
        </div>

        <!-- Recent Alerts -->
        <div class="card">
          <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="fas fa-bell me-2"></i>Recent Alerts</h5>
            <a href="#" class="btn btn-sm btn-link" onclick="showSection('alerts'); return false;">View All</a>
          </div>
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table mb-0">
                <thead>
                  <tr>
                    <th>Time</th>
                    <th>Bin ID</th>
                    <th>Location</th>
                    <th>Status</th>
                    <th class="text-end">Action</th>
                  </tr>
                </thead>
                <tbody id="recentAlertsBody">
                  <tr>
                    <td colspan="5" class="text-center py-4 text-muted">No recent alerts</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </section>

      <!-- Assigned Bins Section -->
      <section id="assignedBinsSection" class="content-section" style="display:none;">
        <div class="section-header">
          <div>
            <h1 class="page-title">Assigned Bins</h1>
            <p class="page-subtitle">Manage and monitor your assigned waste bins.</p>
          </div>
          <div class="d-flex gap-2">
            <div class="input-group" style="max-width: 300px;">
              <span class="input-group-text bg-white border-end-0"><i class="fas fa-search text-muted"></i></span>
              <input type="text" class="form-control border-start-0 ps-0" id="searchBinsInput" placeholder="Search bins...">
            </div>
            <div class="dropdown">
              <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="filterBinsDropdown" data-bs-toggle="dropdown">
                <i class="fas fa-filter me-1"></i>Filter
              </button>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="filterBinsDropdown">
                <li><a class="dropdown-item" href="#" data-filter="all">All Bins</a></li>
                <li><hr class="dropdown-divider"></li>
                <li><a class="dropdown-item" href="#" data-filter="needs_attention">Needs Attention</a></li>
                <li><a class="dropdown-item" href="#" data-filter="full">Full</a></li>
                <li><a class="dropdown-item" href="#" data-filter="in_progress">In Progress</a></li>
                <li><a class="dropdown-item" href="#" data-filter="empty">Empty</a></li>
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
                    <th>Bin ID</th>
                    <th>Location</th>
                    <th>Type</th>
                    <th>Status</th>
                    <th>Last Emptied</th>
                    <th class="text-end">Action</th>
                  </tr>
                </thead>
                <tbody id="assignedBinsBody">
                  <tr>
                    <td colspan="6" class="text-center py-4 text-muted">No bins assigned</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </section>

      <!-- Task History Section -->
      <section id="taskHistorySection" class="content-section" style="display:none;">
        <div class="section-header">
          <div>
            <h1 class="page-title">Task History</h1>
            <p class="page-subtitle">View your completed and ongoing tasks.</p>
          </div>
          <div class="d-flex gap-2">
            <div class="input-group" style="max-width: 200px;">
              <span class="input-group-text bg-white"><i class="fas fa-calendar-alt text-muted"></i></span>
              <input type="date" class="form-control" id="historyDateFilter">
            </div>
            <button class="btn btn-primary" id="filterHistoryBtn"><i class="fas fa-filter me-1"></i>Apply Filters</button>
          </div>
        </div>

        <div class="card">
          <div class="card-body p-0">
            <div class="table-responsive">
              <table class="table mb-0">
                <thead>
                  <tr>
                    <th>Date & Time</th>
                    <th>Bin ID</th>
                    <th>Location</th>
                    <th>Action</th>
                    <th>Status</th>
                    <th class="text-end">Details</th>
                  </tr>
                </thead>
                <tbody id="taskHistoryBody">
                  <tr>
                    <td colspan="6" class="text-center py-4 text-muted">No task history found</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </section>

      <!-- Alerts Section -->
      <section id="alertsSection" class="content-section" style="display:none;">
        <div class="section-header">
          <div>
            <h1 class="page-title">Alerts Dashboard</h1>
            <p class="page-subtitle">Monitor critical and important notifications.</p>
          </div>
          <div class="d-flex gap-2 align-items-center">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="alertSoundSwitch" checked>
              <label class="form-check-label" for="alertSoundSwitch">Alert Sound</label>
            </div>
            <div class="dropdown">
              <button class="btn btn-outline-secondary dropdown-toggle" type="button" id="filterAlertsDropdown" data-bs-toggle="dropdown">
                <i class="fas fa-filter me-1"></i>Filter
              </button>
              <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="filterAlertsDropdown">
                <li><a class="dropdown-item active" href="#" data-filter="all">All Alerts</a></li>
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
                    <th>Location</th>
                    <th>Alert Type</th>
                    <th>Status</th>
                    <th class="text-end">Action</th>
                  </tr>
                </thead>
                <tbody id="alertsTableBody">
                  <tr>
                    <td colspan="6" class="text-center py-4 text-muted">No alerts found</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
          <div class="card-footer d-flex justify-content-between align-items-center">
            <div class="btn-group">
              <button type="button" class="btn btn-sm btn-outline-secondary" id="markAllReadBtn"><i class="fas fa-check-double me-1"></i>Mark All as Read</button>
              <button type="button" class="btn btn-sm btn-outline-danger" id="clearAlertsBtn"><i class="fas fa-trash-alt me-1"></i>Clear All</button>
            </div>
          </div>
        </div>
      </section>

      <!-- My Profile Section -->
      <section id="myProfileSection" class="content-section" style="display:none;">
        <div class="section-header">
          <div>
            <h1 class="page-title">My Profile</h1>
            <p class="page-subtitle">Manage your personal information and settings.</p>
          </div>
        </div>
        
        <!-- Enhanced profile layout with premium card design and better spacing -->
        <div class="profile-container">
          <!-- Profile Header Card -->
          <div class="profile-header-card">
            <div class="profile-header-content">
              <div class="profile-picture-wrapper">
                <img id="profileImg" src="https://ui-avatars.com/api/?name=<?php echo urlencode($_SESSION['name'] ?? 'Janitor'); ?>&background=0D6EFD&color=fff&size=150" 
                     alt="Profile Picture" class="profile-picture">
                <input type="file" id="photoInput" accept=".png,.jpg,.jpeg" style="display: none;">
                <button type="button" class="profile-edit-btn" id="changePhotoBtn" title="Change Photo">
                  <i class="fa-solid fa-camera"></i>
                </button>
              </div>
              <div class="profile-info">
                <h2 class="profile-name"><?php echo htmlspecialchars($_SESSION['name'] ?? 'Janitor'); ?></h2>
                <p class="profile-role">Janitor</p>
                <div id="photoMessage" class="validation-message"></div>
              </div>
            </div>
          </div>

          <!-- Profile Content Grid -->
          <div class="profile-content-grid">
            <!-- Left Column - Quick Stats -->
            <div class="profile-sidebar">
              <div class="profile-stats-card">
                <h6 class="stats-title">Quick Stats</h6>
                <div class="stat-item">
                  <span class="stat-label">Tasks Completed</span>
                  <span class="stat-value">24</span>
                </div>
                <div class="stat-item">
                  <span class="stat-label">Bins Managed</span>
                  <span class="stat-value">12</span>
                </div>
                <div class="stat-item">
                  <span class="stat-label">Member Since</span>
                  <span class="stat-value">2024</span>
                </div>
              </div>

              <div class="profile-menu-card">
                <h6 class="menu-title">Settings</h6>
                <a href="#personal-info" class="profile-menu-item active" data-bs-toggle="list">
                  <i class="fa-solid fa-user"></i>
                  <span>Personal Information</span>
                </a>
                <a href="#change-password" class="profile-menu-item" data-bs-toggle="list">
                  <i class="fa-solid fa-key"></i>
                  <span>Change Password</span>
                </a>
              </div>
            </div>

            <!-- Right Column - Forms -->
            <div class="profile-main">
              <div class="tab-content">
                <!-- Personal Information Tab -->
                <div class="tab-pane fade show active" id="personal-info">
                  <div class="profile-form-card">
                    <div class="form-card-header">
                      <h5><i class="fa-solid fa-user-circle me-2"></i>Personal Information</h5>
                    </div>
                    <div class="form-card-body">
                      <div id="personalInfoAlert" class="alert alert-message" role="alert"></div>
                      <form id="personalInfoForm">
                        <div class="form-row">
                          <div class="form-group">
                            <label class="form-label">First Name</label>
                            <input type="text" class="form-control" id="firstName" value="<?php echo explode(' ', $_SESSION['name'] ?? 'John')[0]; ?>" required>
                            <div class="validation-message"></div>
                          </div>
                          <div class="form-group">
                            <label class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lastName" value="<?php echo explode(' ', $_SESSION['name'] ?? 'Doe')[1] ?? ''; ?>" required>
                            <div class="validation-message"></div>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="form-label">Email Address</label>
                          <input type="email" class="form-control" id="email" value="<?php echo htmlspecialchars($_SESSION['email'] ?? 'janitor@example.com'); ?>" required>
                          <div class="validation-message"></div>
                        </div>
                        <div class="form-group">
                          <label class="form-label">Phone Number</label>
                          <input type="tel" class="form-control" id="phoneNumber" value="+1 (555) 123-4567" placeholder="11 digits">
                          <div class="validation-message"></div>
                        </div>
                        <div class="form-group">
                          <label class="form-label">Assigned Area</label>
                          <input type="text" class="form-control" value="Downtown District" readonly style="background-color: #f5f5f5; cursor: not-allowed;">
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg">
                          <i class="fa-solid fa-save me-2"></i>Save Changes
                        </button>
                      </form>
                    </div>
                  </div>
                </div>
                
                <!-- Change Password Tab -->
                <div class="tab-pane fade" id="change-password">
                  <div class="profile-form-card">
                    <div class="form-card-header">
                      <h5><i class="fa-solid fa-lock me-2"></i>Change Password</h5>
                    </div>
                    <div class="form-card-body">
                      <div id="passwordAlert" class="alert alert-message" role="alert"></div>
                      <form id="changePasswordForm">
                        <div class="form-group">
                          <label class="form-label">Current Password</label>
                          <div class="password-input-container">
                            <input type="password" class="form-control password-input" id="currentPassword" placeholder="Enter current password" required>
                            <button type="button" class="password-toggle-btn" data-target="#currentPassword">
                              <i class="fa-solid fa-eye"></i>
                            </button>
                          </div>
                          <div class="validation-message"></div>
                        </div>
                        <div class="form-group">
                          <label class="form-label">New Password</label>
                          <div class="password-input-container">
                            <input type="password" class="form-control password-input" id="newPassword" placeholder="Enter new password" required>
                            <button type="button" class="password-toggle-btn" data-target="#newPassword">
                              <i class="fa-solid fa-eye"></i>
                            </button>
                          </div>
                          <div class="validation-message"></div>
                          <div class="password-strength">
                            <small>Password strength:</small>
                            <div class="strength-bar">
                              <div class="strength-fill"></div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group">
                          <label class="form-label">Confirm New Password</label>
                          <div class="password-input-container">
                            <input type="password" class="form-control password-input" id="confirmNewPassword" placeholder="Confirm new password" required>
                            <button type="button" class="password-toggle-btn" data-target="#confirmNewPassword">
                              <i class="fa-solid fa-eye"></i>
                            </button>
                          </div>
                          <div class="validation-message"></div>
                        </div>
                        <button type="submit" class="btn btn-primary btn-lg">
                          <i class="fa-solid fa-lock me-2"></i>Update Password
                        </button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </section>
    </main>
  </div>

  <!-- Status Update Modal -->
  <div class="modal fade" id="statusUpdateModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Update Bin Status</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form id="statusUpdateForm">
            <input type="hidden" id="binIdInput">
            <div class="mb-3">
              <label for="statusSelect" class="form-label">Status <span class="text-danger">*</span></label>
              <select class="form-select form-select-lg" id="statusSelect" required>
                <option value="" disabled selected>Select status...</option>
                <option value="empty">Empty</option>
                <option value="in_progress">In Progress</option>
                <option value="full">Full</option>
                <option value="needs_attention">Needs Attention</option>
                <option value="out_of_service">Out of Service</option>
              </select>
            </div>
            <div class="mb-4">
              <label for="notesInput" class="form-label">Notes <small class="text-muted">(Optional)</small></label>
              <textarea class="form-control" id="notesInput" rows="3" placeholder="Add any additional notes..."></textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" id="updateStatusBtn"><i class="fas fa-save me-1"></i>Update Status</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Notifications Dropdown Panel -->
  <div class="modal fade" id="notificationsModal" tabindex="-1">
    <div class="modal-dialog modal-dialog-scrollable">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><i class="fas fa-bell me-2"></i>Notifications</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body p-0">
          <div id="notificationsPanel">
            <div class="text-center py-4 text-muted">
              <i class="fas fa-inbox" style="font-size: 40px; opacity: 0.5;"></i>
              <p class="mt-2">No notifications</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Task History Details Modal -->
  <div class="modal fade" id="taskDetailsModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><i class="fas fa-info-circle me-2"></i>Task Details</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <label class="form-label fw-bold">Date & Time</label>
            <p id="detailDate" class="mb-0"></p>
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold">Bin ID</label>
            <p id="detailBinId" class="mb-0"></p>
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold">Location</label>
            <p id="detailLocation" class="mb-0"></p>
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold">Action</label>
            <p id="detailAction" class="mb-0"></p>
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold">Status</label>
            <p id="detailStatus" class="mb-0"></p>
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold">Notes</label>
            <p id="detailNotes" class="mb-0"></p>
          </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>

  <!-- Handle Alert Modal -->
  <div class="modal fade" id="handleAlertModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><i class="fas fa-check-circle me-2"></i>Handle Alert</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form id="handleAlertForm">
            <input type="hidden" id="handleAlertBinId">
            <div class="mb-3">
              <label class="form-label fw-bold">Bin ID</label>
              <p id="handleBinId" class="mb-0"></p>
            </div>
            <div class="mb-3">
              <label class="form-label fw-bold">Location</label>
              <p id="handleLocation" class="mb-0"></p>
            </div>
            <div class="mb-3">
              <label class="form-label">Action Taken</label>
              <select class="form-control form-select" id="handleAction" required>
                <option value="">Select action...</option>
                <option value="emptied">Bin Emptied</option>
                <option value="maintenance">Maintenance Performed</option>
                <option value="inspected">Bin Inspected</option>
                <option value="repaired">Bin Repaired</option>
                <option value="other">Other</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Notes</label>
              <textarea class="form-control" id="handleNotes" rows="3" placeholder="Enter any additional notes..."></textarea>
            </div>
            <div class="mb-3">
              <label class="form-label">Completion Status</label>
              <select class="form-control form-select" id="handleStatus" required>
                <option value="completed">Completed</option>
                <option value="in_progress">In Progress</option>
                <option value="pending">Pending</option>
              </select>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" onclick="submitHandleAlert()">
            <i class="fas fa-save me-1"></i>Submit Action
          </button>
        </div>
      </div>
    </div>
  </div>

  <!-- Update Bin Status Modal (for Assigned Bins) -->
  <div class="modal fade" id="updateBinStatusModal" tabindex="-1">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title"><i class="fas fa-sync-alt me-2"></i>Update Bin Status</h5>
          <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
        </div>
        <div class="modal-body">
          <form id="updateBinStatusForm">
            <input type="hidden" id="updateBinId">
            <div class="mb-3">
              <label class="form-label fw-bold">Bin ID</label>
              <p id="updateBinIdDisplay" class="mb-0"></p>
            </div>
            <div class="mb-3">
              <label class="form-label fw-bold">Location</label>
              <p id="updateBinLocation" class="mb-0"></p>
            </div>
            <div class="mb-3">
              <label class="form-label">New Status</label>
              <select class="form-control form-select" id="updateNewStatus" required>
                <option value="">Select status...</option>
                <option value="empty">Empty</option>
                <option value="in_progress">In Progress</option>
                <option value="needs_attention">Needs Attention</option>
                <option value="full">Full</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Action Type</label>
              <select class="form-control form-select" id="updateActionType" required>
                <option value="">Select action...</option>
                <option value="emptied">Emptying Bin</option>
                <option value="cleaning">Cleaning Bin</option>
                <option value="inspection">Inspection</option>
                <option value="maintenance">Maintenance</option>
              </select>
            </div>
            <div class="mb-3">
              <label class="form-label">Notes</label>
              <textarea class="form-control" id="updateStatusNotes" rows="3" placeholder="Enter any additional notes..."></textarea>
            </div>
          </form>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
          <button type="button" class="btn btn-primary" onclick="submitBinStatusUpdate()">
            <i class="fas fa-save me-1"></i>Update Status
          </button>
        </div>
      </div>
    </div>
  </div>

  <?php include 'includes/footer.php'; ?>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/janitor-dashboard.js"></script>
</body>
</html>
