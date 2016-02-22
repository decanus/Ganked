<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */

namespace Ganked\API
{
    require __DIR__ . '/bootstrap.php';

    use Ganked\Skeleton\FrontController;

    (new FrontController(new Bootstrapper()))->run()->send();
}
