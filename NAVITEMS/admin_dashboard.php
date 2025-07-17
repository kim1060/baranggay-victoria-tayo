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

    <!-- Charts Section -->
    <div class="row mb-4">
        <div class="col-lg-8">
            <div class="card border-0 shadow-sm">
                <div class="card-header bg-white border-0 pb-0">
                    <h5 class="card-title mb-0"><i class="bi bi-graph-up"></i> Appointment Trends</h5>
                </div>
                <div class="card-body">
                    <canvas id="appointmentChart" height="100"></canvas>
                </div>
            </div>
        </div>
        <div class="col-lg-4">
            <div class="card border-0 shadow-sm">
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
    <div class="row mb-4">
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
?>

<div class="container-fluid">
    <!-- Dashboard Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <h2><i class="bi bi-speedometer2"></i> Admin Dashboard</h2>
                    <p class="text-muted">Welcome back! Here's what's happening with your appointment system.</p>
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
// Appointment Trends Chart
const appointmentCtx = document.getElementById('appointmentChart').getContext('2d');
const appointmentChart = new Chart(appointmentCtx, {
    type: 'line',
    data: {
        labels: [<?php echo "'" . implode("','", $monthLabels) . "'"; ?>],
        datasets: [{
            label: 'Total Appointments',
            data: [<?php echo implode(',', $monthlyData); ?>],
            borderColor: 'rgb(13, 110, 253)',
            backgroundColor: 'rgba(13, 110, 253, 0.1)',
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
                'rgba(54, 162, 235, 0.8)',
                'rgba(75, 192, 192, 0.8)',
                'rgba(255, 99, 132, 0.8)',
                'rgba(255, 206, 86, 0.8)',
                'rgba(153, 102, 255, 0.8)'
            ],
            borderColor: [
                'rgba(54, 162, 235, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(255, 99, 132, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(153, 102, 255, 1)'
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

// Auto-refresh dashboard every 5 minutes
setTimeout(function() {
    location.reload();
}, 300000);
</script>
