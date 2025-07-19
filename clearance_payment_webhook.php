<?php
require_once("INCLUDE/initialize.php");

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// PayMongo webhook handler for clearance payments
$secretKey = "sk_test_gzphsV2CD5uGTPHurg9rETyh";

// Get the raw POST data
$payload = file_get_contents('php://input');
$event = json_decode($payload, true);

// Verify the webhook (optional but recommended)
$headers = getallheaders();
$signature = isset($headers['Paymongo-Signature']) ? $headers['Paymongo-Signature'] : '';

// Process the webhook event
if ($event && isset($event['data']['type'])) {
    $eventType = $event['data']['type'];
    $eventData = $event['data']['attributes'];

    // Handle successful payment
    if ($eventType === 'link.payment.paid') {
        // Extract payment information
        $paymentLinkId = $eventData['payment_link_id'] ?? null;
        $paymentAmount = $eventData['amount'] ?? 0;
        $paymentStatus = $eventData['status'] ?? '';

        if ($paymentStatus === 'paid' && $paymentLinkId) {
            // Find the clearance record with this payment link
            $sql = "SELECT ID FROM _clearance WHERE PaymentReference LIKE '%{$paymentLinkId}%' AND Status = 'CONFIRMED'";
            $mydb->setQuery($sql);
            $result = $mydb->loadResult();

            if ($result && isset($result->ID)) {
                // Update the clearance status to PAID
                $date = date('Y-m-d H:i:s');
                $Users = new _clearance();
                $Users->ApprovedDate = $date;
                $Users->Status = 'PAID';
                $Users->update($result->ID);

                // Send email notification for successful payment
                require 'PHPMailer/src/Exception.php';
                require 'PHPMailer/src/PHPMailer.php';
                require 'PHPMailer/src/SMTP.php';

                // Get user information from the clearance record
                $sql_user = "SELECT ua.Email, ua.Firstname, ua.Lastname FROM user_account ua
                            INNER JOIN _clearance c ON ua.UserID = c.UserID
                            WHERE c.ID = {$result->ID}";
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
                                    <li>Reference ID: ' . $result->ID . '</li>
                                    <li>Amount: ₱100.00</li>
                                </ul>
                                <p>Your clearance document is now being prepared and will be available for pickup soon. We will notify you when it is ready.</p>
                                <p>Thank you for using our online services!</p>
                                <br>
                                <p>Best regards,<br>Barangay Victoria Tayo</p>
                            </body>
                        </HTML>';
                        $mail->send();
                        error_log("Payment confirmation email sent for clearance ID: " . $result->ID);
                    } catch (Exception $e) {
                        error_log("Failed to send payment confirmation email: " . $mail->ErrorInfo);
                    }
                }

                // Log successful payment
                error_log("Clearance payment successful for ID: " . $result->ID);
            }
        }
    }
}

// Return 200 OK response to PayMongo
http_response_code(200);
echo "OK";
?>
