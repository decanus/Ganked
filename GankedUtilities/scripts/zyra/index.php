<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    return;
}

if (!isset($_SERVER['HTTP_X_GITHUB_EVENT'])) {
    return;
}

switch (strtolower($_SERVER['HTTP_X_GITHUB_EVENT'])) {
    case 'ping':
        echo 'pong';
        break;
    case 'push':

        $data = json_decode(file_get_contents('php://input'), true);

        if (!isset($data['ref'])) {
            return;
        }

        if ($data['ref'] !== 'refs/heads/master') {
            return;
        }

        include __DIR__ . '/pullCDN.php';
        break;
}