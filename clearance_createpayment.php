<?php
require_once("include/initialize.php");

// Replace with your PayMongo Secret Key
$secretKey = "sk_test_gzphsV2CD5uGTPHurg9rETyh";

// Collect form data
//$amount = $_POST['amount'] * 100; // Convert to centavo
$amount = 100 * 100;
$ID = $_POST['id'];
// Get the current domain/base URL
$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? 'https' : 'http';
$host = $_SERVER['HTTP_HOST'];
$base_url = $protocol . '://' . $host . dirname($_SERVER['REQUEST_URI']);

// Define the data payload for creating a Payment Link
$data = [
    "data" => [
        "attributes" => [
            "amount" => $amount,
            "currency" => "PHP",
            "description" => "Barangay Clearance Payment",
            "remarks" => "Barangay Clearance Payment",
            "success_url" => $base_url . "/clearance_payment_success.php?id=" . $ID . "&status=success",
            "cancel_url" => $base_url . "/index.php?view=myclearancelist&error=payment_cancelled"
        ]
    ]
];

// Initialize cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, "https://api.paymongo.com/v1/links");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Content-Type: application/json",
    "Authorization: Basic " . base64_encode($secretKey . ":")
]);

// Execute the cURL request
$result = curl_exec($ch);
curl_close($ch);

// Decode the response
$response = json_decode($result, true);

// Check if the Payment Link was created successfully
if (isset($response['data']['attributes']['checkout_url'])) {
    // Store the payment link reference and set status as payment pending
    $date = date('Y-m-d H:i:s');
    $Users = new _clearance();
    $Users->PaymentReference = $response['data']['attributes']['checkout_url'];
    $Users->ApprovedDate = $date; // Set approved date to indicate payment link was created
    // Keep status as 'CONFIRMED' until payment is actually completed
    $Users->update($ID);

    // Redirect to the checkout URL for payment
    header("Location: " . $response['data']['attributes']['checkout_url']);
    exit();
} else {
    // Output the error if there was an issue creating the Payment Link
    echo "Error creating payment link: " . print_r($response, true);
}
//echo $response['data']['attributes']['checkout_url'];