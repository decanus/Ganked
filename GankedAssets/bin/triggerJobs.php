<?php

$jobs = [
    'GankedFrontend-release',
];

foreach ($jobs as $job) {

    $curl = curl_init('http://178.62.33.45:8080/buildByToken/build?job=' . $job . '&token=62d8aca5-bbb5-4034-8861-0f551e84c8fd');
    curl_setopt($curl, CURLOPT_POST, 1);
    curl_exec($curl);
    curl_close($curl);

}
