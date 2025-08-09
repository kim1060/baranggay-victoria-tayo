<?php
require_once("INCLUDE/initialize.php");

// Get overall statistics
$totalUsers = 0;
$totalAppointments = 0;
$pendingAppointments = 0;
$confirmedAppointments = 0;
$approvedAppointments = 0;

// Total Users
$sql = "SELECT COUNT(*) as count FROM user_account WHERE UserType = 'USER'";
$mydb->setQuery($sql);
$result = $mydb->loadSingleResult();
$totalUsers = $result->count ?? 0;
?>

    <style>
        /* Page-scoped left navbar for admin dashboard only */
        body.admin-dashboard-leftnav .navbar.navbar-custom {
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            width: 260px;
            z-index: 1030;
            border-right: 1px solid rgba(0,0,0,0.08);
            background-color: #1b5e20 !important; /* deep green */
        }
        body.admin-dashboard-leftnav .navbar.navbar-custom .container-fluid {
            flex-direction: column;
            align-items: stretch;
            height: 100%;
            padding-top: 1rem;
            padding-bottom: 1rem;
        }
        body.admin-dashboard-leftnav .navbar.navbar-custom .navbar-brand {
            margin-bottom: 1rem;
            color: #ffffff !important;
        }
        body.admin-dashboard-leftnav .navbar.navbar-custom .navbar-collapse {
            display: block !important;
        }
        body.admin-dashboard-leftnav .navbar.navbar-custom .navbar-nav {
            flex-direction: column;
            gap: .25rem;
        }
        body.admin-dashboard-leftnav .navbar.navbar-custom .nav-link {
            color: rgba(255,255,255,0.9) !important;
        }
        body.admin-dashboard-leftnav .navbar.navbar-custom .nav-link:hover,
        body.admin-dashboard-leftnav .navbar.navbar-custom .nav-link:focus {
            background-color: rgba(255, 235, 59, 0.18) !important; /* soft yellow */
            color: #ffffff !important;
        }
        body.admin-dashboard-leftnav .navbar.navbar-custom .dropdown-menu {
            background: #ffffff !important;
            border-color: #c8e6c9 !important;
        }
        body.admin-dashboard-leftnav .forcontent {
            margin-left: 260px;
        }
        @media (max-width: 991.98px) {
            body.admin-dashboard-leftnav .navbar.navbar-custom {
                width: 220px;
            }
            body.admin-dashboard-leftnav .forcontent {
                margin-left: 220px;
            }
        }

        /* Page background and hint colors */
        body.admin-dashboard-leftnav {
            background-color: #f5fbe6; /* soft green tint */
        }
        body.admin-dashboard-leftnav .card-header {
            background-color: #fffbe6 !important; /* light yellow hint */
        }
        body.admin-dashboard-leftnav .btn-outline-primary {
            color: #1b5e20 !important;
            border-color: #1b5e20 !important;
        }
        body.admin-dashboard-leftnav .btn-outline-primary:hover {
            background-color: #1b5e20 !important;
            color: #ffffff !important;
        }
        body.admin-dashboard-leftnav .form-select {
            border-color: #c8e6c9;
        }
        body.admin-dashboard-leftnav .form-select:focus {
            border-color: #66bb6a;
            box-shadow: 0 0 0 .2rem rgba(102, 187, 106, 0.25);
        }
    </style>

    <!-- Charts Section -->
    <div class="row mb-2 container-fluid" style="max-width: 1280px; margin: 0 auto;">
        <div class="col-12 d-flex justify-content-start align-items-center gap-2 mb-5">
            <label for="chartFilter" class="mb-0 text-muted">Show:</label>
            <select id="chartFilter" class="form-select" style="min-width: 220px;">
                <option value="monthly" selected>Monthly</option>
                <option value="weekly">Weekly</option>
                <option value="daily">Daily</option>
            </select>
        </div>
    </div>

    <div class="row mb-4 container-fluid" style="max-width: 1280px; margin: 0 auto;">
        <div class="col-lg-8 mb-4" id="chartsMainCol">
            <div class="card border-0 shadow-sm mb-4" id="monthlyChartCard">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="card-title mb-0"><i class="bi bi-graph-up"></i> Monthly Appointment Trends</h5>
                </div>
                <div class="card-body">
                    <canvas id="appointmentChart" height="100"></canvas>
                </div>
            </div>
            <div class="card border-0 shadow-sm mb-4" id="weeklyChartCard">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="card-title mb-0"><i class="bi bi-graph-up"></i> Weekly Appointment Trends</h5>
                </div>
                <div class="card-body">
                    <canvas id="weeklyAppointmentChart" height="100"></canvas>
                </div>
            </div>
            <div class="card border-0 shadow-sm" id="dailyChartCard">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="card-title mb-0"><i class="bi bi-graph-up"></i> Daily Appointment Trends</h5>
                </div>
                <div class="card-body">
                    <canvas id="dailyAppointmentChart" height="100"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4" id="chartsSideCol">
            <div class="card border-0 shadow-sm" id="serviceChartCard">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="card-title mb-0"><i class="bi bi-pie-chart"></i> Service Distribution</h5>
                </div>
                <div class="card-body">
                    <canvas id="serviceChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row mb-4 container-fluid" style="max-width: 1280px; margin: 0 auto;">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0"><i class="bi bi-activity"></i> Recent Activity</h5>
                        <a href="index.php?view=consolidatedlist" class="btn btn-outline-primary btn-sm">View All</a>
                    </div>
                </div>

<?php
// Total Appointments (all types)
$appointmentTables = ['_clearance', '_cedula', '_indigency', '_permit', '_court'];
foreach($appointmentTables as $table) {
    $sql = "SELECT COUNT(*) as count FROM {$table}";
    $mydb->setQuery($sql);
    $result = $mydb->loadSingleResult();
    $totalAppointments += $result->count ?? 0;

    // Pending
    $sql = "SELECT COUNT(*) as count FROM {$table} WHERE Status = 'PENDING'";
    $mydb->setQuery($sql);
    $result = $mydb->loadSingleResult();
    $pendingAppointments += $result->count ?? 0;

    // Confirmed
    $sql = "SELECT COUNT(*) as count FROM {$table} WHERE Status = 'CONFIRMED'";
    $mydb->setQuery($sql);
    $result = $mydb->loadSingleResult();
    $confirmedAppointments += $result->count ?? 0;

    // Approved
    $sql = "SELECT COUNT(*) as count FROM {$table} WHERE Status = 'APPROVED'";
    $mydb->setQuery($sql);
    $result = $mydb->loadSingleResult();
    $approvedAppointments += $result->count ?? 0;
}

// Get service-specific stats
$clearanceStats = [];
$cedulaStats = [];
$indigencyStats = [];
$permitStats = [];
$courtStats = [];

function getServiceStats($table) {
    global $mydb;
    $stats = [];

    $sql = "SELECT COUNT(*) as count FROM {$table}";
    $mydb->setQuery($sql);
    $result = $mydb->loadSingleResult();
    $stats['total'] = $result->count ?? 0;

    $sql = "SELECT COUNT(*) as count FROM {$table} WHERE Status = 'PENDING'";
    $mydb->setQuery($sql);
    $result = $mydb->loadSingleResult();
    $stats['pending'] = $result->count ?? 0;

    $sql = "SELECT COUNT(*) as count FROM {$table} WHERE Status = 'CONFIRMED'";
    $mydb->setQuery($sql);
    $result = $mydb->loadSingleResult();
    $stats['confirmed'] = $result->count ?? 0;

    $sql = "SELECT COUNT(*) as count FROM {$table} WHERE Status = 'APPROVED'";
    $mydb->setQuery($sql);
    $result = $mydb->loadSingleResult();
    $stats['approved'] = $result->count ?? 0;

    return $stats;
}

$clearanceStats = getServiceStats('_clearance');
$cedulaStats = getServiceStats('_cedula');
$indigencyStats = getServiceStats('_indigency');
$permitStats = getServiceStats('_permit');
$courtStats = getServiceStats('_court');

// Recent activity
$sql = "SELECT
            'Clearance' as service_type,
            CONCAT(b.Firstname, ' ', b.Lastname) as user_name,
            a.Status,
            a.Date as created_date
        FROM _clearance a
        JOIN user_account b ON a.UserID = b.UserID
        UNION ALL
        SELECT
            'Cedula' as service_type,
            CONCAT(b.Firstname, ' ', b.Lastname) as user_name,
            a.Status,
            a.Date as created_date
        FROM _cedula a
        JOIN user_account b ON a.UserID = b.UserID
        UNION ALL
        SELECT
            'Indigency' as service_type,
            CONCAT(b.Firstname, ' ', b.Lastname) as user_name,
            a.Status,
            a.Date as created_date
        FROM _indigency a
        JOIN user_account b ON a.UserID = b.UserID
        UNION ALL
        SELECT
            'Permit' as service_type,
            CONCAT(b.Firstname, ' ', b.Lastname) as user_name,
            a.Status,
            a.Date as created_date
        FROM _permit a
        JOIN user_account b ON a.UserID = b.UserID
        UNION ALL
        SELECT
            'Court' as service_type,
            CONCAT(b.Firstname, ' ', b.Lastname) as user_name,
            a.Status,
            a.Date as created_date
        FROM _court a
        JOIN user_account b ON a.UserID = b.UserID
        ORDER BY created_date DESC
        LIMIT 10";
$mydb->setQuery($sql);
$recentActivities = $mydb->loadResultList();

// Get real monthly appointment data for line chart
$monthlyData = [];
$monthLabels = [];
for ($i = 6; $i >= 0; $i--) {
    $monthStart = date('Y-m-01', strtotime("-$i months"));
    $monthEnd = date('Y-m-t', strtotime("-$i months"));
    $monthLabel = date('M Y', strtotime("-$i months"));

    $monthlyCount = 0;
    foreach($appointmentTables as $table) {
        $sql = "SELECT COUNT(*) as count FROM {$table} WHERE Date >= '$monthStart' AND Date <= '$monthEnd'";
        $mydb->setQuery($sql);
        $result = $mydb->loadSingleResult();
        $monthlyCount += $result->count ?? 0;
    }

    $monthlyData[] = $monthlyCount;
    $monthLabels[] = $monthLabel;
}

// Weekly appointment data (last 7 weeks)
$weeklyData = [];
$weekLabels = [];
for ($i = 6; $i >= 0; $i--) {
    $weekStart = date('Y-m-d', strtotime("monday -$i week"));
    $weekEnd = date('Y-m-d', strtotime("sunday -$i week"));
    $weekLabel = date('M d', strtotime($weekStart)) . ' - ' . date('M d', strtotime($weekEnd));

    $weeklyCount = 0;
    foreach($appointmentTables as $table) {
        $sql = "SELECT COUNT(*) as count FROM {$table} WHERE Date >= '$weekStart' AND Date <= '$weekEnd'";
        $mydb->setQuery($sql);
        $result = $mydb->loadSingleResult();
        $weeklyCount += $result->count ?? 0;
    }

    $weeklyData[] = $weeklyCount;
    $weekLabels[] = $weekLabel;
}

// Daily appointment data (last 7 days)
$dailyData = [];
$dayLabels = [];
for ($i = 6; $i >= 0; $i--) {
    $day = date('Y-m-d', strtotime("-$i days"));
    $dayLabel = date('M d', strtotime($day));

    $dailyCount = 0;
    foreach($appointmentTables as $table) {
        $sql = "SELECT COUNT(*) as count FROM {$table} WHERE Date = '$day'";
        $mydb->setQuery($sql);
        $result = $mydb->loadSingleResult();
        $dailyCount += $result->count ?? 0;
    }

    $dailyData[] = $dailyCount;
    $dayLabels[] = $dayLabel;
}
?>

<div class="container-fluid" style="max-width: 1280px; margin: 0 auto;">
    <!-- Dashboard Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2><i class="bi bi-speedometer2"></i> Admin Dashboard</h2>
                </div>
                <div class="text-end">
                    <small class="text-muted">Last updated: <?php echo date('M d, Y h:i A'); ?></small>
                </div>
            </div>
        </div>
    </div>

    <!-- Overview Cards -->
    <div class="row mb-4">
        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-light p-3">
                                <i class="bi bi-people text-muted fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title mb-0">Total Users</h6>
                            <h3 class="mb-0"><?php echo number_format($totalUsers); ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-light p-3">
                                <i class="bi bi-calendar-check text-primary fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title mb-0">Total Appointments</h6>
                            <h3 class="mb-0 text-primary"><?php echo number_format($totalAppointments); ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-light p-3">
                                <i class="bi bi-clock text-warning fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title mb-0">Pending</h6>
                            <h3 class="mb-0 text-warning"><?php echo number_format($pendingAppointments); ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-3 col-md-6 mb-3">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="flex-shrink-0">
                            <div class="rounded-circle bg-light p-3">
                                <i class="bi bi-check-circle text-success fs-4"></i>
                            </div>
                        </div>
                        <div class="flex-grow-1 ms-3">
                            <h6 class="card-title mb-0">Approved</h6>
                            <h3 class="mb-0 text-success"><?php echo number_format($approvedAppointments); ?></h3>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Service Statistics -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="card-title mb-0"><i class="bi bi-bar-chart-fill"></i> Service Statistics</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <!-- Barangay Clearance -->
                        <div class="col-md-6 col-lg-4">
                            <div class="border rounded p-3 h-100">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-file-earmark-check text-muted me-2"></i>
                                    <h6 class="mb-0">Barangay Clearance</h6>
                                </div>
                                <div class="row text-center">
                                    <div class="col-3">
                                        <small class="text-muted">Total</small>
                                        <div class="fw-bold"><?php echo $clearanceStats['total']; ?></div>
                                    </div>
                                    <div class="col-3">
                                        <small class="text-warning">Pending</small>
                                        <div class="fw-bold text-warning"><?php echo $clearanceStats['pending']; ?></div>
                                    </div>
                                    <div class="col-3">
                                        <small class="text-info">Confirmed</small>
                                        <div class="fw-bold text-info"><?php echo $clearanceStats['confirmed']; ?></div>
                                    </div>
                                    <div class="col-3">
                                        <small class="text-success">Approved</small>
                                        <div class="fw-bold text-success"><?php echo $clearanceStats['approved']; ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Cedula -->
                        <div class="col-md-6 col-lg-4">
                            <div class="border rounded p-3 h-100">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-card-text text-muted me-2"></i>
                                    <h6 class="mb-0">Cedula</h6>
                                </div>
                                <div class="row text-center">
                                    <div class="col-3">
                                        <small class="text-muted">Total</small>
                                        <div class="fw-bold"><?php echo $cedulaStats['total']; ?></div>
                                    </div>
                                    <div class="col-3">
                                        <small class="text-warning">Pending</small>
                                        <div class="fw-bold text-warning"><?php echo $cedulaStats['pending']; ?></div>
                                    </div>
                                    <div class="col-3">
                                        <small class="text-info">Confirmed</small>
                                        <div class="fw-bold text-info"><?php echo $cedulaStats['confirmed']; ?></div>
                                    </div>
                                    <div class="col-3">
                                        <small class="text-success">Approved</small>
                                        <div class="fw-bold text-success"><?php echo $cedulaStats['approved']; ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Certificate of Indigency -->
                        <div class="col-md-6 col-lg-4">
                            <div class="border rounded p-3 h-100">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-file-medical text-muted me-2"></i>
                                    <h6 class="mb-0">Certificate of Indigency</h6>
                                </div>
                                <div class="row text-center">
                                    <div class="col-3">
                                        <small class="text-muted">Total</small>
                                        <div class="fw-bold"><?php echo $indigencyStats['total']; ?></div>
                                    </div>
                                    <div class="col-3">
                                        <small class="text-warning">Pending</small>
                                        <div class="fw-bold text-warning"><?php echo $indigencyStats['pending']; ?></div>
                                    </div>
                                    <div class="col-3">
                                        <small class="text-info">Confirmed</small>
                                        <div class="fw-bold text-info"><?php echo $indigencyStats['confirmed']; ?></div>
                                    </div>
                                    <div class="col-3">
                                        <small class="text-success">Approved</small>
                                        <div class="fw-bold text-success"><?php echo $indigencyStats['approved']; ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Business Permit -->
                        <div class="col-md-6 col-lg-4">
                            <div class="border rounded p-3 h-100">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-briefcase text-muted me-2"></i>
                                    <h6 class="mb-0">Business Permit</h6>
                                </div>
                                <div class="row text-center">
                                    <div class="col-3">
                                        <small class="text-muted">Total</small>
                                        <div class="fw-bold"><?php echo $permitStats['total']; ?></div>
                                    </div>
                                    <div class="col-3">
                                        <small class="text-warning">Pending</small>
                                        <div class="fw-bold text-warning"><?php echo $permitStats['pending']; ?></div>
                                    </div>
                                    <div class="col-3">
                                        <small class="text-info">Confirmed</small>
                                        <div class="fw-bold text-info"><?php echo $permitStats['confirmed']; ?></div>
                                    </div>
                                    <div class="col-3">
                                        <small class="text-success">Approved</small>
                                        <div class="fw-bold text-success"><?php echo $permitStats['approved']; ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Court Booking -->
                        <div class="col-md-6 col-lg-4">
                            <div class="border rounded p-3 h-100">
                                <div class="d-flex align-items-center mb-2">
                                    <i class="bi bi-building text-muted me-2"></i>
                                    <h6 class="mb-0">Court Booking</h6>
                                </div>
                                <div class="row text-center">
                                    <div class="col-3">
                                        <small class="text-muted">Total</small>
                                        <div class="fw-bold"><?php echo $courtStats['total']; ?></div>
                                    </div>
                                    <div class="col-3">
                                        <small class="text-warning">Pending</small>
                                        <div class="fw-bold text-warning"><?php echo $courtStats['pending']; ?></div>
                                    </div>
                                    <div class="col-3">
                                        <small class="text-info">Confirmed</small>
                                        <div class="fw-bold text-info"><?php echo $courtStats['confirmed']; ?></div>
                                    </div>
                                    <div class="col-3">
                                        <small class="text-success">Approved</small>
                                        <div class="fw-bold text-success"><?php echo $courtStats['approved']; ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pb-0">
                    <div class="d-flex justify-content-between align-items-center">
                        <h5 class="card-title mb-0"><i class="bi bi-activity"></i> Recent Activity</h5>
                        <a href="index.php?view=consolidatedlist" class="btn btn-outline-primary btn-sm">View All</a>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (!empty($recentActivities)): ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($recentActivities as $activity): ?>
                                <div class="list-group-item border-0 px-0">
                                    <div class="d-flex align-items-center">
                                        <div class="flex-shrink-0">
                                            <?php
                                            $iconClass = 'bi-file-earmark';
                                            $badgeClass = 'bg-secondary';
                                            switch($activity->service_type) {
                                                case 'Clearance':
                                                    $iconClass = 'bi-file-earmark-check';
                                                    break;
                                                case 'Cedula':
                                                    $iconClass = 'bi-card-text';
                                                    break;
                                                case 'Indigency':
                                                    $iconClass = 'bi-file-medical';
                                                    break;
                                                case 'Permit':
                                                    $iconClass = 'bi-briefcase';
                                                    break;
                                                case 'Court':
                                                    $iconClass = 'bi-building';
                                                    break;
                                            }

                                            switch($activity->Status) {
                                                case 'PENDING':
                                                    $badgeClass = 'bg-warning';
                                                    break;
                                                case 'CONFIRMED':
                                                    $badgeClass = 'bg-info';
                                                    break;
                                                case 'APPROVED':
                                                    $badgeClass = 'bg-success';
                                                    break;
                                                case 'CANCELLED':
                                                    $badgeClass = 'bg-danger';
                                                    break;
                                            }
                                            ?>
                                            <div class="rounded-circle bg-light p-2">
                                                <i class="<?php echo $iconClass; ?> text-muted"></i>
                                            </div>
                                        </div>
                                        <div class="flex-grow-1 ms-3">
                                            <div class="d-flex justify-content-between align-items-start">
                                                <div>
                                                    <h6 class="mb-1"><?php echo htmlspecialchars($activity->user_name); ?></h6>
                                                    <p class="mb-0 text-muted">
                                                        Applied for <strong><?php echo $activity->service_type; ?></strong>
                                                    </p>
                                                </div>
                                                <div class="text-end">
                                                    <span class="badge <?php echo $badgeClass; ?> mb-1">
                                                        <?php echo $activity->Status; ?>
                                                    </span>
                                                    <br>
                                                    <small class="text-muted">
                                                        <?php echo date('M d, Y h:i A', strtotime($activity->created_date)); ?>
                                                    </small>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="bi bi-inbox text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-2">No recent activity found.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Monthly Appointment Trends Chart
const appointmentCtx = document.getElementById('appointmentChart').getContext('2d');
const appointmentChart = new Chart(appointmentCtx, {
    type: 'line',
    data: {
        labels: [<?php echo "'" . implode("','", $monthLabels) . "'"; ?>],
        datasets: [{
            label: 'Total Appointments (Monthly)',
            data: [<?php echo implode(',', $monthlyData); ?>],
            borderColor: 'rgb(27, 94, 32)',
            backgroundColor: 'rgba(76, 175, 80, 0.15)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(0,0,0,0.1)'
                }
            },
            x: {
                grid: {
                    color: 'rgba(0,0,0,0.1)'
                }
            }
        }
    }
});

// Weekly Appointment Trends Chart
const weeklyAppointmentCtx = document.getElementById('weeklyAppointmentChart').getContext('2d');
const weeklyAppointmentChart = new Chart(weeklyAppointmentCtx, {
    type: 'line',
    data: {
        labels: [<?php echo "'" . implode("','", $weekLabels) . "'"; ?>],
        datasets: [{
            label: 'Total Appointments (Weekly)',
            data: [<?php echo implode(',', $weeklyData); ?>],
            borderColor: 'rgb(46, 125, 50)',
            backgroundColor: 'rgba(139, 195, 74, 0.15)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(0,0,0,0.1)'
                }
            },
            x: {
                grid: {
                    color: 'rgba(0,0,0,0.1)'
                }
            }
        }
    }
});

// Daily Appointment Trends Chart
const dailyAppointmentCtx = document.getElementById('dailyAppointmentChart').getContext('2d');
const dailyAppointmentChart = new Chart(dailyAppointmentCtx, {
    type: 'line',
    data: {
        labels: [<?php echo "'" . implode("','", $dayLabels) . "'"; ?>],
        datasets: [{
            label: 'Total Appointments (Daily)',
            data: [<?php echo implode(',', $dailyData); ?>],
            borderColor: 'rgb(56, 142, 60)',
            backgroundColor: 'rgba(205, 220, 57, 0.20)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: {
                    color: 'rgba(0,0,0,0.1)'
                }
            },
            x: {
                grid: {
                    color: 'rgba(0,0,0,0.1)'
                }
            }
        }
    }
});

// Service Distribution Chart
const serviceCtx = document.getElementById('serviceChart').getContext('2d');
const serviceChart = new Chart(serviceCtx, {
    type: 'doughnut',
    data: {
        labels: ['Clearance', 'Cedula', 'Indigency', 'Permit', 'Court'],
        datasets: [{
            data: [<?php echo $clearanceStats['total']; ?>, <?php echo $cedulaStats['total']; ?>, <?php echo $indigencyStats['total']; ?>, <?php echo $permitStats['total']; ?>, <?php echo $courtStats['total']; ?>],
            backgroundColor: [
                'rgba(76, 175, 80, 0.85)',   // green
                'rgba(139, 195, 74, 0.85)',  // light green
                'rgba(205, 220, 57, 0.85)',  // lime/yellow-green
                'rgba(255, 235, 59, 0.85)',  // yellow
                'rgba(27, 94, 32, 0.85)'     // dark green
            ],
            borderColor: [
                'rgba(56, 142, 60, 1)',
                'rgba(124, 179, 66, 1)',
                'rgba(175, 180, 43, 1)',
                'rgba(253, 216, 53, 1)',
                'rgba(27, 94, 32, 1)'
            ],
            borderWidth: 2
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom',
                labels: {
                    padding: 20,
                    usePointStyle: true
                }
            }
        }
    }
});

// Conditional chart visibility via dropdown
function setElementVisibility(element, shouldShow) {
    if (!element) return;
    if (shouldShow) {
        element.classList.remove('d-none');
    } else {
        element.classList.add('d-none');
    }
}

function applyChartFilter(value) {
    var monthlyCard = document.getElementById('monthlyChartCard');
    var weeklyCard = document.getElementById('weeklyChartCard');
    var dailyCard = document.getElementById('dailyChartCard');
    var serviceCard = document.getElementById('serviceChartCard');
    var mainCol = document.getElementById('chartsMainCol');
    var sideCol = document.getElementById('chartsSideCol');

    var showMonthly = (value === 'monthly');
    var showWeekly = (value === 'weekly');
    var showDaily = (value === 'daily');
    var showService = true; // Always show service distribution

    setElementVisibility(monthlyCard, showMonthly);
    setElementVisibility(weeklyCard, showWeekly);
    setElementVisibility(dailyCard, showDaily);
    setElementVisibility(serviceCard, showService);

    var anyMainVisible = showMonthly || showWeekly || showDaily;
    setElementVisibility(mainCol, anyMainVisible);
    setElementVisibility(sideCol, true);
}

document.addEventListener('DOMContentLoaded', function () {
    var chartFilterEl = document.getElementById('chartFilter');
    if (chartFilterEl) {
        applyChartFilter(chartFilterEl.value || 'monthly');
        chartFilterEl.addEventListener('change', function (e) {
            applyChartFilter(e.target.value);
        });
    }
});
</script>
