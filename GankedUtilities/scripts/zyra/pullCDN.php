<?php
/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

error_reporting(E_ALL);

if (!file_exists('/var/www/GankedAssets-new')) {
    exec('cd /var/www && git clone -b master --single-branch git@github.com:Ganked/GankedAssets.git GankedAssets-new > /dev/null 2>/dev/null &');
} else {
    exec('cd /var/www/GankedAssets-new && git clean -f && git reset --hard origin/master > /dev/null 2>/dev/null &');
}

exec('cd /var/www/GankedAssets-new && git pull && ant > /dev/null 2>/dev/null &');
