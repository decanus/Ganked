<?php

$dir = __DIR__ . '/../images/raw/lol/item/';

if (!file_exists($dir)) {
    mkdir($dir, 0777, true);
}

$versionHandle = curl_init('https://ddragon.leagueoflegends.com/api/versions.json');
curl_setopt($versionHandle, CURLOPT_RETURNTRANSFER, true);

$versions = json_decode(curl_exec($versionHandle), true);
curl_close($versionHandle);

echo 'Using version ' . $versions[0] . PHP_EOL;

$host = 'http://ddragon.leagueoflegends.com/cdn/' . $versions[0];

$handle = curl_init($host . '/data/en_US/item.json');
curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($handle);
curl_close($handle);

$data = json_decode($response, true);

echo 'Downloading...' . PHP_EOL;

foreach($data['data'] as $rune) {
    $handle = curl_init($host . '/img/item/' . $rune['image']['full']);

    curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);

    $response = curl_exec($handle);
    curl_close($handle);

    $image = fopen($dir . $rune['image']['full'], 'w');

    fwrite($image, $response);
    fclose($image);
}