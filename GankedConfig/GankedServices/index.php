<?php

// maybe wrap it into a class
if (isset($_SERVER['HTTP_ORIGIN'])) {
    $origin = $_SERVER['HTTP_ORIGIN'];
    if ($origin === 'https://fetch.ganked.net' || $origin === 'https://www.ganked.net' || $origin === 'https://post.ganked.net' ) {
        header('Access-Control-Allow-Origin: ' . $origin);
    }
}
require __DIR__ . '/GankedServices/index.php';
