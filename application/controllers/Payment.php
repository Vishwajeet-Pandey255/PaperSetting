<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Payment extends CI_Controller {

    public function __construct() {
        parent::__construct();

        // Load helpers, models, and libraries
        $this->load->helper(['file', 'directory', 'url', 'form']);
        $this->load->model('Admin_model');
        $this->load->library('email');
        // $this->load->library('session');
    }

    public function pay_payment_new() {
        // Payment API endpoint
    
 
$url = "https://services.aisectonline.com/Services/eWallet/";

$data = array(
    "VLEID" => "12429",
    "OrderId" => "104",
    "Amount" => "5",
    "Client" => "MPOpen",
    "Token" => "MPOpen_SFID:28145972~4548e076093d97d779cdd098d286b180"
);

$payload = json_encode($data);

// Initialize cURL
$ch = curl_init();

// Configure
curl_setopt_array($ch, array(
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST => true,
    CURLOPT_HTTPHEADER => array(
        'Content-Type: application/json',
        'Accept: application/json'
    ),
    CURLOPT_POSTFIELDS => $payload,
    
    // SSL/TLS configuration (critical)
    CURLOPT_SSL_VERIFYPEER => false,
    CURLOPT_SSL_VERIFYHOST => false,
    CURLOPT_SSLVERSION => CURL_SSLVERSION_TLSv1_2, // ✅ Enforce TLS 1.2
));

// Execute
$response = curl_exec($ch);
$error = curl_error($ch);

curl_close($ch);

  $result = json_decode($response, true);
echo "hello";print_r($response);print_r($result);exit;
// Output
if ($error) {
    echo "cURL Error: " . $error;
} else {
    echo "<h3>Response from API:</h3>";
    echo "<pre>" . htmlspecialchars($response) . "</pre>";

    // Optional: parse and show details
    $result = json_decode($response, true);
    if (isset($result['Status']) && $result['Status'] === 'Success') {
        echo "<p><strong>Transaction Success ✅</strong></p>";
        echo "<p>TransactionId: " . $result['TransactionId'] . "</p>";
        echo "<p>ServiceTxnId: " . $result['ServiceTxnId'] . "</p>";
    }
}


 
        
    }
}
