<?php
require_once("include/initialize.php");

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
