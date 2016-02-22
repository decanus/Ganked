<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Skeleton\Handlers
{

    use Ganked\Skeleton\Models\AbstractModel;

    interface TransformationHandlerInterface
    {
        /**
         * @param AbstractModel $model
         *
         * @return string
         */
        public function execute(AbstractModel $model);
    }
}
