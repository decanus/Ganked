<?php

/**
 * Copyright (c) Dean Eigenmann 2015
 * All rights reserved.
 */
 
namespace Ganked\Frontend\Handlers
{

    use Ganked\Skeleton\Models\AbstractPageModel;

    interface HandlerInterface
    {
        /**
         * @param AbstractPageModel $model
         */
        public function run(AbstractPageModel $model);
    }
}
