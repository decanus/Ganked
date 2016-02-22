<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */

namespace Ganked\Fetch
{

    use Ganked\Skeleton\FrontController;

    require __DIR__ . '/bootstrap.php';

    (new FrontController(new Bootstrapper()))->run()->send();

}
