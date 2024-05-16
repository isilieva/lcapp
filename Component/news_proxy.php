<?php
// Remplacez par votre clé API NewsAPI
$apiKey = '0bb8e8eb7b874b76ac2225fd4e202249';
$country = isset($_GET['country']) ? $_GET['country'] : 'fr';

$url = "https://newsapi.org/v2/top-headlines?country=$country&apiKey=$apiKey";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'User-Agent: MyNewsApp/1.0'
]);
$response = curl_exec($ch);
curl_close($ch);

header('Content-Type: application/json');

// Vérifiez si la réponse est valide JSON
if (json_decode($response)) {
    echo $response;
} else {
    echo json_encode(["error" => "Invalid API response"]);
}
?>
