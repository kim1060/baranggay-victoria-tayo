<nav class="navbar navbar-expand-lg navbar-light fixed-top navbar-custom">
    <div class="container-fluid">
        <!-- Brand -->
        <div data-aos="flip-down" data-aos-duration="2500">
            <a class="navbar-brand fw-bold" id="ramnavtitle" href="index.php?view=home">
                <i class="bi bi-grid-3x3-gap me-2"></i>
                <?php if(isset($_SESSION['UserID'])): ?>
                    <span class="d-none d-md-inline">Welcome <?php echo $_SESSION['Firstname']; ?>!</span>
                    <span class="d-md-none">BrgyVictoriaTayo</span>
                <?php else: ?>
                    BrgyVictoriaTayo
                <?php endif; ?>
            </a>
        </div>

        <!-- Chat Notifications -->
        <!-- <?php if(isset($_SESSION['UserID'])): ?>
            <div class="d-flex align-items-center me-3">
                <?php if($_SESSION['UserType']=='ADMIN'): ?>
                    <a href="http://localhost/appointmate/chat/chatuser.php"
                        class="btn btn-outline-secondary btn-chat position-relative me-2" target="_blank">
                        <i class="bi bi-chat-dots"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                            id="noti_number_admin">
                            <span class="visually-hidden">unread messages</span>
                        </span>
                    </a>
                <?php else: ?>
                    <a href="http://localhost/appointmate/chat/chatadmin.php"
                        class="btn btn-outline-secondary btn-chat position-relative me-2" target="_blank">
                        <i class="bi bi-chat-dots"></i>
                        <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                            id="noti_number_user">
                            <span class="visually-hidden">unread messages</span>
                        </span>
                    </a>
                <?php endif; ?>
            </div>
        <?php endif; ?> -->

        <!-- Mobile Toggle Button -->
        <button class="navbar-toggler border-0 rounded-3" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <i class="bi bi-list fs-4"></i>
        </button>

        <!-- Desktop Navigation -->
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <!-- Home -->
                <li class="nav-item">
                    <a class="nav-link" href="index.php?view=home">
                        <i class="bi bi-house me-1"></i>
                        <span>Home</span>
                    </a>
                </li>

                <!-- Announcements -->
                <li class="nav-item">
                    <a class="nav-link" href="index.php?view=announcement">
                        <i class="bi bi-megaphone me-1"></i>
                        <span>Announcements</span>
                    </a>
                </li>

                <?php if(isset($_SESSION['UserID'])): ?>

                    <?php if($_SESSION['UserType']=='USER'): ?>
                        <!-- Services for Users -->
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?view=services">
                                <i class="bi bi-list-check me-1"></i>
                                <span>Services</span>
                            </a>
                        </li>

                        <!-- My Applications Dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-file-earmark-text me-1"></i>
                                <span>My Applications</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="index.php?view=myclearancelist">
                                    <i class="bi bi-file-earmark-check me-2"></i>Barangay Clearance</a></li>
                                <li><a class="dropdown-item" href="index.php?view=mycedulalist">
                                    <i class="bi bi-card-text me-2"></i>Cedula</a></li>
                                <li><a class="dropdown-item" href="index.php?view=myindigencylist">
                                    <i class="bi bi-file-medical me-2"></i>Certificate of Indigency</a></li>
                                <li><a class="dropdown-item" href="index.php?view=mypermitlist">
                                    <i class="bi bi-briefcase me-2"></i>Business Permit</a></li>
                                <li><a class="dropdown-item" href="index.php?view=mycourtlist">
                                    <i class="bi bi-building me-2"></i>Court Booking</a></li>
                            </ul>
                        </li>

                    <?php elseif($_SESSION['UserType']=='ADMIN'): ?>
                        <!-- Admin Dashboard -->
                        <li class="nav-item">
                            <a class="nav-link" href="index.php?view=admin_dashboard">
                                <i class="bi bi-speedometer2 me-1"></i>
                                <span>Dashboard</span>
                            </a>
                        </li>

                        <!-- Admin Settings Dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                                <i class="bi bi-gear me-1"></i>
                                <span>Admin Panel</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><h6 class="dropdown-header">Services Management</h6></li>
                                <li><a class="dropdown-item" href="index.php?view=clearancelist">
                                    <i class="bi bi-file-earmark-check me-2"></i>Barangay Clearance</a></li>
                                <li><a class="dropdown-item" href="index.php?view=cedulalist">
                                    <i class="bi bi-card-text me-2"></i>Cedula</a></li>
                                <li><a class="dropdown-item" href="index.php?view=indigencylist">
                                    <i class="bi bi-file-medical me-2"></i>Certificate of Indigency</a></li>
                                <li><a class="dropdown-item" href="index.php?view=permitlist">
                                    <i class="bi bi-briefcase me-2"></i>Business Permit</a></li>
                                <li><a class="dropdown-item" href="index.php?view=courtlist">
                                    <i class="bi bi-building me-2"></i>Court Booking</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><h6 class="dropdown-header">System Management</h6></li>
                                <li><a class="dropdown-item" href="index.php?view=announcementlist">
                                    <i class="bi bi-megaphone me-2"></i>Announcements</a></li>
                                <li><a class="dropdown-item" href="index.php?view=consolidatedlist">
                                    <i class="bi bi-graph-up me-2"></i>Reports</a></li>
                            </ul>
                        </li>
                    <?php endif; ?>

                    <!-- User Account Dropdown -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
                            <i class="bi bi-person-circle me-1"></i>
                            <span>Account</span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="<?php echo $_SESSION['IsVerified']==1 ? 'index.php?view=myprofile' : 'index.php?view=myprofiles'; ?>">
                                    <i class="bi bi-person-lines-fill me-2"></i>My Profile
                                </a>
                            </li>
                            <li><hr class="dropdown-divider"></li>
                            <li>
                                <a class="dropdown-item text-danger" href="logout.php">
                                    <i class="bi bi-box-arrow-right me-2"></i>Sign Out
                                </a>
                            </li>
                        </ul>
                    </li>

                <?php else: ?>
                    <!-- Sign In for Guests -->
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-secondary ms-2" href="login.php">
                            <i class="bi bi-box-arrow-in-right me-1"></i>
                            <span>Sign In</span>
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<script type="text/javascript">
function loadDoc() {
    setInterval(function() {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("noti_number_admin").innerHTML = this.responseText;
            }
        };
        xhttp.open("GET", "count_admin.php", true);
        xhttp.send();
    }, 1000);


    setInterval(function() {
        var xhttp1 = new XMLHttpRequest();
        xhttp1.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("noti_number_user").innerHTML = this.responseText;
            }
        };
        xhttp1.open("GET", "count_user.php", true);
        xhttp1.send();
    }, 1000);
}
loadDoc();
</script>