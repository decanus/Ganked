<?php
/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

require __DIR__ . '/bootstrap.php';

$config = new \Ganked\Skeleton\Configuration(__DIR__ . '/config/system.ini');

$redis = new \Redis();
$redis->connect(
    $config->get('redisHost'),
    $config->get('redisPort'),
    1.0
);

$redis->auth($config->get('redisPassword'));


if (!isset($_GET['message'])) {
    $redis->set('infoBarEnabled', 'false');
}

if (isset($_GET['message'])) {
    $redis->set('infoBarEnabled', 'true');
    $redis->set('infoBarMessage', $_GET['message']);
}