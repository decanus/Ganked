#!/usr/bin/env php
<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */

namespace Ganked\Backend
{

    require __DIR__ . '/bootstrap.php';

    (new Controller(new Bootstrapper($argv)))->run();

}
