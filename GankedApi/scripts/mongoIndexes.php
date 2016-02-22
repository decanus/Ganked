<?php

require __DIR__ . '/../bootstrap.php';

$configuration = new \Ganked\Skeleton\Configuration(__DIR__ . '/../config/system.ini');

$mongo = new \MongoClient($configuration->get('mongoServer'));
$db = $mongo->selectDB($configuration->get('mongoDatabase'));

$db->selectCollection('users')->ensureIndex(['username' => 1], ['unique' => true]);
$db->selectCollection('users')->ensureIndex(['email' => 1], ['unique' => true]);
$db->selectCollection('users')->ensureIndex(['_id' => 1], ['unique' => true]);
$db->selectCollection('users')->ensureIndex(['steamIds.id' => 1], ['unique' => true]);
