<?php
 /**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

$servicesConfig = [];
$initest = '';

foreach (json_decode($_ENV['VCAP_SERVICES'], true) as $serviceProvider) {

    foreach ($serviceProvider as $serviceList) {
        $servicesConfig[$serviceList['name']] = $serviceList['credentials'];

        if ($serviceList['name'] === 'dataPool') {
            $initest .= 'redisHost = "' .  $serviceList['credentials']['host'] . '"' . PHP_EOL;
            $initest .= 'redisPort = "' .  $serviceList['credentials']['port'] . '"' . PHP_EOL;
            $initest .= 'redisPassword = ' .  $serviceList['credentials']['password'] . PHP_EOL;
            $initest .= 'session-redisHost = "' .  $serviceList['credentials']['host'] . '"' . PHP_EOL;
            $initest .= 'session-redisPort = "' .  $serviceList['credentials']['port'] . '"' . PHP_EOL;
            $initest .= 'session-redisPassword = ' .  $serviceList['credentials']['password'] . PHP_EOL;
        }
    }
}

$oldIni = file_get_contents(__DIR__ . '/../config/system.ini');
$newIni = $oldIni . PHP_EOL . $initest;

unlink(__DIR__ . '/../config/system.ini');
file_put_contents(__DIR__ . '/../config/system.ini', $newIni);
