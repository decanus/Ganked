<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Handlers
{

    use Ganked\Skeleton\Handlers\TransformationHandlerInterface;
    use Ganked\Skeleton\Models\AbstractModel;

    class TransformationHandler implements TransformationHandlerInterface
    {

        /**
         * @param AbstractModel $model
         *
         * @return string
         */
        public function execute(AbstractModel $model)
        {
        }
    }
}
