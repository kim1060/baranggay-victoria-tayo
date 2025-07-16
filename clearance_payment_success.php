<?php
require_once("include/initialize.php");

// Payment success handler for clearance
if (isset($_GET['id'])) {
    $clearance_id = intval($_GET['id']);

    // Verify the clearance record exists and is in CONFIRMED status
    $sql = "SELECT * FROM _clearance WHERE ID = {$clearance_id}";
    $mydb->setQuery($sql);
    $result = $mydb->loadSingleResult();

    if ($result) {
        // Check if payment is already processed
        if ($result->Status == 'PAID') {
            $success_message = "Payment already processed for this clearance request.";
        } elseif ($result->Status == 'CONFIRMED') {
            // Update the status to PAID
            $date = date('Y-m-d H:i:s');
            $Users = new _clearance();
            $Users->ApprovedDate = $date;
            $Users->Status = 'PAID';
            $Users->update($clearance_id);

            $success_message = "Payment successful! Your clearance request has been processed.";
        } else {
            $success_message = "Clearance request status: " . $result->Status . ". Cannot process payment.";
        }
    } else {
        $success_message = "Clearance record not found.";
    }
} else {
    $success_message = "Invalid payment confirmation - missing ID.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Success</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@400;500&display=swap');

        * {
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-image: linear-gradient(to right, rgb(63, 80, 156) 0%, rgb(130, 130, 148) 100%);
        }

        .container {
            padding: 40px;
            border-radius: 10px;
            text-align: center;
            box-shadow: rgba(100, 100, 111, 0.2) 0px 7px 29px 0px;
            background-color: #fff;
            max-width: 500px;
        }

        h2 {
            font-size: 28px;
            margin-bottom: 20px;
            color: #16445e;
        }

        .success-icon {
            font-size: 60px;
            color: #28a745;
            margin-bottom: 20px;
        }

        p {
            font-size: 16px;
            margin-bottom: 30px;
            color: #666;
        }

        .btn {
            display: inline-block;
            padding: 12px 24px;
            background-color: #16445e;
            color: white;
            text-decoration: none;
            border-radius: 5px;
            font-size: 16px;
            transition: background-color 0.3s;
        }

        .btn:hover {
            background-color: #0d2d3e;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="success-icon">✅</div>
        <h2>Payment Status</h2>
        <p><?php echo htmlspecialchars($success_message); ?></p>
        <a href="index.php?view=myclearancelist" class="btn">View My Clearance List</a>
    </div>
</body>
</html>
