<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

require __DIR__ . '/bootstrap.php';

if (!isset($_GET['task'])) {
    return;
}

$config = new \Ganked\Skeleton\Configuration(__DIR__ . '/config/system.ini');

$redis = new \Redis();
$redis->connect(
    $config->get('redisHost'),
    $config->get('redisPort'),
    1.0
);

$redis->auth($config->get('redisPassword'));

echo $redis->get('currentDataVersion');
exec('php controller.php ' . $_GET['task'] . ' --dataVersion=' . $redis->get('currentDataVersion'));

echo 'Yay';
