<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Skeleton\Handlers
{

    use Ganked\Skeleton\Models\AbstractModel;

    interface PostHandlerInterface
    {
        /**
         * @param AbstractModel $model
         */
        public function execute(AbstractModel $model);
    }
}
