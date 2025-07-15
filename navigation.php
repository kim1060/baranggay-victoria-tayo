<nav class="navbar navbar-dark fixed-top navbar-custom">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasDarkNavbar"
            aria-controls="offcanvasDarkNavbarLabel">
            <span class="navbar-toggler-icon fw-bold "></span>
        </button>
        <div data-aos="flip-down" data-aos-duration="2500">
            <a class="navbar-brand fw-bold text-center" id="ramnavtitle" href="index.php?view=home">
                <?php if(isset($_SESSION['UserID']))
                    {
                    ?>
                Welcome <?php echo $_SESSION['Firstname']?> !
                <?php if($_SESSION['UserType']=='ADMIN')
                    {
                    ?>


                <a href="http://localhost/appointmate/chat/chatuser.php"
                    class="btn btn-sm btn-secondary position-relative" target="_blank">
                    <span class="bi-envelope-exclamation"></span>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                        id="noti_number_admin">
                        <span class="visually-hidden">unread messages</span>
                    </span>
                </a>

                <!-- <a class="nav-link active" aria-current="page" target="_blank"
                        href="http://localhost/appointmate/chat/chatuser.php"><span class="bi-messenger"></span>
                        Chat with User</a> -->
                <?php
                    } else {
                    ?>
                <a href="http://localhost/appointmate/chat/chatadmin.php"
                    class="btn btn-sm btn-secondary position-relative" target="_blank">
                    <span class="bi-envelope-exclamation"></span>
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                        id="noti_number_user">
                        <span class="visually-hidden">unread messages</span>
                    </span>
                </a>
                <!-- <a class="nav-link active" aria-current="page" target="_blank"
                        href="http://localhost/appointmate/chat/chatadmin.php"><span class="bi-messenger"></span>
                        Chat with Admin</a> -->
                <?php
                    } 
                    ?>


                <?php
                    } else {
                    ?>
                APPMATE
                <?php
                    } 
                    ?>
            </a>
        </div>





        <div class="offcanvas offcanvas-start navbar-custom text-white" data-bs-scroll="true" data-bs-backdrop="false"
            style="width:295px;" tabindex="-1" id="offcanvasDarkNavbar" aria-labelledby="offcanvasDarkNavbarLabel">
            <div class="offcanvas-header">
                <h5 class="offcanvas-title fw-bold" id="offcanvasDarkNavbarLabel">
                    <?php if(isset($_SESSION['UserID']))
                    {
                    ?>
                    Welcome <?php echo $_SESSION['Firstname']?> !
                    <?php
                    } else {
                    ?>
                    APPMATE
                    <?php
                    } 
                    ?>
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php?view=home"><span
                                class="bi-house"></span>
                            Home</a>
                    </li>
                    <!-- <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php?view=monthlydues"><span
                                class="bi-cash-stack"></span>
                            Monthly Dues</a>
                    </li> -->
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php?view=announcement"><span
                                class="bi-megaphone"></span>
                            Announcement</a>
                    </li>
                    <?php if(isset($_SESSION['UserID']))
                    {
                    ?>
                    <?php if($_SESSION['UserType']=='USER')
                    {
                    ?>
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php?view=services"><span
                                class="bi-list-check"></span>
                            Services</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <span class="bi-info-square"></span> My Application Status
                        </a>
                        <ul class="dropdown-menu dropdown-menu-light">
                            <li><a class="dropdown-item" href="index.php?view=myclearancelist">Barangay Clearance</a>
                            </li>
                            <li><a class="dropdown-item" href="index.php?view=mycedulalist">Cedula</a></li>
                            <li><a class="dropdown-item" href="index.php?view=myindigencylist">Certificate Of
                                    Indigency</a>
                            </li>
                            <li><a class="dropdown-item" href="index.php?view=mypermitlist">Business Permit</a>
                            </li>
                            <li><a class="dropdown-item" href="index.php?view=mycourtlist">Court Booking</a>
                            </li>


                        </ul>
                    </li>
                    <?php
                    }
                    ?>
                    <!-- <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php?view=downloadables"><span
                                class="bi-cloud-download"></span>
                            Downloadable PDF Forms</a>
                    </li> -->
                    <?php if($_SESSION['UserType']=='ADMIN')
                    {
                    ?>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle active" href="#" role="button" data-bs-toggle="dropdown"
                            aria-expanded="false">
                            <span class="bi-gear"></span> Administrator Settings
                        </a>
                        <ul class="dropdown-menu dropdown-menu-light">
                            <li><a class="dropdown-item" href="index.php?view=clearancelist">Barangay Clearance</a>
                            </li>
                            <li><a class="dropdown-item" href="index.php?view=cedulalist">Cedula</a></li>
                            <li><a class="dropdown-item" href="index.php?view=indigencylist">Certificate Of
                                    Indigency</a>
                            </li>
                            <li><a class="dropdown-item" href="index.php?view=permitlist">Business Permit</a>
                            </li>
                            <li><a class="dropdown-item" href="index.php?view=courtlist">Court Booking</a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <!-- <li><a class="dropdown-item" href="index.php?view=monthlydueslist">Monthly Dues</a></li> -->
                            <li><a class="dropdown-item" href="index.php?view=announcementlist">Announcements</a></li>

                        </ul>
                    </li>
                    <?php
                    }
                    ?>
                    <!-- <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="index.php?view=userlist"><span
                                class="bi-person-lock"></span>
                            User Account</a>
                    </li> -->
                    <?php
                    }
                    ?>
                    <!-- <li class="nav-item">
                        <a class="nav-link active" href="index.php?view=aboutus"><span
                                class="bi-question-octagon"></span>
                            About Us</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="index.php?view=products"><span class="bi-box"></span>
                            Products</a>
                    </li> -->

                </ul>
                <hr>
                <?php if(!isset($_SESSION['UserID']))
                    {
                    ?>
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="login.php"><span
                                class="bi-box-arrow-in-right"></span>
                            Sign In</a>
                    </li>
                </ul>
                <?php
                    } else {
                    ?>
                <ul class="navbar-nav justify-content-end flex-grow-1 pe-3">
                    <li class="nav-item">




                        <?php 
                            if($_SESSION['IsVerified']==1)
                            {
                        ?>
                        <a class="nav-link active" aria-current="page" href="index.php?view=myprofile"><span
                                class="bi-person-lines-fill"></span>
                            My Account</a>
                        <?php 
                            }
                            else
                            {
                        ?>

                        <a class="nav-link active" aria-current="page" href="index.php?view=myprofiles"><span
                                class="bi-person-lines-fill"></span>
                            My Account</a>
                        <?php 
                            }
                        ?>

                        <a class="nav-link active" aria-current="page" href="logout.php"><span
                                class="bi-box-arrow-in-left"></span>
                            Sign Out</a>
                    </li>
                </ul>
                <?php
                    } 
                    ?>

            </div>
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