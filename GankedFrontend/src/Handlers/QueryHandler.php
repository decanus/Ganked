<?php

/**
 * Copyright (c) Ganked 2015
 * All rights reserved.
 */

namespace Ganked\Frontend\Handlers
{

    use Ganked\Skeleton\Handlers\QueryHandlerInterface;
    use Ganked\Skeleton\Http\Request\AbstractRequest;
    use Ganked\Skeleton\Models\AbstractModel;

    class QueryHandler implements QueryHandlerInterface
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
