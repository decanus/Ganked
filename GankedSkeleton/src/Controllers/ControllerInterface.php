<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Skeleton\Controllers
{

    use Ganked\Skeleton\Http\Request\RequestInterface;
    use Ganked\Skeleton\Http\Response\ResponseInterface;

    interface ControllerInterface
    {
        /**
         * @param RequestInterface $request
         *
         * @return ResponseInterface
         */
        public function execute(RequestInterface $request);
    }
}
