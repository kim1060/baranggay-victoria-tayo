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

$cedula_id = intval($_GET['id']);

// Get the cedula record
$sql = "SELECT * FROM _cedula WHERE ID = {$cedula_id}";
$mydb->setQuery($sql);
$result = $mydb->loadSingleResult();

if (!$result) {
    die("Cedula record not found");
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
            // Update the cedula status to PAID
            $date = date('Y-m-d H:i:s');
            $Users = new _cedula();
            $Users->ApprovedDate = $date;
            $Users->Status = 'PAID';
            $Users->update($cedula_id);

            // Send email notification
            try {
                // Get user details
                $user_sql = "SELECT ua.fname, ua.lname, ua.email_add, c.CedulaNumber, c.Age, c.PlaceOfBirth, c.Occupation, c.TIN
                            FROM _cedula c
                            JOIN user_account ua ON c.UserID = ua.user_id
                            WHERE c.ID = ?";
                $user_stmt = $conn->prepare($user_sql);
                $user_stmt->bind_param("i", $cedula_id);
                $user_stmt->execute();
                $user_result = $user_stmt->get_result();

                if ($user_result->num_rows > 0) {
                    $user_data = $user_result->fetch_assoc();

                    $mail = new PHPMailer(true);

                    // SMTP configuration
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'baranggayvictoria.tayo@gmail.com';
                    $mail->Password = 'ijrp lzqo qhms hlcx';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                    $mail->Port = 587;

                    // Email content
                    $mail->setFrom('baranggayvictoria.tayo@gmail.com', 'Barangay Victoria Tayo');
                    $mail->addAddress($user_data['email_add'], $user_data['fname'] . ' ' . $user_data['lname']);

                    $mail->isHTML(true);
                    $mail->Subject = 'Cedula Payment Confirmation - Barangay Victoria Tayo';

                    $emailBody = '
                    <!DOCTYPE html>
                    <html>
                    <head>
                        <style>
                            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
                            .container { max-width: 600px; margin: 0 auto; padding: 20px; }
                            .header { background: #28a745; color: white; padding: 20px; text-align: center; border-radius: 5px 5px 0 0; }
                            .content { background: #f8f9fa; padding: 20px; border: 1px solid #e9ecef; border-radius: 0 0 5px 5px; }
                            .success { color: #28a745; font-weight: bold; }
                            .details { background: white; padding: 15px; margin: 15px 0; border-radius: 5px; border-left: 4px solid #28a745; }
                            .footer { text-align: center; margin-top: 20px; font-size: 12px; color: #6c757d; }
                        </style>
                    </head>
                    <body>
                        <div class="container">
                            <div class="header">
                                <h2>Payment Confirmation</h2>
                            </div>
                            <div class="content">
                                <p>Dear ' . htmlspecialchars($user_data['fname'] . ' ' . $user_data['lname']) . ',</p>

                                <p class="success">✓ Your payment has been successfully processed!</p>

                                <div class="details">
                                    <h3>Cedula Details:</h3>
                                    <p><strong>Cedula Number:</strong> ' . htmlspecialchars($user_data['CedulaNumber']) . '</p>
                                    <p><strong>Age:</strong> ' . htmlspecialchars($user_data['Age']) . '</p>
                                    <p><strong>Place of Birth:</strong> ' . htmlspecialchars($user_data['PlaceOfBirth']) . '</p>
                                    <p><strong>Occupation:</strong> ' . htmlspecialchars($user_data['Occupation']) . '</p>
                                    <p><strong>TIN:</strong> ' . htmlspecialchars($user_data['TIN']) . '</p>
                                    <p><strong>Payment Status:</strong> <span class="success">PAID</span></p>
                                </div>

                                <p>Your cedula request is now being processed. You will be notified once your cedula is ready for collection.</p>

                                <p>If you have any questions, please don\'t hesitate to contact us.</p>

                                <p>Thank you for using our online services!</p>
                            </div>
                            <div class="footer">
                                <p>This is an automated message from Barangay Victoria Tayo Online Services</p>
                            </div>
                        </div>
                    </body>
                    </html>';

                    $mail->Body = $emailBody;
                    $mail->send();
                }
            } catch (Exception $e) {
                // Log error but don't break the payment flow
                error_log("Email notification failed: " . $e->getMessage());
            }

            $status_message = "Payment confirmed and status updated to PAID!";
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
        <p><strong>Cedula ID:</strong> <?php echo $cedula_id; ?></p>
        <p><strong>Current Status:</strong> <?php echo $result->Status; ?></p>

        <div class="status <?php echo ($payment_status === 'paid') ? 'paid' : (($payment_status === 'unpaid') ? 'pending' : 'error'); ?>">
            <?php echo $status_message; ?>
        </div>

        <div>
            <a href="index.php?view=mycedulalist" class="btn btn-primary">Back to Cedula List</a>
            <a href="check_cedula_payment_status.php?id=<?php echo $cedula_id; ?>" class="btn btn-success">Refresh Status</a>
        </div>

        <hr>
        <small>
            <strong>PayMongo Status:</strong> <?php echo $payment_status; ?><br>
            <strong>HTTP Code:</strong> <?php echo $http_code; ?>
        </small>
    </div>
</body>
</html>
