<?php

$dir = __DIR__ . '/../images/lol/rune/';
$host = 'http://ddragon.leagueoflegends.com/cdn/5.22.3';

if (!file_exists($dir)) {
    mkdir($dir);
}

$handle = curl_init($host . '/data/en_US/rune.json');
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($handle);
curl_close($handle);

$data = json_decode($response, true);

foreach($data['data'] as $rune) {
    $handle = curl_init($host . '/img/rune/' . $rune['image']['full']);

    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($handle);
    curl_close($handle);

    $image = fopen($dir . $rune['image']['full'], 'w');

    fwrite($image, $response);
    fclose($image);
}