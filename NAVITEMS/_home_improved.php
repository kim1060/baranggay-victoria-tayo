<?php
   require_once("INCLUDE/initialize.php");
if(isset($_SESSION['UserID'])){
$UserID=$_SESSION['UserID'];
}
?>

<style>
/* Custom styles for improved home page */
.hero-section {
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    color: white;
    padding: 4rem 0;
    margin-bottom: 2rem;
}

.stat-card {
    border: none;
    border-radius: 12px;
    transition: all 0.2s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    background: #ffffff;
}

.stat-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(0,0,0,0.08);
}

.stat-icon {
    width: 48px;
    height: 48px;
    border-radius: 12px;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 1.25rem;
}

.service-card {
    border: none;
    border-radius: 16px;
    overflow: hidden;
    transition: all 0.2s ease;
    box-shadow: 0 2px 8px rgba(0,0,0,0.04);
    background: #ffffff;
    height: 100%;
}

.service-card:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 16px rgba(0,0,0,0.08);
}

.service-icon {
    font-size: 2rem;
    margin-bottom: 1rem;
    opacity: 0.7;
}

.quick-stats {
    font-size: 0.85rem;
}

.announcement-card {
    border: none;
    border-radius: 15px;
    box-shadow: 0 3px 10px rgba(0,0,0,0.1);
    margin-bottom: 1.5rem;
    transition: all 0.3s ease;
    overflow: hidden;
}

.announcement-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 8px 20px rgba(0,0,0,0.15);
}

.announcement-image {
    object-fit: cover;
    width: 100%;
    height: 200px;
    border-radius: 10px;
}

.section-title {
    position: relative;
    margin-bottom: 2rem;
}

.section-title::after {
    content: '';
    position: absolute;
    bottom: -10px;
    left: 0;
    width: 50px;
    height: 3px;
    background: linear-gradient(45deg, #667eea, #764ba2);
    border-radius: 2px;
}

.welcome-user {
    background: linear-gradient(45deg, #667eea, #764ba2);
    background-clip: text;
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    font-weight: bold;
}
    background: rgba(255,255,255,0.1);
    transform: translateX(5px);
}

.dropdown-menu {
    border: none;
    border-radius: 12px;
    box-shadow: 0 10px 30px rgba(0,0,0,0.2);
}

.btn-chat {
    transition: all 0.3s ease;
    border-radius: 20px;
}

.btn-chat:hover {
    transform: scale(1.05);
}
</style>

<div class="container-fluid px-0">
    <!-- Hero Section -->
    <?php if(!isset($_SESSION['UserID'])): ?>
    <div class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6" data-aos="fade-right" data-aos-duration="1000">
                    <h1 class="display-4 fw-bold mb-4">Welcome to Barangay Victoria Tayo</h1>
                    <p class="lead mb-4">Your one-stop solution for barangay appointments and services. Schedule your appointments online and track your applications easily.</p>
                    <div class="d-flex gap-3">
                        <a href="login.php" class="btn btn-light btn-lg px-4">Get Started</a>
                        <a href="register.php" class="btn btn-outline-light btn-lg px-4">Register</a>
                    </div>
                </div>
                <div class="col-lg-6" data-aos="fade-left" data-aos-duration="1000">
                    <img src="IMG/baranggay-victoria.png" alt="AppointMate Logo" class="img-fluid" style="max-height: 300px;">
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<div class="container mb-5">
    <?php if(isset($_SESSION['UserID'])): ?>
        <!-- Welcome Message -->
        <div class="row mb-4" data-aos="fade-down" data-aos-duration="800">
            <div class="col-12">
                <div class="text-center">
                    <h2 class="welcome-user">Welcome back, <?php echo $_SESSION['Firstname']; ?>!</h2>
                    <p class="text-muted">Here's an overview of your appointment dashboard</p>
                </div>
            </div>
        </div>

        <?php if($_SESSION['UserType']=="ADMIN"): ?>
            <!-- Admin Quick Stats -->
            <div class="row mb-4" data-aos="fade-up" data-aos-duration="800">
                <div class="col-12">
                    <h4 class="section-title"><i class="bi bi-speedometer2"></i> Quick Overview</h4>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card card h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="stat-icon bg-primary bg-opacity-10 text-primary me-3">
                                <i class="bi bi-people-fill"></i>
                            </div>
                            <div>
                                <h3 class="mb-0">
                                    <?php
                                    $sql = "SELECT COUNT(*) as count FROM user_account WHERE UserType = 'USER'";
                                    $mydb->setQuery($sql);
                                    $result = $mydb->loadSingleResult();
                                    echo $result->count ?? 0;
                                    ?>
                                </h3>
                                <small class="text-muted">Total Users</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card card h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="stat-icon bg-success bg-opacity-10 text-success me-3">
                                <i class="bi bi-calendar-check"></i>
                            </div>
                            <div>
                                <h3 class="mb-0">
                                    <?php
                                    $totalAppointments = 0;
                                    $tables = ['_clearance', '_cedula', '_indigency', '_permit', '_court'];
                                    foreach($tables as $table) {
                                        $sql = "SELECT COUNT(*) as count FROM {$table}";
                                        $mydb->setQuery($sql);
                                        $result = $mydb->loadSingleResult();
                                        $totalAppointments += $result->count ?? 0;
                                    }
                                    echo $totalAppointments;
                                    ?>
                                </h3>
                                <small class="text-muted">Total Appointments</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card card h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="stat-icon bg-warning bg-opacity-10 text-warning me-3">
                                <i class="bi bi-clock"></i>
                            </div>
                            <div>
                                <h3 class="mb-0">
                                    <?php
                                    $pendingCount = 0;
                                    foreach($tables as $table) {
                                        $sql = "SELECT COUNT(*) as count FROM {$table} WHERE Status = 'PENDING'";
                                        $mydb->setQuery($sql);
                                        $result = $mydb->loadSingleResult();
                                        $pendingCount += $result->count ?? 0;
                                    }
                                    echo $pendingCount;
                                    ?>
                                </h3>
                                <small class="text-muted">Pending</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-3">
                    <div class="stat-card card h-100">
                        <div class="card-body d-flex align-items-center">
                            <div class="stat-icon bg-info bg-opacity-10 text-info me-3">
                                <i class="bi bi-graph-up"></i>
                            </div>
                            <div>
                                <div class="d-flex align-items-center">
                                    <a href="index.php?view=admin_dashboard" class="btn btn-sm btn-outline-primary">
                                        <i class="bi bi-speedometer2"></i> View Dashboard
                                    </a>
                                </div>
                                <small class="text-muted">Detailed Analytics</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Admin Service Cards -->
            <div class="row mb-4" data-aos="fade-up" data-aos-duration="1000">
                <div class="col-12">
                    <h4 class="section-title"><i class="bi bi-gear"></i> Service Management</h4>
                </div>
                <?php
                $services = [
                    ['name' => 'Barangay Clearance', 'table' => '_clearance', 'icon' => 'bi-file-earmark-check', 'color' => 'primary', 'link' => 'clearancelist'],
                    ['name' => 'Cedula', 'table' => '_cedula', 'icon' => 'bi-card-text', 'color' => 'success', 'link' => 'cedulalist'],
                    ['name' => 'Certificate of Indigency', 'table' => '_indigency', 'icon' => 'bi-file-medical', 'color' => 'danger', 'link' => 'indigencylist'],
                    ['name' => 'Business Permit', 'table' => '_permit', 'icon' => 'bi-briefcase', 'color' => 'warning', 'link' => 'permitlist'],
                    ['name' => 'Court Booking', 'table' => '_court', 'icon' => 'bi-building', 'color' => 'info', 'link' => 'courtlist']
                ];

                foreach($services as $service):
                    // Get stats for this service
                    $sql = "SELECT COUNT(*) as total FROM {$service['table']}";
                    $mydb->setQuery($sql);
                    $result = $mydb->loadSingleResult();
                    $total = $result->total ?? 0;

                    $sql = "SELECT COUNT(*) as pending FROM {$service['table']} WHERE Status = 'PENDING'";
                    $mydb->setQuery($sql);
                    $result = $mydb->loadSingleResult();
                    $pending = $result->pending ?? 0;

                    $sql = "SELECT COUNT(*) as approved FROM {$service['table']} WHERE Status = 'APPROVED'";
                    $mydb->setQuery($sql);
                    $result = $mydb->loadSingleResult();
                    $approved = $result->approved ?? 0;
                ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-card card text-center">
                        <div class="card-body">
                            <div class="service-icon text-muted">
                                <i class="<?php echo $service['icon']; ?>"></i>
                            </div>
                            <h5 class="card-title"><?php echo $service['name']; ?></h5>
                            <div class="row quick-stats text-center mb-3">
                                <div class="col-4">
                                    <div class="fw-bold text-primary"><?php echo $total; ?></div>
                                    <small class="text-muted">Total</small>
                                </div>
                                <div class="col-4">
                                    <div class="fw-bold text-warning"><?php echo $pending; ?></div>
                                    <small class="text-muted">Pending</small>
                                </div>
                                <div class="col-4">
                                    <div class="fw-bold text-success"><?php echo $approved; ?></div>
                                    <small class="text-muted">Approved</small>
                                </div>
                            </div>
                            <a href="index.php?view=<?php echo $service['link']; ?>" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-arrow-right"></i> Manage
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

        <?php else: // USER VIEW ?>

            <!-- User Service Cards -->
            <div class="row mb-4" data-aos="fade-up" data-aos-duration="1000">
                <div class="col-12">
                    <h4 class="section-title"><i class="bi bi-calendar-check"></i> My Appointments</h4>
                </div>
                <?php
                $userServices = [
                    ['name' => 'Barangay Clearance', 'table' => '_clearance', 'icon' => 'bi-file-earmark-check', 'color' => 'primary', 'link' => 'myclearancelist'],
                    ['name' => 'Cedula', 'table' => '_cedula', 'icon' => 'bi-card-text', 'color' => 'success', 'link' => 'mycedulalist'],
                    ['name' => 'Certificate of Indigency', 'table' => '_indigency', 'icon' => 'bi-file-medical', 'color' => 'danger', 'link' => 'myindigencylist'],
                    ['name' => 'Business Permit', 'table' => '_permit', 'icon' => 'bi-briefcase', 'color' => 'warning', 'link' => 'mypermitlist'],
                    ['name' => 'Court Booking', 'table' => '_court', 'icon' => 'bi-building', 'color' => 'info', 'link' => 'mycourtlist']
                ];

                foreach($userServices as $service):
                    // Get user-specific stats
                    $sql = "SELECT COUNT(*) as total FROM {$service['table']} WHERE UserID = '$UserID'";
                    $mydb->setQuery($sql);
                    $result = $mydb->loadSingleResult();
                    $total = $result->total ?? 0;

                    $sql = "SELECT COUNT(*) as pending FROM {$service['table']} WHERE UserID = '$UserID' AND Status = 'PENDING'";
                    $mydb->setQuery($sql);
                    $result = $mydb->loadSingleResult();
                    $pending = $result->pending ?? 0;

                    $sql = "SELECT COUNT(*) as approved FROM {$service['table']} WHERE UserID = '$UserID' AND Status = 'APPROVED'";
                    $mydb->setQuery($sql);
                    $result = $mydb->loadSingleResult();
                    $approved = $result->approved ?? 0;
                ?>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="service-card card text-center">
                        <div class="card-body">
                            <div class="service-icon text-muted">
                                <i class="<?php echo $service['icon']; ?>"></i>
                            </div>
                            <h5 class="card-title"><?php echo $service['name']; ?></h5>
                            <div class="row quick-stats text-center mb-3">
                                <div class="col-4">
                                    <div class="fw-bold text-primary"><?php echo $total; ?></div>
                                    <small class="text-muted">Total</small>
                                </div>
                                <div class="col-4">
                                    <div class="fw-bold text-warning"><?php echo $pending; ?></div>
                                    <small class="text-muted">Pending</small>
                                </div>
                                <div class="col-4">
                                    <div class="fw-bold text-success"><?php echo $approved; ?></div>
                                    <small class="text-muted">Approved</small>
                                </div>
                            </div>
                            <a href="index.php?view=<?php echo $service['link']; ?>" class="btn btn-outline-primary btn-sm">
                                <i class="bi bi-eye"></i> View Status
                            </a>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>

        <?php endif; ?>
    <?php endif; ?>

    <!-- Announcements Section -->
    <div class="row" data-aos="fade-up" data-aos-duration="1200">
        <div class="col-12">
            <h4 class="section-title"><i class="bi bi-megaphone"></i> Latest Announcements</h4>
        </div>
        <div class="col-12">
            <?php
            $db = new Database();
            $qry = mysqli_query($db->conn, "SELECT *,date_format(DateCreated, '%M %e, %Y at %h:%i %p') as DateCreateds from announcement ORDER BY DateCreated DESC LIMIT 5");
            if(mysqli_num_rows($qry) > 0):
                while ($row = $qry->fetch_assoc()) :
                    $Filename = $row['Filename'];
            ?>
            <div class="announcement-card card">
                <div class="row g-0">
                    <div class="col-md-4">
                        <div class="p-3">
                            <img src="./NEWS_IMAGE/<?php echo $Filename ?>"
                                 class="announcement-image"
                                 alt="<?php echo htmlspecialchars($row['Title']); ?>">
                        </div>
                    </div>
                    <div class="col-md-8">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <span class="badge bg-primary rounded-pill">Announcement</span>
                                <small class="text-muted">
                                    <i class="bi bi-person"></i> <?php echo htmlspecialchars($row['CreatedBy']); ?>
                                </small>
                            </div>
                            <h5 class="card-title"><?php echo htmlspecialchars($row['Title']); ?></h5>
                            <p class="card-text"><?php echo nl2br(htmlspecialchars($row['Details'])); ?></p>
                            <div class="card-footer bg-transparent border-0 px-0 pt-2">
                                <small class="text-muted">
                                    <i class="bi bi-calendar3"></i> Published <?php echo $row['DateCreateds']; ?>
                                </small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                endwhile;
            else:
            ?>
            <div class="text-center py-5">
                <i class="bi bi-megaphone text-muted" style="font-size: 3rem;"></i>
                <h5 class="text-muted mt-3">No announcements yet</h5>
                <p class="text-muted">Check back later for updates and important information.</p>
            </div>
            <?php endif; ?>
        </div>
    </div>

    <?php if(!isset($_SESSION['UserID'])): ?>
    <!-- Services Info for Non-logged Users -->
    <div class="row mt-5" data-aos="fade-up" data-aos-duration="1000">
        <div class="col-12">
            <h4 class="section-title"><i class="bi bi-list-check"></i> Our Services</h4>
        </div>
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="service-card card text-center">
                <div class="card-body">
                    <div class="service-icon text-muted">
                        <i class="bi-file-earmark-check"></i>
                    </div>
                    <h5 class="card-title">Barangay Clearance</h5>
                    <p class="card-text">Get your barangay clearance certificate quickly and efficiently.</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="service-card card text-center">
                <div class="card-body">
                    <div class="service-icon text-muted">
                        <i class="bi-card-text"></i>
                    </div>
                    <h5 class="card-title">Cedula</h5>
                    <p class="card-text">Apply for your community tax certificate (cedula) online.</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="service-card card text-center">
                <div class="card-body">
                    <div class="service-icon text-muted">
                        <i class="bi-file-medical"></i>
                    </div>
                    <h5 class="card-title">Certificate of Indigency</h5>
                    <p class="card-text">Apply for indigency certificate for various purposes.</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="service-card card text-center">
                <div class="card-body">
                    <div class="service-icon text-muted">
                        <i class="bi-briefcase"></i>
                    </div>
                    <h5 class="card-title">Business Permit</h5>
                    <p class="card-text">Get your business permit and start your entrepreneurial journey.</p>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4 mb-4">
            <div class="service-card card text-center">
                <div class="card-body">
                    <div class="service-icon text-muted">
                        <i class="bi-building"></i>
                    </div>
                    <h5 class="card-title">Court Booking</h5>
                    <p class="card-text">Book court facilities for events and hearings.</p>
                </div>
            </div>
        </div>
    </div>
    <?php endif; ?>
</div>

<script>
// Initialize AOS (Animate On Scroll)
document.addEventListener('DOMContentLoaded', function() {
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });
    }
});
</script>
