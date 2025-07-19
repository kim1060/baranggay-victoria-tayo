<?php
require_once("INCLUDE/initialize.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// PayMongo Secret Key
$secretKey = "sk_test_gzphsV2CD5uGTPHurg9rETyh";

// Check if ID is provided
if (!isset($_GET['id'])) {
    die("Payment ID required");
}

$indigency_id = intval($_GET['id']);

// Get the indigency record
$sql = "SELECT * FROM _indigency WHERE ID = {$indigency_id}";
$mydb->setQuery($sql);
$result = $mydb->loadSingleResult();

if (!$result) {
    die("Indigency record not found");
}

// Extract payment link ID from the PaymentReference
$payment_link_url = $result->PaymentReference;
$payment_link_id = basename($payment_link_url);

// Check payment status with PayMongo API
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.paymongo.com/v1/links/" . $payment_link_id);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Basic " . base64_encode($secretKey . ":")
]);

$api_result = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

$payment_status = "unknown";
$status_message = "Unable to check payment status";

if ($http_code == 200) {
    $api_response = json_decode($api_result, true);

    if (isset($api_response['data']['attributes']['status'])) {
        $payment_status = $api_response['data']['attributes']['status'];

        if ($payment_status === 'paid' && $result->Status !== 'PAID') {
            // Update the indigency status to PAID
            $date = date('Y-m-d H:i:s');
            $Users = new _indigency();
            $Users->ApprovedDate = $date;
            $Users->Status = 'PAID';
            $Users->update($indigency_id);

            // Send email notification for successful payment
            require 'PHPMailer/src/Exception.php';
            require 'PHPMailer/src/PHPMailer.php';
            require 'PHPMailer/src/SMTP.php';

            // Get user information from the indigency record
            $sql_user = "SELECT ua.Email, ua.Firstname, ua.Lastname FROM user_account ua
                        INNER JOIN _indigency i ON ua.UserID = i.UserID
                        WHERE i.ID = {$indigency_id}";
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
                    $mail->Subject = 'PAYMENT CONFIRMATION: Certificate of Indigency';
                    $mail->Body = '<HTML>
                        <body style="font-family: Arial, sans-serif;">
                            <h2 style="color: #28a745;">Payment Successful!</h2>
                            <p>Dear ' . htmlspecialchars($user_info->Firstname . ' ' . $user_info->Lastname) . ',</p>
                            <p>We are pleased to confirm that your payment for the <strong>Certificate of Indigency</strong> has been successfully processed.</p>
                            <p><strong>Payment Details:</strong></p>
                            <ul>
                                <li>Service: Certificate of Indigency</li>
                                <li>Payment Date: ' . $date . '</li>
                                <li>Reference ID: ' . $indigency_id . '</li>
                                <li>Amount: ₱100.00</li>
                            </ul>
                            <p>Your certificate is now being prepared and will be available for pickup soon. We will notify you when it is ready.</p>
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

            $status_message = "Payment confirmed and status updated to PAID! A confirmation email has been sent to your registered email address.";
        } elseif ($payment_status === 'paid') {
            $status_message = "Payment already confirmed and processed.";
        } elseif ($payment_status === 'unpaid') {
            $status_message = "Payment is still pending.";
        } else {
            $status_message = "Payment status: " . $payment_status;
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Status Check</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 50px auto;
            padding: 20px;
            background: #f5f5f5;
        }
        .container {
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        .status {
            padding: 15px;
            margin: 20px 0;
            border-radius: 5px;
            font-weight: bold;
        }
        .paid { background: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .pending { background: #fff3cd; color: #856404; border: 1px solid #ffeaa7; }
        .error { background: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .btn {
            display: inline-block;
            padding: 10px 20px;
            margin: 10px;
            text-decoration: none;
            border-radius: 5px;
            color: white;
        }
        .btn-success { background: #28a745; }
        .btn-primary { background: #007bff; }
    </style>
</head>
<body>
    <div class="container">
        <h2>Payment Status Check</h2>
        <p><strong>Certificate of Indigency ID:</strong> <?php echo $indigency_id; ?></p>
        <p><strong>Current Status:</strong> <?php echo $result->Status; ?></p>

        <div class="status <?php echo ($payment_status === 'paid') ? 'paid' : (($payment_status === 'unpaid') ? 'pending' : 'error'); ?>">
            <?php echo $status_message; ?>
        </div>

        <div>
            <a href="index.php?view=myindigencylist" class="btn btn-primary">Back to Indigency List</a>
            <a href="check_indigency_payment_status.php?id=<?php echo $indigency_id; ?>" class="btn btn-success">Refresh Status</a>
        </div>

        <hr>
        <small>
            <strong>PayMongo Status:</strong> <?php echo $payment_status; ?><br>
            <strong>HTTP Code:</strong> <?php echo $http_code; ?>
        </small>
    </div>
</body>
</html>
