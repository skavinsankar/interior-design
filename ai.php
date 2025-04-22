<?php

function generateInteriorDesign($imagePath) {
    $apiUrl = 'post https://api.openai.com/v1/images/generations'; // Replace with your AI service endpoint
    $apiKey = 'sk-svcacct-0zZDCYwdT42lzp7gfm9QMvKEtTcP7xlpIlyuyD-PGnQDW-2KRPOdsmFri4nT3BlbkFJz-8-UAoX9Kgo-5CMLL101utsGyAdv6DHoGL1IxrwMbPspawVcSpz8J0RfkwA'; // Replace with your actual API key

    // Prepare the image for upload
    $imageData = new CURLFile($imagePath);

    // Prepare the POST fields
    $postFields = [
        'image' => $imageData,
        'style' => 'modern' // You can change the style based on the AI service's capabilities
    ];

    // Initialize cURL
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: Bearer ' . $apiKey,
        'Content-Type: multipart/form-data'
    ]);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute the request
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    // Check for errors
    if ($httpCode !== 200) {
        die('Error: ' . curl_error($ch));
    }

    // Close cURL
    curl_close($ch);

    // Decode the response (assumed to be JSON)
    $result = json_decode($response, true);

    // Check if the result contains the generated image URL
    if (isset($result['generated_image_url'])) {
        return $result['generated_image_url'];
    } else {
        die('Error: Invalid response format');
    }
}

// Usage
$imagePath = 'path/to/your/image.jpg'; // Replace with the path to your image
$generatedImageUrl = generateInteriorDesign($imagePath);

echo "Generated Interior Design: <img src=\"$generatedImageUrl\" alt=\"Generated Interior Design\">";
?>
