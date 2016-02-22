<?php
/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */


$ch = curl_init("https://cdn.ganked.net/version");

curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);

$oldVersion = curl_exec($ch);
curl_close($ch);

$version = time();
$base = __DIR__ . '/..';

if (file_exists($base . '/version')) {
    unlink($base . '/version');
}

file_put_contents($base . '/version', $version);

$files = [
    '/css/style.css',
    '/js/ganked.js',
    '/js/polyfills.js',
];

foreach ($files as $file) {
    $explodedFile = explode('.', $file);

    copy($base . $file, $base . $explodedFile[0] . '-' . $oldVersion . '.' . $explodedFile[1]);
    rename($base . $file, $base . $explodedFile[0] . '-' . $version . '.' . $explodedFile[1]);
    unlink($base . $file);
}
