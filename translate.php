<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $text = $_POST['text'];

    // Translate API URL (Google Translate API as an example)
    $apiKey = 'YOUR_GOOGLE_TRANSLATE_API_KEY';
    $url = "https://translation.googleapis.com/language/translate/v2?key=$apiKey";

    // Prepare request data
    $data = [
        'q' => $text,
        'target' => 'gu',
        'source' => 'en',
    ];

    // Make API request
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
    ]);

    $response = curl_exec($ch);
    curl_close($ch);

    // Parse and return the translated text
    $response = json_decode($response, true);
    echo $response['data']['translations'][0]['translatedText'] ?? 'Translation Error';
}
?>
