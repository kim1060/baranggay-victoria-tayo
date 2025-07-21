<?php
/*
$servername = "70.39.144.94:3306";
$username = "ramfoo5_roisdbuser";
$password = 'itramfoods@web23';
$database = 'ramfoo5_roisdb';

// Connection
$conn = new mysqli($servername,$username, $password,$database);

// For checking if connection is
// successful or not
if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
        echo "Connected successfully";
        */
?>

<?php
// Maintenance mode check
$maintenance = getenv('MAINTENANCE_MODE');
if ($maintenance === 'true') {
    http_response_code(503);
    echo '<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Site Under Maintenance</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            font-family: "Roboto", Arial, sans-serif;
            color: #222;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }
        .maintenance-container {
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0,0,0,0.12);
            padding: 48px 32px;
            max-width: 400px;
            text-align: center;
        }
        .maintenance-container h1 {
            font-size: 2.2em;
            margin-bottom: 0.5em;
            color: #2563eb;
        }
        .maintenance-container p {
            font-size: 1.1em;
            margin-bottom: 1.5em;
        }
        .maintenance-icon {
            font-size: 3em;
            margin-bottom: 0.5em;
            color: #f59e42;
        }
        @media (max-width: 500px) {
            .maintenance-container {
                padding: 32px 8px;
            }
        }
    </style>
</head>
<body>
    <div class="maintenance-container">
        <div class="maintenance-icon">🔧</div>
        <h1>Site Under Maintenance</h1>
        <p>We are currently performing scheduled maintenance.<br>
        Please check back later.<br><br>
        Thank you for your patience!</p>
    </div>
</body>
</html>';
    exit;
}



require_once("INCLUDE/initialize.php");


$content = 'home.php';
$view = (isset($_GET['view']) && $_GET['view'] != '') ? $_GET['view'] : '';

switch ($view) {

    // ADMIN DASHBOARD
    case 'admin_dashboard':
        $title = "Admin Dashboard";
        $content = 'NAVITEMS/admin_dashboard.php';
    break;

    //USER ACCOUNT
    case 'userlist':
        $title = "User Accounts";
        $content = 'NAVITEMS/USER_ACCOUNT/userlist.php';
    break;
    case 'useradd':
        $title = "New Account";
        $content = 'NAVITEMS/USER_ACCOUNT/useradd.php';
    break;
    case 'useredit':
        $title = "Modify Account";
        $content = 'NAVITEMS/USER_ACCOUNT/useredit.php';
    break;


    //ANNOUNCEMENT
    case 'announcementlist':
        $title = "Announcements";
        $content = 'NAVITEMS/ANNOUNCEMENT/announcementlist.php';
    break;
    case 'announcementadd':
        $title = "Add New";
        $content = 'NAVITEMS/ANNOUNCEMENT/announcementadd.php';
    break;
    case 'announcementedit':
        $title = "Edit";
        $content = 'NAVITEMS/ANNOUNCEMENT/announcementedit.php';
    break;

    //MONTHLY
    case 'monthlydueslist':
        $title = "Monthly Dues";
        $content = 'NAVITEMS/MONTHLYDUES/monthlydueslist.php';
    break;
    case 'monthlyduesadd':
        $title = "Add New";
        $content = 'NAVITEMS/MONTHLYDUES/monthlyduesadd.php';
    break;
    case 'announcementedit':
        $title = "Edit";
        $content = 'NAVITEMS/ANNOUNCEMENT/announcementedit.php';
    break;

    //CLEARANCE
    case '_clearance':
        $title = "Barangay Clearance";
        $content = 'NAVITEMS/_clearance.php';
    break;
    case 'paymentclearance':
        $title = "My Clearance Payment";
        $content = 'NAVITEMS/CLEARANCE/amount.php';
    break;
    case 'myclearancelist':
        $title = "My Barangay Clearance Appointment";
        $content = 'NAVITEMS/CLEARANCE/mylist.php';
    break;
    case 'clearancelist':
        $title = "Barangay Clearance";
        $content = 'NAVITEMS/CLEARANCE/list.php';
    break;
    case 'clearanceview':
        $title = "Residence Details";
        $content = 'NAVITEMS/CLEARANCE/view.php';
    break;


    //CEDULA
    case '_cedula':
        $title = "Cedula";
        $content = 'NAVITEMS/_cedula.php';
    break;
    case 'paymentcedula':
        $title = "My Cedula Payment";
        $content = 'NAVITEMS/CEDULA/amount.php';
    break;
    case 'mycedulalist':
        $title = "My Cedula Appointment";
        $content = 'NAVITEMS/CEDULA/mylist.php';
    break;
    case 'cedulalist':
        $title = "Cedula";
        $content = 'NAVITEMS/CEDULA/list.php';
    break;
    case 'cedulaview':
        $title = "Residence Details";
        $content = 'NAVITEMS/CEDULA/view.php';
    break;

    //COURT
    case '_court':
        $title = "Court";
        $content = 'NAVITEMS/_court.php';
    break;
    case 'paymentcourt':
        $title = "My Court Payment";
        $content = 'NAVITEMS/COURT/amount.php';
    break;
    case 'mycourtlist':
        $title = "My Court Appointment";
        $content = 'NAVITEMS/COURT/mylist.php';
    break;
    case 'courtlist':
        $title = "Court Booking";
        $content = 'NAVITEMS/COURT/list.php';
    break;
    case 'courtview':
        $title = "Residence Details";
        $content = 'NAVITEMS/COURT/view.php';
    break;

    //BUSINESS PERMIT
    case '_permit':
        $title = "Business Permit";
        $content = 'NAVITEMS/_permit.php';
    break;
    case 'paymentpermit':
        $title = "My Business Permit Payment";
        $content = 'NAVITEMS/PERMIT/amount.php';
    break;
    case 'mypermitlist':
        $title = "My Business Permit Appointment";
        $content = 'NAVITEMS/PERMIT/mylist.php';
    break;
    case 'permitlist':
        $title = "Business Permit";
        $content = 'NAVITEMS/PERMIT/list.php';
    break;
    case 'permitview':
        $title = "Residence Details";
        $content = 'NAVITEMS/PERMIT/view.php';
    break;

    //INDIGENCY
    case '_indigency':
        $title = "Certificate of Indigency";
        $content = 'NAVITEMS/_indigency.php';
    break;
    case 'paymentindigency':
        $title = "My Indigency Payment";
        $content = 'NAVITEMS/INDIGENCY/amount.php';
    break;
    case 'myindigencylist':
        $title = "My Certificate of Indigency Appointment";
        $content = 'NAVITEMS/INDIGENCY/mylist.php';
    break;
    case 'indigencylist':
        $title = "Certificate of Indigency";
        $content = 'NAVITEMS/INDIGENCY/list.php';
    break;
    case 'indigencyview':
        $title = "Residence Details";
        $content = 'NAVITEMS/INDIGENCY/view.php';
    break;


    case 'monthlydues':
        $title = "Monthly Dues";
        $content = 'NAVITEMS/_monthlydues.php';
    break;

    case 'announcement':
        $title = "Announcements";
        $content = 'NAVITEMS/_announcement.php';
    break;

    case 'services':
        $title = "Transaction Type";
        $content = 'NAVITEMS/_transactiontype.php';
    break;

    case 'myprofile':
        $title = "My Account";
        $content = 'NAVITEMS/_myprofile.php';
    break;


    case 'myprofiles':
        $title = "My Account";
        $content = 'NAVITEMS/_myprofiles.php';
    break;

    case 'adminchat':
        $title = "Admin Chat";
        $content = 'NAVITEMS/_chat.php';
    break;

    case 'consolidatedlist':
        $title = "Consolidated Report";
        $content = 'NAVITEMS/_consolidatedlist.php';
    break;



    case 'home':
        $title = "Home";
        $content = 'NAVITEMS/_home_improved.php';
    break;

        case 'verification':
        $title = "Verifying Account";
        $content = 'NAVITEMS/_verification.php';
    break;


    default:
    $title = "Home";
    $content    = 'NAVITEMS/_home_improved.php';
    //$content    = 'NAVITEMS/_home.php';
}

require_once("main.php");

?>