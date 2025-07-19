<?php
require_once("INCLUDE/initialize.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

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

            // Send email notification for successful payment
            require 'PHPMailer/src/Exception.php';
            require 'PHPMailer/src/PHPMailer.php';
            require 'PHPMailer/src/SMTP.php';

            // Get user information from the clearance record
            $sql_user = "SELECT ua.Email, ua.Firstname, ua.Lastname FROM user_account ua
                        INNER JOIN _clearance c ON ua.UserID = c.UserID
                        WHERE c.ID = {$clearance_id}";
            $mydb->setQuery($sql_user);
            $user_info = $mydb->loadSingleResult();

            if ($user_info && $user_info->Email) {
                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'thesiswebsite2024@gmail.com';
                    $mail->Password = 'ylku vutf rqsi jzfy';
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;
                    $mail->setFrom('thesiswebsite2024@gmail.com', 'Barangay Victoria Tayo');
                    $mail->addAddress($user_info->Email);
                    $mail->isHTML(true);
                    $mail->Subject = 'PAYMENT CONFIRMATION: Barangay Clearance';
                    $mail->Body = '<HTML>
                        <body style="font-family: Arial, sans-serif;">
                            <h2 style="color: #28a745;">Payment Successful!</h2>
                            <p>Dear ' . htmlspecialchars($user_info->Firstname . ' ' . $user_info->Lastname) . ',</p>
                            <p>We are pleased to confirm that your payment for the <strong>Barangay Clearance</strong> has been successfully processed.</p>
                            <p><strong>Payment Details:</strong></p>
                            <ul>
                                <li>Service: Barangay Clearance</li>
                                <li>Payment Date: ' . $date . '</li>
                                <li>Reference ID: ' . $clearance_id . '</li>
                            </ul>
                            <p>Your clearance document is now being prepared and will be available for pickup soon. We will notify you when it is ready.</p>
                            <p>Thank you for using our online services!</p>
                            <br>
                            <p>Best regards,<br>Barangay Victoria Tayo</p>
                        </body>
                    </HTML>';
                    $mail->send();
                } catch (Exception $e) {
                    error_log("Failed to send payment confirmation email: " . $mail->ErrorInfo);
                }
            }

            $success_message = "Payment successful! Your clearance request has been processed. A confirmation email has been sent to your registered email address.";
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
