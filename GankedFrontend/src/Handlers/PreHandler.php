<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Handlers
{

    use Ganked\Skeleton\Handlers\PreHandlerInterface;
    use Ganked\Skeleton\Http\Request\AbstractRequest;
    use Ganked\Skeleton\Models\AbstractModel;

    class PreHandler implements PreHandlerInterface
    {

        /**
         * @param AbstractRequest $request
         * @param AbstractModel   $model
         */
        public function execute(AbstractRequest $request, AbstractModel $model)
        {
        }
    }
}
