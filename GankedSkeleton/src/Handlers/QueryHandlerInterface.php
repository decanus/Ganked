<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Skeleton\Handlers
{

    use Ganked\Skeleton\Http\Request\AbstractRequest;
    use Ganked\Skeleton\Models\AbstractModel;

    interface QueryHandlerInterface
    {
        /**
         * @param AbstractRequest $request
         * @param AbstractModel   $model
         */
        public function execute(AbstractRequest $request, AbstractModel $model);
    }
}
