<?php
// Remplacez par votre clé API OpenWeatherMap
$apiKey = '2336b899f0ef4f0c8927433cfab70ac4';
$city = isset($_GET['city']) ? $_GET['city'] : 'Lyon';

$url = "https://api.openweathermap.org/data/2.5/weather?q=$city&appid=$apiKey&units=metric";

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
$response = curl_exec($ch);
curl_close($ch);

header('Content-Type: application/json');
echo $response;
?>
