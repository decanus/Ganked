<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Skeleton\Handlers
{

    use Ganked\Skeleton\Http\Response\ResponseInterface;
    use Ganked\Skeleton\Models\AbstractModel;

    interface ResponseHandlerInterface
    {
        /**
         * @param ResponseInterface $responseInterface
         * @param AbstractModel     $model
         */
        public function execute(ResponseInterface $responseInterface, AbstractModel $model);
    }
}
