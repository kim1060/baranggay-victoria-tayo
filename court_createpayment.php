<?php
require_once("INCLUDE/initialize.php");

// Replace with your PayMongo Secret Key
$secretKey = "sk_test_gzphsV2CD5uGTPHurg9rETyh";

// Collect form data
//$amount = $_POST['amount'] * 100; // Convert to centavo
$amount = 100 * 100;
$ID = $_POST['id'];
// Define the data payload for creating a Payment Link
$data = [
    "data" => [
        "attributes" => [
            "amount" => $amount,
            "currency" => "PHP",
            "description" => "Court Booking Payment",
            "remarks" => "Court Booking Payment",
            "checkout_url" => "https://pm.link/appointmate"
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
    // Redirect to the checkout URL for payment


    header("Location: " . $response['data']['attributes']['checkout_url']);
    //echo $response['data']['attributes']['checkout_url'];
        $date = date('Y-m-d H:i:s');
        $Users = new _court();
        $Users->ApprovedDate         = $date;
        $Users->PaymentReference         = $response['data']['attributes']['checkout_url'];
        $Users->update($ID);
    exit();
} else {
    // Output the error if there was an issue creating the Payment Link
    echo "Error creating payment link: " . print_r($response, true);
}
//echo $response['data']['attributes']['checkout_url'];